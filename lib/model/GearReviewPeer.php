<?php

class GearReviewPeer extends BaseGearReviewPeer
{
    public static function getLatestSiteReviews($gearId, $limit = 15)
    {
        return DbFinder::from('GearReview')
                ->where('GearId', $gearId)
                ->where('Type', 0)
                ->where('Visible', 1)
                ->orderBy('CreatedAt')
                ->limit($limit)
                ->find();
    }
    
    public static function getLatestUserReviews($gearId, $limit = 15)
    {
        return DbFinder::from('GearReview')
                ->where('GearId', $gearId)
                ->where('Type', 1)
                ->where('Visible', 1)
                ->orderBy('CreatedAt')
                ->limit($limit)
                ->find();
    }

    public static function getReviewCount($gearId)
    {
        return DbFinder::from('GearReview')
                ->where('GearId', $gearId)
                ->where('Visible', 1)
                ->count();
    }

    public static function getCount($userId = false, $reviewType = 1)
    {
        $finder = DbFinder::from('GearReview')
                ->where('Type', $reviewType);

        if($userId) {
            $finder->where('UserId', $userId);
        }
                
        return $finder->count();
    }

    public static function getReviewsForSitemap($limit = 1, $offset = 0)
    {
        return DbFinder::from('GearReview')
                ->join('Gear')
                ->join('GearCompany')
                ->where('Type', 1)
                ->select(array('GearReview.Title', 'GearReview.UpdatedAt', 'GearReview.GearId', 'GearReview.Id', 'GearCompany.Name', 'Gear.Name'))
                ->limit($limit)
                ->offset($offset)
                ->find();
    }

    public static function getSiteReviewLeaders($limit = 3)
    {
        return DbFinder::from('GearReview')
            ->join('User')
            ->withColumn('count(GearReview.UserId)', 'total')
            ->with('User')
            ->where('GearReview.Type', 0)
            ->where('GearReview.UserId', 'not in', array(2,4))
            ->groupBy('GearReview.UserId')
            ->orderBy('total', 'desc')
            ->limit($limit)
            ->find();
    }

    public static function getUserReviewLeaders($limit = 3)
    {
        return DbFinder::from('GearReview')
            ->join('User')
            ->withColumn('count(GearReview.UserId)', 'total')
            ->with('User')
            ->where('GearReview.Type', 1)
            ->where('GearReview.UserId', 'not in', array(2,4))
            ->groupBy('GearReview.UserId')
            ->orderBy('total', 'desc')
            ->limit($limit)
            ->find();
    }
}
