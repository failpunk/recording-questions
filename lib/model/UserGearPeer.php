<?php

class UserGearPeer extends BaseUserGearPeer
{
    public static function getUserCountByCompany($companyId, $filterByOwnership = 'userHas')
    {
        if($companyId)
        {
            return DbFinder::from('UserGear')
                ->join('Gear')
                ->join('GearCompany')
                ->where('GearCompany.Id', $companyId)
                ->where('UserGear.' . $filterByOwnership, 1)
                ->count();
        }
        else
            return false;
    }
    
    public static function getUserCountByGear($gearId, $filterByOwnership = 'userHas')
    {
        if($gearId)
        {
            return DbFinder::from('UserGear')
                ->join('Gear')
                ->where('Gear.Id', $gearId)
                ->where('UserGear.' . $filterByOwnership, 1)
                ->count();
        }
        else
            return false;
    }

    public static function addToStudio($userId, $gearId, $ownership = 'userhas')
    {
        if($userId && $gearId)
        {
            $userGear = new UserGear();
            $userGear->setUserId($userId);
            $userGear->setGearId($gearId);

            if(strtolower($ownership) == "userhas") {
                $userGear->setUserHas(1);
            } else {
                $userGear->setUserWants(1);
            }

            $userGear->save();
            return true;
        }
        else
            return false;
    }

    public static function getUsersByGear($gearId, $ownership = 'userhas', $limit = 0)
    {
        if($gearId)
        {
             $finder = DbFinder::from('User')
                ->join('UserGear')
                ->where('UserGear.GearId', $gearId);

                if($ownership == 'userhas') {
                    $finder->where('UserGear.UserHas', 1);
                } elseif($ownership == 'userwants') {
                    $finder->where('UserGear.UserWants', 1);
                } else {
                    $finder->where('UserGear.UserHad', 1);
                }

               return $finder->limit($limit)->find();
        }
    }
}
