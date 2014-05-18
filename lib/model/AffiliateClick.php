<?php

class AffiliateClick extends BaseAffiliateClick
{
    public static function recordClick($userId, $affiliateId, $gearId)
    {
        $click = new AffiliateClick();
        $click->setUserId($userId);
        $click->setAffiliateId($affiliateId);
        $click->setGearId($gearId);

        $click->save();
    }
}
