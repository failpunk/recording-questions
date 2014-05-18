<?php

class GearCompanyTagPeer extends BaseGearCompanyTagPeer
{
    public static function getTagName($companyId)
    {
        if($companyId)
        {
            return DbFinder::from('Tag')
                ->join('GearCompanyTag')
                ->where('GearCompanyTag.CompanyId', $companyId)
                ->findOne();
        }
        else
            return false;
    }
}
