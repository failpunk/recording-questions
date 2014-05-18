<?php

class GearInfoPeer extends BaseGearInfoPeer
{
    public static function getLatestRevision($gearId)
    {
        if($gearId)
        {
            return DbFinder::from('GearInfo')
                ->where('gearId', $gearId)
                ->orderBy('id', 'desc')
                ->findOne();
        }
        else
            return false;
    }
    
    public static function getNewGearLeaders($limit = 3)
    {
        return DbFinder::from('GearInfo')
            ->join('User')
            ->withColumn('count(GearInfo.UserId)', 'total')
            ->with('User')
            ->where('GearInfo.UserId', 'not in', array(2,4))      // exclude recording question users
            ->groupBy('GearInfo.UserId')
            ->orderBy('total', 'desc')
            ->limit($limit)
            ->find();
    }
}
