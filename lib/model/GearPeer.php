<?php

class GearPeer extends BaseGearPeer
{
    public static function getCountByCompany($companyId)
    {
        if($companyId)
        {
            return DbFinder::from('Gear')
                    ->where('Gear.Visible', true)
                    ->join('GearCompany')
                    ->where('GearCompany.Id', $companyId)
                    ->where('GearCompany.Visible', true)
                    ->count();
        }
        else
            return false;
    }

    public static function getByCompany($companyId, $page = '', $perPage = 15)
    {
        $finder = DbFinder::from('Gear')
                ->join('GearCompany')
                ->where('companyId', $companyId)
                ->where('Visible', true);

        if($page)
            return $finder->paginate($page, $perPage);
        else
            return $finder->limit($perPage)->find();
    }

    public static function getByName($name)
    {
        if($name)
        {
            return DbFinder::from('Gear')
                    ->where('Name', $name)
                    ->where('Visible', true)
                    ->findOne();
        }
        else
            return false;
    }

    public static function getNewestForList($page = '', $perPage = 15)
    {
        $finder = DbFinder::from('Gear')
                ->join('GearCompany')
                ->where('Visible', true)
                ->orderBy('CreatedAt', 'desc');

        if($page)
            return $finder->paginate($page, $perPage);
        else
            return $finder->find();
    }

    public static function getByCategoryForList($category, $page = '', $perPage = 15)
    {
        $finder = DbFinder::from('Gear')
                ->join('GearCompany')
                ->where('Visible', true)
                ->where('Section', $category)
                ->orderBy('CreatedAt', 'desc');

        if($page)
            return $finder->paginate($page, $perPage);
        else
            return $finder->find();
    }

    public static function getByUser($userId)
    {
        if($userId)
        {
            return DbFinder::from('Gear')
                    ->join('UserGear')
                    ->withColumn('UserGear.userHas', 'user_has')
                    ->withColumn('UserGear.userWants', 'user_wants')
                    ->withColumn('UserGear.userHad', 'user_had')
                    ->where('UserGear.userId', $userId)
                    ->find();
        }
    }

    public static function findLike(array $string, $limit = 30)
    {
        if(count($string) > 0)
        {
            $finder =  DbFinder::from('Gear')
                    ->join('GearCompany');

            foreach($string as $i => $value)
            {
                $value = trim($value);

                if($i == 0)
                {
                    $finder->where("Gear.Name", "like", "%$value%");
                } else
                {
                    $finder->orWhere("Gear.Name", "like", "%$value%");
                }
            }

            $finder->select(array('Gear.Id', 'Gear.Name', 'GearCompany.Name'), sfModelFinder::SIMPLE);

            return $finder->limit($limit)->find();
        }
        else
            return false;
    }

    public static function getCount()
    {
        return DbFinder::from('Gear')->count();
    }

    public static function getCategoryCounts($limit = 20)
    {
        return DbFinder::from('Gear')
                ->withColumn('COUNT(Id)', 'Count')
                ->groupBy('Section')
                ->orderBy('Count', 'desc')
                ->limit($limit)
                ->find();
    }

    public static function getGearForSitemap($limit = 1, $offset = 0)
    {
        return DbFinder::from('Gear')
                ->join('GearCompany')
                ->select(array(
                    'Gear.Id',
                    'Gear.Name',
                    'Gear.UpdatedAt',
                    'GearCompany.Name',
                ))
                ->limit($limit)
                ->offset($offset)
                ->find();
    }

    public static function getNewestForRss($perPage = 15)
    {
        $finder = DbFinder::from('Gear')
                ->join('GearCompany')
                ->join('GearInfo')
                ->where('Visible', true)
                ->select(array(
                    'Gear.Id',
                    'Gear.Name',
                    'Gear.Section',
                    'Gear.UpdatedAt',
                    'GearCompany.Id',
                    'GearCompany.Name',
                    'GearInfo.about',
                    'GearInfo.createdAt'
                ))
                ->groupBy('GearInfo.GearId')
                ->orderBy('GearInfo.CreatedAt', 'desc');

        return $finder->find();
    }
}
