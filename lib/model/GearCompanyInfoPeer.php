<?php

class GearCompanyInfoPeer extends BaseGearCompanyInfoPeer
{
    public static function getLatestRevision($companyId)
    {
        if($companyId)
        {
            return DbFinder::from('GearCompanyInfo')
                ->where('companyId', $companyId)
                ->orderBy('id', 'desc')
                ->findOne();
        }
        else
            return false;
    }
}
