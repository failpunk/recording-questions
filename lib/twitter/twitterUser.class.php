<?php
class TwitterUser
{
    private $userId;
    private $userName;
    private $password;
    private $active;
    private $twitterType;

    // load twitter username and password and RQ user id
    public function __construct($userId = null)
    {
        if($userId)
        {
            $this->userId = $userId;
            $metas = UserMetaPeer::getAllUserMeta($userId);

            foreach($metas as $meta)
            {
                if($meta->getKey() == 'twittername') {
                    $this->userName = $meta->getValue();
                }
                
                if($meta->getKey() == 'twitterpassword') {
                    $this->password = base64_decode($meta->getValue());
                }

                if($meta->getKey() == 'twitter-active') {
                    $this->active = $meta->getValue();
                }
                
                if($meta->getKey() == 'twitter-type') {
                    $this->twitterType = $meta->getValue();
                }
            }
        }
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function isActive()
    {
        return $this->active;
    }

    public function getType()
    {
        return $this->twitterType;
    }

    public function checkUser($username, $password)
    {
        $context = stream_context_create(array(
            'http' => array(
              'method'  => 'GET',
              'header'  => sprintf("Authorization: Basic %s\r\n", base64_encode($username.':'.$password)).
                           "Content-type: application/x-www-form-urlencoded\r\n",
              'timeout' => 50,
            ),
        ));

        $ret = file_get_contents('http://twitter.com/account/verify_credentials.xml', false, $context);
        return false !== $ret;
    }

    public function removeTwitterAccount($userId)
    {
        $name     = UserMetaPeer::getMeta($userId, 'twittername');
        $password = UserMetaPeer::getMeta($userId, 'twitterpassword');
        $active   = UserMetaPeer::getMeta($userId, 'twitter-active');

        $name->delete();
        $password->delete();
        $active->delete();
    }

    public function toggleStatus()
    {
        $active = UserMetaPeer::getMeta($this->userId, 'twitter-active');

        if($active->getValue())
        {
            $active->setValue(0);
            $active->save();
            return 'off';
        }
        else
        {
            $active->setValue(1);
            $active->save();
            return 'on';
        }
    }

    public function toggleType()
    {
        $active = UserMetaPeer::getMeta($this->userId, 'twitter-type');

        if($active->getValue() == 'all')
        {
            $active->setValue('question');
            $active->save();
            return 'question';
        }
        else
        {
            $active->setValue('all');
            $active->save();
            return 'all';
        }
    }

    public function sendTweet($tweet)
    {
        if($this->isActive() && $this->underSpamThreshold())
        {
            return myUtil::sendTweet($tweet, $this->getUserName(), $this->getPassword());
        }
    }

    /**
     *  Make sure tweets are only sent every 10 minutes
     */
    public function underSpamThreshold()
    {
        if($this->isActive())
        {
            // check recent activity
            $recent = RecentActivityPeer::getActivityByUserId(myUser::getUserId(), 600);

            if(count($recent) > 1)
                return false;
            else
                return true;
        }
    }

    public static function hasTwitter($userId)
    {
        if($userId)
        {
            $meta = UserMetaPeer::getMeta($userId, 'twitter-active');

            if($meta)
                return true;
            else
                return false;
        }
    }
}
?>