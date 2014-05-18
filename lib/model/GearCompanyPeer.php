<?php

class GearCompanyPeer extends BaseGearCompanyPeer
{
    public static function getRecentCompanies($limit = 10)
    {
        return DbFinder::from('GearCompany')
                ->where('GearCompany.Visible', true)
                ->leftJoin('Gear')
                ->where('Gear.Visible', true)
                ->withColumn('count(Gear.Id)', 'count')
                ->select(array('GearCompany.FullName', 'count'))
                ->groupBy('GearCompany.FullName')
                ->orderBy('createdAt', 'desc')
                ->limit($limit)
                ->find();
    }

    public static function getCompanyByName($name)
    {
        return DbFinder::from('GearCompany')
                ->where('name', $name)
                ->where('Visible', true)
                ->findOne();
    }

    public static function getCompanies($page = '', $perPage = 15)
    {
        $finder = DbFinder::from('GearCompany')
                ->where('Visible', true)
                ->orderBy('CreatedAt', 'desc');

        if($page)
            return $finder->paginate($page, $perPage);
        else
            return $finder->find();
    }

    public static function findLike(array $string, $limit = 30)
    {
        if(count($string) > 0)
        {
            $finder =  DbFinder::from('GearCompany');

            foreach($string as $i => $value)
            {
                $value = trim($value);

                if($i == 0)
                {
                    $finder->where("Name", "like", "%$value%");
                } else
                {
                    $finder->orWhere("Gear.Name", "like", "%$value%");
                }
            }

            $finder->select(array('Id', 'Name'), sfModelFinder::SIMPLE);

            return $finder->limit($limit)->find();
        }
        else
            return false;
    }

    public static function getCount()
    {
        return DbFinder::from('GearCompany')
                ->count();
    }

    public static function getCompaniesForSitemap($limit = 1, $offset = 0)
    {
        return DbFinder::from('GearCompany')
                ->select(array('GearCompany.Name', 'GearCompany.UpdatedAt'))
                ->limit($limit)
                ->offset($offset)
                ->find();
    }
}
