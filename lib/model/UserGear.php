<?php

class UserGear extends BaseUserGear
{
    public static function addToStudio($userId, $gearId, $ownership)
    {
        if($userId && $gearId && $ownership)
        {
            $userGear = UserGearPeer::retrieveByPK($userId, $gearId);
            
            // check if already added
            if(!$userGear)
            {
                if($ownership == "You Want This")
                {
                    $field = "UserWants";
                }
                else
                {
                    $field = "UserHas";
                    // add to recent activity
                    RecentActivity::addActivity($userId, 'owns', array('GearId' => $gearId));
                }

                if(!UserGearPeer::addToStudio($userId, $gearId, $field))
                    return false;
            }
            else
            {
                $userGear->setUserHad(0);
                $userGear->setUserWants(0);
                $userGear->setUserHas(0);

                if($ownership == "You Want This")
                {
                    $userGear->setUserWants(1);
                }
                else
                {
                    $userGear->setUserHas(1);
                }

                $userGear->save();
            }
            return true;
        }
        else
            return false;
    }
    
    public static function removeFromStudio($userId, $gearId)
    {
        if($userId && $gearId)
        {
            $userGear = UserGearPeer::retrieveByPK($userId, $gearId);

            // if they have added it to their studio, soft delete
            if($userGear)
            {
                // if user is removing this within 10 min of adding it, assume it was a mistake
                if((time() - strtotime($userGear->getCreatedAt())) < 600)
                {
                    $userGear->delete();
                }
                else
                {
                    $userGear->setUserHad(1);
                    $userGear->setUserWants(0);
                    $userGear->setUserHas(0);
                    $userGear->save();
                }
            }

            return true;
        }
        else
            return false;
    }

    public function getOwnershipText()
    {
        if($this->getUserHad())
        {
            return 'You Had This';
        }

        if($this->getUserHas())
        {
            return 'You Own This';
        }
        else
        {
            return 'You Want This';
        }
    }
}
