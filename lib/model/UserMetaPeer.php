<?php

class UserMetaPeer extends BaseUserMetaPeer
{
    // return a single meta value for a user
    public static function getMetaValue($userId, $key)
    {
        if($userId && $key)
        {
            $result = DbFinder::from('UserMeta')
                    ->where('UserId', $userId)
                    ->where('Key', $key)
                    ->findOne();

            if($result)
            {
                return $result->getValue();
            }
        }

        return false;
    }

    // return the full meta row
    public static function getMeta($userId, $key)
    {
        if($userId && $key)
        {
            return DbFinder::from('UserMeta')
                    ->where('UserId', $userId)
                    ->where('Key', $key)
                    ->findOne();
        }

        return false;
    }
    
    // return the full meta row
    public static function getAllUserMeta($userId)
    {
        if($userId)
        {
            return DbFinder::from('UserMeta')
                    ->where('UserId', $userId)
                    ->find();
        }

        return false;
    }
}
