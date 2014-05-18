<?php

class UserMeta extends BaseUserMeta
{
    // return the full meta row
    public static function addMeta($userId, $key, $value)
    {
        if($userId && $key && $value)
        {
            $meta = UserMetaPeer::getMeta($userId, $key);

            if($meta)
            {
                $meta->setValue($value);
            }
            else
            {
                $meta = new UserMeta();
                $meta->setUserId($userId);
                $meta->setKey($key);
                $meta->setValue($value);
            }

            $meta->save();
        }
    }
}
