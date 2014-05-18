<?php
class Twitter
{
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

    public function addNewTwitterAccount($userId, $twitterName, $password)
    {
        // check if it already exists
        $twitterInfo = UserMetaPeer::getMetaValue($userId, 'twitterpassword');

        if($twitterInfo)
        {
            $this->removeTwitterAccount($userId);
        }

        // add twitter name
        $meta = new UserMeta();
        $meta->setUserId($userId);
        $meta->setKey('twittername');
        $meta->setValue($twitterName);
        $meta->save();

        // add twitter password
        $meta = new UserMeta();
        $meta->setUserId($userId);
        $meta->setKey('twitterpassword');
        $meta->setValue(base64_encode($password));
        $meta->save();

        // add twitter active
        $meta = new UserMeta();
        $meta->setUserId($userId);
        $meta->setKey('twitter-active');
        $meta->setValue(1);
        $meta->save();

        // add twitter type (question or question and gear)
        $meta = new UserMeta();
        $meta->setUserId($userId);
        $meta->setKey('twitter-type');
        $meta->setValue('all');
        $meta->save();

        // Tweet new account message
        sfProjectConfiguration::getActive()->loadHelpers("Url");
        $url = url_for(UserPeer::retrieveByPK($userId)->getRoute(), true);
        $message = 'Follow my recording studio gear at ' . $url;
        myUtil::sendTweet($message, $twitterName, $password);

        return true;
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
}
?>