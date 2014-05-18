<?php


/**
 * This class adds structure of 'question' table to 'propel' DatabaseMap object.
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
class QuestionMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.QuestionMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(QuestionPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(QuestionPeer::TABLE_NAME);
		$tMap->setPhpName('Question');
		$tMap->setClassname('Question');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'user', 'ID', true, null);

		$tMap->addColumn('TAG_ID', 'TagId', 'INTEGER', false, null);

		$tMap->addColumn('TITLE', 'Title', 'VARCHAR', false, 255);

		$tMap->addColumn('DESCRIPTION', 'Description', 'LONGVARCHAR', false, null);

		$tMap->addColumn('OFFENSIVE', 'Offensive', 'INTEGER', true, null);

		$tMap->addColumn('VISIBLE', 'Visible', 'INTEGER', true, null);

		$tMap->addColumn('LOCKED', 'Locked', 'INTEGER', true, null);

		$tMap->addColumn('UPVOTES', 'Upvotes', 'INTEGER', true, null);

		$tMap->addColumn('DOWNVOTES', 'Downvotes', 'INTEGER', true, null);

		$tMap->addColumn('VISITED', 'Visited', 'INTEGER', true, null);

		$tMap->addColumn('NOTIFY_EMAIL', 'NotifyEmail', 'VARCHAR', false, 150);

		$tMap->addColumn('TWEETED', 'Tweeted', 'TINYINT', false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', true, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', true, null);

	} // doBuild()

} // QuestionMapBuilder
