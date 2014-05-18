<?php

class RecentActivityPeer extends BaseRecentActivityPeer
{
    public static function getActivity($page = '', $perPage = 15)
    {
        $finder = DbFinder::from('RecentActivity')
            ->join('User')
            ->withColumn('User.displayName', 'displayName')
            ->withColumn('User.email', 'email')
            ->orderBy('id', 'desc');

        if($page)
            return $finder->paginate($page, $perPage);
        else
            return $finder->limit($perPage)->find();
    }

    public static function countGearAddedByUser($userId)
    {
        return DbFinder::from('RecentActivity')
            ->where('UserId', $userId)
            ->where('Activity', 'created')
            ->count();
    }

    public static function getActivityByUserId($userId, $seconds = 600)
    {
        $time = date('Y-m-d h:i:s', time() - $seconds);

        return DbFinder::from('RecentActivity')
            ->where('UserId', $userId)
            ->where('CreatedAt', '>', $time)
            ->find();
    }

    static public function getBetweenDates($from, $to, $action = false)
    {
        if(!$from) {
            $from = '2009-01-01 00:00:00';
        }

        if(!$to) {
            $to = '2099-01-01 00:00:00';
        }

        $finder = DbFinder::from('RecentActivity');
        
        if($action) {
            $finder->where('Activity', $action);
        }

        $finder->filterBy('CreatedAt', array('from' => $from, 'to' => $to));
        
        return $finder->count();
    }
}
