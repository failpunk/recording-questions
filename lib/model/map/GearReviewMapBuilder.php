<?php


/**
 * This class adds structure of 'gear_review' table to 'propel' DatabaseMap object.
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
class GearReviewMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.GearReviewMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(GearReviewPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(GearReviewPeer::TABLE_NAME);
		$tMap->setPhpName('GearReview');
		$tMap->setClassname('GearReview');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addForeignKey('GEAR_ID', 'GearId', 'INTEGER', 'gear', 'ID', true, null);

		$tMap->addForeignKey('USER_ID', 'UserId', 'INTEGER', 'user', 'ID', true, null);

		$tMap->addColumn('TYPE', 'Type', 'TINYINT', true, null);

		$tMap->addColumn('URL', 'Url', 'LONGVARCHAR', true, null);

		$tMap->addColumn('TITLE', 'Title', 'VARCHAR', true, 150);

		$tMap->addColumn('SUMMARY', 'Summary', 'LONGVARCHAR', true, null);

		$tMap->addColumn('REVIEW', 'Review', 'LONGVARCHAR', true, null);

		$tMap->addColumn('VISIBLE', 'Visible', 'TINYINT', true, null);

		$tMap->addColumn('PUBLISHED_DATE', 'PublishedDate', 'TIMESTAMP', true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null);

	} // doBuild()

} // GearReviewMapBuilder
