<?php

class ProfileViews extends BaseProfileViews
{
    public function logView($user_id, $ip)
    {
        if($user_id && $ip)
        {
            $ip = ip2long($ip);

            $recentView = ProfileViewsPeer::getRecentView($user_id, $ip);

            // does this ip exist in the DB for the past day
            if($recentView)
            {
                if((time() - strtotime($recentView->getCreatedAt())) <= 86400)
                {
                    return false;
                }
                else
                {
                    $recentView->setCreatedAt(time());
                    $recentView->save();
                }
            }
            else
            {
                $this->setUserId($user_id);
                $this->setIp($ip);
                $this->save();
            }
        }
    }
}
