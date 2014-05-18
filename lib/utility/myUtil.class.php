<?php
/**
 *  Container class for helper methods and utilities.
 */

class myUtil
{
    /**
     * for permalinks
     *
     * @param string $title
     * @return string
     */
    public static function createSlug($title)
    {
        $match = array(
                "/[^a-zA-Z0-9\\-,+� ]/",
                "/ +/",
                "/-+/",
                "/^-/",
                "/-$/"
        );
        $replace = array(
                "",
                "-",
                "-",
                "",
                ""
        );
        return preg_replace($match, $replace, strtolower($title));
    }

    /**
     * Sligify a given URL
     *
     * @param <type> $text
     * @return <type>
     */
    static public function slugify($text)
    {
        // replace all non letters or digits by -
        $text = preg_replace('/\W+/', '-', $text);

        // trim and lowercase
        $text = strtolower(trim($text, '-'));

        return $text;
    }

    /**
     * Unslugify a given URL
     *
     * @param <type> $text
     * @return <type>
     */
    static public function unslugify($text)
    {
        // replace all non letters or digits by -
        return str_replace('-', ' ', $text);
    }

    /**
     * Shorten a URL using the Bitly API
     *
     * @param <type> $urlToShorten
     * @return <type>
     */
    public static function shortenUrl($urlToShorten)
    {
        $api_login = sfConfig::get('app_bitly_username');
        $api_key = sfConfig::get('app_bitly_password');

        if(!$urlToShorten)
        {
            return false;
        }

        $apiUrl = 'http://api.bit.ly/shorten?version=2.0.1';
        $apiUrl .= '&longUrl=' . $urlToShorten;
        $apiUrl .= '&login=' . $api_login;
        $apiUrl .= '&apiKey=' . $api_key;

        $result = json_decode(file_get_contents($apiUrl));

        if(!is_object($result))
        {
            return false;
        }

        if($result->errorCode != 0)
        {
            $message = $result->errorMessage;
            sfContext::getInstance()->getLogger()->warning("API call to bit.ly Failed:\n$message");
            return false;
        }

        // return just the shortened URL
        return $result->results->$urlToShorten->shortUrl;
    }

    /**
     * Send a twitter message
     *
     * @param <type> $message
     * @param <type> $username
     * @param <type> $password
     * @return <type>
     */
    public static function sendTweet($message, $username = false, $password = false)
    {
        if(!$username)
        {
            $username = sfConfig::get('app_twitter_username');
        }

        if(!$password)
        {
            $password = sfConfig::get('app_twitter_password');
        }

        $context = stream_context_create(array(
                'http' => array(
                        'method'  => 'POST',
                        'header'  => sprintf("Authorization: Basic %s\r\n", base64_encode($username.':'.$password)).
                                "Content-type: application/x-www-form-urlencoded\r\n",
                        'content' => http_build_query(array('status' => $message)),
                        'timeout' => 15,
                ),
        ));
        $ret = file_get_contents('http://twitter.com/statuses/update.xml', false, $context);

        return false !== $ret;
    }

    /**
     * Let Posterous send the Tweet and propegate to other services.
     *  - Other services are controlled in posterous account
     *
     * @param <type> $message
     * @param <type> $username
     * @param <type> $password
     * @return <type>
     */
    public static function sendTweetViaPosterous($message, $username = false, $password = false)
    {
        if(!$username)
        {
            $username = sfConfig::get('app_posterous_username');
        }

        if(!$password)
        {
            $password = sfConfig::get('app_posterous_password');
        }

        $context = stream_context_create(array(
                'http' => array(
                        'method'  => 'POST',
                        'header'  => sprintf("Authorization: Basic %s\r\n", base64_encode($username.':'.$password)).
                                "Content-type: application/x-www-form-urlencoded\r\n",
                        'content' => http_build_query(array('title' => $message, 'tags' => 'question')),
                        'timeout' => 50,
                ),
        ));
        $ret = file_get_contents('http://posterous.com/api/newpost', false, $context);

        return false !== $ret;
    }

    /**
     * Validate an email address
     *
     * @param <type> $email
     * @return <type>
     */
    public static function check_email_address($email)
    {
        // First, we check that there's one @ symbol,
        // and that the lengths are right.
        if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email))
        {
            // Email invalid because wrong number of characters
            // in one section or wrong number of @ symbols.
            return false;
        }

        // Split it into sections to make life easier
        $email_array = explode("@", $email);
        $local_array = explode(".", $email_array[0]);
        for ($i = 0; $i < sizeof($local_array); $i++)
        {
            if(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&↪'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
            $local_array[$i]))
            {
                return false;
            }
        }

        // Check if domain is IP. If not,
        // it should be valid domain name
        if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1]))
        {
            $domain_array = explode(".", $email_array[1]);
            if (sizeof($domain_array) < 2)
            {
                return false; // Not enough parts to domain
            }

            for ($i = 0; $i < sizeof($domain_array); $i++)
            {
                if(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|↪([A-Za-z0-9]+))$",$domain_array[$i]))
                {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Given a date it will attempt to convert to a formated string for display
     *
     * @param <type> $date
     * @return <type>
     */
    public static function nicetime($date)
    {
        if(empty($date))
        {
            return "No date provided";
        }

        $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths         = array("60","60","24","7","4.35","12","10");

        $now             = time();
        $unix_date         = strtotime($date);

        // check validity of date
        if(empty($unix_date))
        {
            return "Bad date";
        }

        // is it future date or past date
        if($now > $unix_date)
        {
            $difference     = $now - $unix_date;
            $tense         = "ago";

        } else
        {
            $difference     = $unix_date - $now;
            $tense         = "from now";
        }

        for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++)
        {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if($difference != 1)
        {
            $periods[$j].= "s";
        }

        return $difference;
    }

    /**
     * Return the current users IP from the given request
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    static public function getUserIp(sfWebRequest $request)
    {
        $requestInfo = $request->getPathInfoArray();

        if($requestInfo['REMOTE_ADDR'])
            return $requestInfo['REMOTE_ADDR'];
        else
            return '';
    }

    /**
     *  Run this on incomming AJAX submitted text.  Removes any tags and convert newlines to <br/>
     */
    static public function cleanText($text)
    {
        $cleanText = strip_tags($text);

        return str_replace("\n", "<br/>", $cleanText);
    }

    /**
     *  Use this on display text in texareas.  This will replace <br/> with newline
     */
    static public function textarea($text)
    {
        return str_replace("<br/>", "\n", html_entity_decode($text));
    }

    /**
     * Helper method to resize gear images.
     *
     * @param <type> $baseImageName
     * @param <type> $savePath
     * @param <type> $id
     */
    static public function resizeGearImages($baseImageName, $savePath, $id, $basePath = 'images/')
    {
        //TODO: Justin - Move image sizes and name to app.yml file
        $img = new sfImage(sfConfig::get('sf_upload_dir').'/'.$baseImageName, 'image/jpg');

        // save full-size image, no larger than 1024x768
        $img->setQuality(100);

        if($img->getHeight() > $img->getWidth())
        {
            if($img->getHeight() > 768)
            {
                $img->resize(null, 768);
            }
        }
        else
        {
            if($img->getWidth() > 1024)
            {
                $img->resize(1024, null);
            }
        }
        $img->saveAs($basePath . $savePath . '/' . $id . '-full.jpg', 'image/jpg');


        // save main image
        if($img->getHeight() <= 300 && $img->getWidth() <= 400)
        {
            // if image is smaller than min requirements, just save image as is
            $img->saveAs($basePath . $savePath . '/' . $id . '-400.jpg', 'image/jpg');
        }
        else
        {
            // resize to fit 400 width and 300 height
            if($img->getHeight() >= $img->getWidth())
            {
                $img->resize(null, 300);
            } else
            {
                $img->resize(400, null);
            }
        }
        $img->saveAs($basePath . $savePath . '/' . $id . '-400.jpg', 'image/jpg');


        // save thumbnail image 100x100
        $img->thumbnail(100,100);
        $img->saveAs($basePath . $savePath . '/' . $id . '-100.gif', 'image/gif');

        // remove temp image from uploads folder
        unlink(sfConfig::get('sf_upload_dir').'/'.$baseImageName);
    }

    /**
     * Function to return initial beta user group for testing
     * 
     * @return <type> 
     */
    static public function isGearBeta()
    {
        $users = array(2, 4, 5, 6, 9, 13, 16, 21, 49, 55, 63, 77);
        $user_id = myUser::getCurrentUser()->getId();

        if(in_array($user_id, $users))
        {
            return true;
        }
        else
            return false;
    }

    /**
     * Contructs a paginated route string
     *
     * @param <type> $routeString
     * @param array $params
     * @return <type>
     */
    static public function constructPaginationRoute($routeString, array $params = array())
    {
        $route  = (strpos($routeString, '@') !== false) ? '' : '@';
        $route .= $routeString;

        // determine if route passed in with param.
        if(strpos($routeString, '?') !== false)
        {
            $route .= '&';
        } else
        {
            $route .= '?';
        }

        $route .= http_build_query($params);

        return html_entity_decode($route);
    }

    /**
     * Helper method to quickly resize images for the user profile page.
     *
     * @param <type> $tempImage
     * @param <type> $user_id
     */
    static public function resizeStudioImage($tempImage, $user_id)
    {
        $img = new sfImage(sfConfig::get('sf_upload_dir').'/'.$tempImage, 'image/jpg');

        $img->setQuality(95);
        $img->resize(250, null);
        $img->saveAs('images/' . sfConfig::get('app_gear_studio_images') . '/' . $user_id . '-250.jpg', 'image/jpg');

        // remove temp image from uploads folder
        unlink(sfConfig::get('sf_upload_dir').'/'.$tempImage);
    }
}
?>