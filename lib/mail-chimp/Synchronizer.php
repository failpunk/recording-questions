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

/** @see Galahad_MailChimp_User */
require_once 'User.php';

/**
 * MailChimp Sync Class
 * 
 * This is the base class for any syncronization.  You cannot instantiate this
 * class as it is.  Either subclass it or use one of the provided implementations.
 *
 * @category  Galahad
 * @package   Galahad_MailChimp
 * @copyright Copyright (c) 2009 Chris Morrell <http://cmorrell.com>
 * @license   GPL <http://www.gnu.org/licenses/>
 */
abstract class Galahad_MailChimp_Synchronizer 
{
	/**
	 * MailChimp API Object
	 *
	 * @var MCAPI
	 */
	protected $_mailChimp;
	
	/**
	 * Default options for MailChimp API calls
	 *
	 * @var array
	 */
	protected $_mailChimpOptions = array(
		'doubleOptIn' => false,
		'replaceInterests' => true,
		'sendGoodby' => false,
		'sendNotify' => false,
	);
	
	/**
	 * Number of addresses to handle in batch
	 *
	 * @var int
	 */
	protected $_batchSize = 500;
	
	/**
	 * Log of all batch operations
	 *
	 * @var array
	 */
	protected $_batchLog = array();
	
	/**
	 * Log of all batch errors
	 *
	 * @var array
	 */
	protected $_batchErrors = array();
	
	/**
	 * List of users that should be updated at MailChimp
	 *
	 * @var string
	 */
	protected $_updateUsers = array();
	
	/**
	 * Constructor
	 *
	 * @param string $mailChimpUser
	 * @param string $mailChimpPassword
	 */
	public function __construct($mailChimpUser, $mailChimpPassword, $batchSize = 500)
	{
		if (!class_exists('MCAPI')) {
			throw new Galahad_MailChimp_Synchronizer_Exception('The MailChimp MCAPI class is required to use Galahad_MailChimp_Synchronizer.');
		}
		
		$this->_mailChimp = new MCAPI($mailChimpUser, $mailChimpPassword);
		$this->_batchSize = $batchSize;
	}
	
	/**
	 * Sync databases
	 * 
	 */
	public function sync($listId)
	{
		$this->processMailChimpUsers($listId);
		$this->processLocalUsers($listId);
	}
	
	public function setBatchSize($batchSize)
	{
		$this->_batchSize = $batchSize;
	}
	
	public function setMailChimpOptions($doubleOptIn = false, $replaceInterests = true, $sendGoodby = false, $sendNotify = false)
	{
		$this->_mailChimpOptions = array(
			'doubleOptIn' => $doubleOptIn,
			'replaceInterests' => $replaceInterests,
			'sendGoodby' => $sendGoodby,
			'sendNotify' => $sendNotify,
		);
	}
	
	public function getBatchLog()
	{
		return $this->_batchLog;
	}
	
	public function getBatchErrorLog()
	{
		if (!count($this->_batchErrors)) {
			return false;
		}
		
		return $this->_batchErrors;
	}
	
	/**
	 * Gets a iterators of users
	 *
	 * @param string $listId
	 * @return Iterator
	 */
	abstract protected function getUsers($listId = null, $batchNumber);
	
	/**
	 * Determines if a user exists
	 *
	 * @param string $email
	 * @param string $listId
	 * @return bool
	 */
	abstract protected function userExists($email, $listId = null);
	
	/**
	 * Runs through all the MailChimp users for a given list
	 *
	 * @param string $listId
	 */
	protected function processMailChimpUsers($listId)
	{
		$unsubscribe = array();
		$start = 0;
		
		do {
			$batch = $this->_mailChimp->listMembers($listId, 'subscribed', $start, $this->_batchSize);
			$start++;
			foreach ($batch as $row) {
				if (!$this->userExists($row['email'], $listId)) {
					$unsubscribe[] = $row['email'];
				}
			}
		} while (count($batch) == $this->_batchSize);
		
		$unsubscribe = array_chunk($unsubscribe, $this->_batchSize);
		foreach ($unsubscribe as $i => $batch) {
			$batchResult = $this->_mailChimp->listBatchUnsubscribe($listId, $batch, true, $this->_mailChimpOptions['sendGoodby'], $this->_mailChimpOptions['sendNotify']);
			if (!$batchResult) {
				throw new Galahad_MailChimp_Synchronizer_Exception('Error with batch unsubscribe: ' . $this->_mailChimp->errorMessage);
			} else {
				$this->_batchLog[] = "Unsubscribe Batch {$i}: {$batchResult['success_count']} Succeeded";
				$this->_batchLog[] = "Unsubscribe Batch {$i}: {$batchResult['error_count']} Failed";
				if ($batchResult['error_count']) {
					$this->_batchErrors["Unsubscribe Batch {$i}"] = $batchResult['errors'];
				}
			}
			unset($unsubscribe[$i]);
		}
		
		unset($batch);
		unset($unsubscribe);
	}
	
	/**
	 * Runs through all local users for a given list
	 *
	 * @param string $listId
	 */
	protected function processLocalUsers($listId)
	{
		$batch = 0;
		$results = array(
			'successCount' => 0,
			'errorCount' => 0,
			'errors' => array(),
		);
		
		while($users = $this->getUsers($listId, $batch++, $this->_batchSize)) {
			$batchResult = $this->_mailChimp->listBatchSubscribe($listId, $users, $this->_mailChimpOptions['doubleOptIn'], true, true);
			if ($this->_mailChimp->errorCode) {
				throw new Galahad_MailChimp_Synchronizer_Exception('Error with batch subscribe: ' . $this->_mailChimp->errorMessage);
			} else {
				$this->_batchLog[] = "Subscribe Batch {$batch}: {$batchResult['success_count']} Succeeded";
				$this->_batchLog[] = "Subscribe Batch {$batch}: {$batchResult['error_count']} Failed";
				if ($batchResult['error_count']) {
					$this->_batchErrors["Subscribe Batch {$batch}"] = $batchResult['errors'];
				}
			}
		}
	}
}