<?php

class GearTagPeer extends BaseGearTagPeer
{
    public static function getTagName($gearId)
    {
        if($gearId)
        {
            return DbFinder::from('Tag')
                ->join('GearTag')
                ->where('GearTag.GearId', $gearId)
                ->findOne();
        }
        else
            return false;
    }
}
