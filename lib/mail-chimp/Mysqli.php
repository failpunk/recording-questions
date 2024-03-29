<?php
/**
 * This file is part of the Galahad MailChimp Synchronizer.
 * 
 * The Galahad MailChimp Synchronizer is free software: you can redistribute
 * it and/or modify it under the terms of the GNU General Public License as 
 * published by the Free Software Foundation, either version 3 of the 
 * License, or (at your option) any later version.
 * 
 * The Galahad MailChimp Synchronizer is distributed in the hope that it 
 * will be useful, but WITHOUT ANY WARRANTY; without even the implied 
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See 
 * the GNU General Public License for more details.
 * 
 * @category  Galahad
 * @package   Galahad_MailChimp
 * @copyright Copyright (c) 2009 Chris Morrell <http://cmorrell.com>
 * @license   GPL <http://www.gnu.org/licenses/>
 * @version   0.1.1
 */

/** @see Galahad_MailChimp_Synchronizer */
require_once 'Synchronizer.php';

/** @see Galahad_MailChimp_User */
require_once 'User.php';

/**
 * MySQLi Synchronizer
 * 
 * Can be used for simple syncronization between a MySQL database
 * and MailChimp.  Requires the PHP MySQLi extension.
 * 
 * @category  Galahad
 * @package   Galahad_MailChimp
 * @copyright Copyright (c) 2009 Chris Morrell <http://cmorrell.com>
 * @license   GPL <http://www.gnu.org/licenses/>
 */
class Galahad_MailChimp_Synchronizer_Mysqli extends Galahad_MailChimp_Synchronizer 
{
	/**
	 * Database object
	 *
	 * @var mysqli
	 */
	protected $_db;
	
	/**
	 * Query used to determine if a user exists
	 *
	 * @var string
	 */
	protected $_userExistsQuery;
	
	/**
	 * Statement to determine if a user exists
	 *
	 * @var mysqli_stmt
	 */
	protected $_userExistsStatement;
	
	/**
	 * Query to fetch users
	 *
	 * @var string
	 */
	protected $_query;
	
	/**
	 * Columns to use as merge variables
	 *
	 * @var array
	 */
	protected $_mergeColumns = array();
	
	/**
	 * Constructor
	 *
	 * @param string $mailChimpUser
	 * @param string $mailChimpPassword
	 * @param array $mysqliOptions
	 * @param array $tableOptions
	 */
	function __construct($mailChimpUser, $mailChimpPassword, Array $mysqliOptions, $userExistsQuery = null, $query = null, Array $mergeColumns = null)
	{
		$mysqliOptionDefaults = array(
			'host' => ini_get('mysqli.default_host'),
			'username' => ini_get('mysqli.default_user'),
			'passwd' => ini_get('mysqli.default_pw'),
			'dbname' => '',
			'port' => ini_get('mysqli.default_port'),
			'socket' => ini_get('mysqli.default_socket'),
		);
		$mysqliOptions = array_merge($mysqliOptionDefaults, $mysqliOptions);
		$this->_db = new mysqli($mysqliOptions['host'], $mysqliOptions['username'], $mysqliOptions['passwd'], $mysqliOptions['dbname'], $mysqliOptions['port'], $mysqliOptions['socket']);
		
		if ($this->_db->connect_errno) {
			throw new Exception($this->_db->connect_error);
		}
		
		if (null !== $query) {
			if (empty($query)) {
				throw new Galahad_MailChimp_Synchronizer_Exception('Selection query cannot be empty');
			}
			$this->_query = $query;
		}
		
		if (null !== $mergeColumns) {
			if (!is_array($mergeColumns)) {
				throw new Galahad_MailChimp_Synchronizer_Exception('$mergeColumns must be an array');
			}
			if (!in_array('EMAIL', $mergeColumns)) {
				throw new Galahad_MailChimp_Synchronizer_Exception('mergeColumns must at least include an EMAIL column');
			}
			$this->_mergeColumns = $mergeColumns;
		}
		
		parent::__construct($mailChimpUser, $mailChimpPassword);
	}
	
	/**
	 * Syncs a database table w/ MailChimp
	 * 
	 * The last three parameters are optional if you passed them in the constructor.
	 * $mergeColumns should be an array of DBCOLNAME => MERGEVARNAME
	 *
	 * @param string $listId
	 * @param string $query
	 * @param string $userExistsQuery
	 * @param string $emailColumn
	 * @param array  $mergeColumns
	 */
	public function sync($listId)
	{
		$arguments = func_get_args();
		
		// Populate Query
		if (isset($arguments[1])) {
			$this->_query = $arguments[1];
		}
		
		// User exists query
		if (isset($arguments[2])) {
			$this->_userExistsQuery = $arguments[2];
		}
				
		// Populate Merge Columns
		if (isset($arguments[3])) {
			$this->_mergeColumns = $arguments[3];
		}
		
		// Error check
		if (!in_array('EMAIL', $this->_mergeColumns)) {
			throw new Exception('Your merge columns must at minimum include an EMAIL field.');
		}
				
		parent::sync($listId);
	}
	
	/**
	 * Gets an Iterator of Galahad_MailChimp_User objects
	 *
	 * @param string $listId
	 */
	protected function getUsers($listId = null, $batchNumber)
	{
		$start = $batchNumber * $this->_batchSize;
		$result = $this->_db->query($this->_query . " LIMIT {$start}, {$this->_batchSize}");
		
		if (false === $result) {
			throw new Galahad_MailChimp_Synchronizer_Exception('Error getting users from DB: ' . $this->_db->error);
		}
		
		$return = array();
		while ($row = $result->fetch_assoc()) {
			$user = array();
			foreach ($this->_mergeColumns as $localColumn => $mcColumn) {
				if (isset($row[$localColumn])) {
					$user[$mcColumn] = $row[$localColumn];
				}
			}
			
			$return[] = $user;
		}
		
		return $return;
	}
	
	/**
	 * Determines if a user exists in the database
	 *
	 * @param string $email
	 * @param string $listId
	 * @return bool
	 */
	protected function userExists($email, $listId = null)
	{
		$statement = $this->_userExistsStatement;
		if (!($statement instanceof mysqli_stmt)) {
			$statement = $this->_db->prepare($this->_userExistsQuery);
		}
		
		$statement->bind_param('s', $email);
		$statement->bind_result($result);
		
		$statement->execute();
		$statement->fetch();
		$statement->free_result();
		
		return (bool) $result;
	}
}