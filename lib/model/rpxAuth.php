<?php

class rpxAuth extends BaserpxAuth
{
    public function recordLogin()
    {
        $this->setLastLogin(date('Y-m-d h:i:s'));
        $this->save();
    }

    public static function processRpxAuth($token)
    {
        $apiKey = sfConfig::get('app_rpx_auth_apiKey');

        $post_data = array('token' => $token, 'apiKey' => $apiKey, 'format' => 'json'); //Set to either 'json' or 'xml'


        // make the api call using libcurl
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, 'https://rpxnow.com/api/v2/auth_info');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $raw_json = curl_exec($curl);
        curl_close($curl);

        // parse the json response into an associative array
        return json_decode($raw_json, true); // Only needed for JSON return
    }
}
