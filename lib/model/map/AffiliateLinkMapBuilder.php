<?php


/**
 * This class adds structure of 'affiliate_link' table to 'cj' DatabaseMap object.
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
class AffiliateLinkMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AffiliateLinkMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(AffiliateLinkPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(AffiliateLinkPeer::TABLE_NAME);
		$tMap->setPhpName('AffiliateLink');
		$tMap->setClassname('AffiliateLink');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addColumn('SKU', 'Sku', 'INTEGER', true, null);

		$tMap->addColumn('NAME', 'Name', 'VARCHAR', false, 100);

		$tMap->addColumn('COMPANY', 'Company', 'VARCHAR', false, 100);

		$tMap->addColumn('PRICE', 'Price', 'DECIMAL', false, null);

		$tMap->addColumn('BUY_URL', 'BuyUrl', 'LONGVARCHAR', false, null);

		$tMap->addColumn('IMPRESSION_URL', 'ImpressionUrl', 'LONGVARCHAR', false, null);

		$tMap->addColumn('CATEGORY', 'Category', 'VARCHAR', true, 255);

		$tMap->addColumn('LAST_UPDATE', 'LastUpdate', 'TIMESTAMP', true, null);

	} // doBuild()

} // AffiliateLinkMapBuilder
