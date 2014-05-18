<?php

class RecentActivity extends BaseRecentActivity
{
    public static function addActivity($userId, $activityText, array $ids)
    {
        // don't add to recent activity if recording questions user
        if($userId == 4) {
            return false;
        }

        if($userId && $activityText && $ids)
        {
            $activity = new RecentActivity();
            $activity->setUserId($userId);
            $activity->setActivity($activityText);

            foreach($ids as $field => $value)
            {
                $activity->setByName($field, $value);
            }

            $activity->save();
        }
    }

    public function createPageLink()
    {
        sfProjectConfiguration::getActive()->loadHelpers("Url");

        // determine type of link
        if(!is_null($this->getGearId()))
        {
            $object = GearPeer::retrieveByPK($this->getGearId());
        }
        
        if(!is_null($this->getCompanyId()))
        {
            $object = GearCompanyPeer::retrieveByPK($this->getCompanyId());
        }


        if(isset($object) && $object)
        {
            return link_to($object->getName(), $object->getRoute());
        }
        else
            return "";
        
    }
}
