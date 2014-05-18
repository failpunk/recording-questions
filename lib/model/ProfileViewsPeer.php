<?php

class ProfileViewsPeer extends BaseProfileViewsPeer
{
    static public function getRecentView($userId, $ipNumber)
    {
        return DbFinder::from('ProfileViews')
                ->where('userId', $userId)
                ->where('Ip', $ipNumber)
                ->findOne();
    }

    static public function getViewCount($userId)
    {
        return DbFinder::from('ProfileViews')
                ->where('userId', $userId)
                ->count();
    }
}
