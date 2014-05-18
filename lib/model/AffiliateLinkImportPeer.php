<?php

class AffiliateLinkImportPeer extends BaseAffiliateLinkImportPeer
{
    public static function insertLink(array $data)
    {
        if(!isset($data[7]))
          return;

        $con = Propel::getConnection(self::DATABASE_NAME);

        $sql = "
            insert into affiliate_link_import
                (id, sku, name, company, price, buy_url, impression_url, category, last_update)
            values
                (null, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $con->Prepare($sql);
        $stmt->bindValue(1, $data[7]);
        $stmt->bindValue(2, $data[4]);
        $stmt->bindValue(3, $data[8]);
        $stmt->bindValue(4, str_replace(',', '', $data[14]));
        $stmt->bindValue(5, $data[17]);
        $stmt->bindValue(6, $data[18]);
        $stmt->bindValue(7, $data[20]);
        $stmt->bindValue(8, date('Y-m-d', strtotime($data[3])));

        $stmt->execute();
    }

    public static function getLink($searchString)
    {
        $con = Propel::getConnection(self::DATABASE_NAME);

        $booleanString = myUtil::unslugify($searchString);

        $sql = "SELECT *, MATCH(name) AGAINST('$booleanString*' IN BOOLEAN MODE) as score
                FROM affiliate_link_import
                WHERE MATCH(name) AGAINST('$booleanString*' IN BOOLEAN MODE)
                order by score desc
                limit 1";

        $stmt = $con->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetch();

        $affiliateLink = new AffiliateLink();
        $affiliateLink->setId($results['id']);
        $affiliateLink->setSku($results['sku']);
        $affiliateLink->setName($results['name']);
        $affiliateLink->setCompany($results['company']);
        $affiliateLink->setPrice($results['price']);
        $affiliateLink->setBuyUrl($results['buy_url']);
        $affiliateLink->setImpressionUrl($results['impression_url']);
        $affiliateLink->setCategory($results['category']);
        $affiliateLink->setLastUpdate($results['last_update']);

        return $affiliateLink;
    }

    public static function truncate()
    {
        $con = Propel::getConnection(self::DATABASE_NAME);

        $sql = "truncate table affiliate_link_import;";

        $stmt = $con->Prepare($sql);
        $stmt->execute();
    }

    public static function getBySku($sku)
    {
        return DbFinder::from('AffiliateLinkImport')
                ->where('sku', $sku)
                ->findOne();
    }
}
