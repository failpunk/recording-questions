<?php

class AwardPeer extends BaseAwardPeer
{
    public static function getAllAwards()
    {
        return DbFinder::from('Award')
            ->orderBy('Type')
            ->find();
    }
}
