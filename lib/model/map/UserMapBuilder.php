<?php


/**
 * This class adds structure of 'user' table to 'propel' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class UserMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.UserMapBuilder';

	/**
	 * The database map.
	 */
	private $dbMap;

	/**
	 * Tells us if this DatabaseMapBuilder is built so that we
	 * don't have to re-build it every time.
	 *
	 * @return     boolean true if this DatabaseMapBuilder is built, false otherwise.
	 */
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	/**
	 * Gets the databasemap this map builder built.
	 *
	 * @return     the databasemap
	 */
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	/**
	 * The doBuild() method builds the DatabaseMap
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap(UserPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(UserPeer::TABLE_NAME);
		$tMap->setPhpName('User');
		$tMap->setClassname('User');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addColumn('EMAIL', 'Email', 'VARCHAR', true, 64);

		$tMap->addColumn('DISPLAY_NAME', 'DisplayName', 'VARCHAR', true, 255);

		$tMap->addColumn('REAL_NAME', 'RealName', 'VARCHAR', true, 255);

		$tMap->addColumn('LOCATION', 'Location', 'VARCHAR', false, 255);

		$tMap->addColumn('WEBPAGE', 'Webpage', 'VARCHAR', false, 255);

		$tMap->addColumn('COUNTRY', 'Country', 'VARCHAR', false, null);

		$tMap->addColumn('POSTAL_CODE', 'PostalCode', 'INTEGER', false, null);

		$tMap->addColumn('BIRTHDAY', 'Birthday', 'TIMESTAMP', false, null);

		$tMap->addColumn('GRAVATAR_ADDRESS', 'GravatarAddress', 'VARCHAR', false, 255);

		$tMap->addColumn('INFO', 'Info', 'LONGVARCHAR', false, null);

		$tMap->addColumn('PLATFORM', 'Platform', 'VARCHAR', false, 6);

		$tMap->addColumn('EXPERIENCE_SCORE', 'ExperienceScore', 'INTEGER', true, null);

		$tMap->addColumn('UP_VOTES', 'UpVotes', 'INTEGER', true, null);

		$tMap->addColumn('DOWN_VOTES', 'DownVotes', 'INTEGER', true, null);

		$tMap->addColumn('IS_GUEST', 'IsGuest', 'TINYINT', true, null);

		$tMap->addColumn('IS_ADMIN', 'IsAdmin', 'TINYINT', true, null);

		$tMap->addColumn('TODAY_VOTES', 'TodayVotes', 'INTEGER', true, null);

		$tMap->addColumn('EMAIL_ON', 'EmailOn', 'TINYINT', true, null);

		$tMap->addColumn('LAST_EMAIL', 'LastEmail', 'TIMESTAMP', true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', true, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', true, null);

	} // doBuild()

} // UserMapBuilder
