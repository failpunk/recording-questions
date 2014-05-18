<?php

class Gear extends BaseGear
{
    static $studio = array (
            'interface'    => 'Audio Interface',
            'software'     => 'Software',
            'plugins'      => 'Plug ins',
            'monitors'     => 'Monitors',
            'mics'         => 'Microphones',
            'preamps'      => 'Preamps',
            'rack'         => 'Rack Gear',
            'other'        => 'Other Gear'
    );

    public function getSmallImagePath()
    {
        $imagePath = sfConfig::get('app_gear_gear_images') . '/' .$this->getId() . '-100.gif';

        if($this->hasImage($imagePath))
            return $imagePath;
        else
            return sfConfig::get('app_gear_gear_images') . '/default-100.jpg';
    }

    public function getLargeImagePath()
    {
        return sfConfig::get('app_gear_gear_images') . '/' .$this->getId() . '-400.jpg';
    }

    public function getFullImagePath()
    {
        return sfConfig::get('app_gear_gear_images') . '/' .$this->getId() . '-full.jpg';
    }

    private function hasImage($imagePath)
    {
        return file_exists(sfConfig::get('sf_web_dir') . '/images/' . $imagePath);
    }

    public function getRoute()
    {
        $route =  '@gear_item';
        $route .= '?company_name=' . myUtil::slugify($this->getGearCompany()->getName());
        $route .= '&gear_name=' . myUtil::slugify($this->getName());
        $route .= '&gear_id=' . myUtil::slugify($this->getId());

        return $route;
    }

    public function getTagName()
    {

        $tagInfo = GearTagPeer::getTagName($this->getId());
        return $tagInfo->getName();
    }

    static public function getStudioArray()
    {
        return self::$studio;
    }

    public function prepare()
    {
        // Add a new tag for this gear, if needed
        $tag = myTag::getObjIdByTagName($this->getName());

        if(!$tag)
        {
            $tagName = myUtil::slugify($this->getName());
            $tag = new Tag();
            $tag->setName($tagName);
            $tag->save();
        }

        return $tag->getID();
    }

    public function createImages($imageName)
    {
        myUtil::resizeGearImages($imageName, sfConfig::get('app_gear_gear_images'), $this->getId());
    }

    public function getGearInfo()
    {
        return GearInfoPeer::getLatestRevision($this->getId());
    }

    public function save(PropelPDO $con = null)
    {
        $new = $this->isNew();
        parent::save();

        if($new)
        {
            $this->sendmail();                                          // send alert email
            fpExperience::updatePositiveForUser(myUser::getCurrentUser()->getId(), 'gear');       // add experience
        }
    }

    private function sendmail()
    {
        sfProjectConfiguration::getActive()->loadHelpers("Url");

        $subject = "New Gear Was Added";
        $mailBody  = $this->getName() . " was added to the database\n";
        $mailBody .= url_for($this->getRoute(), true) . "\n";

        $email = new Mail();
        $email->sendTextEmail($subject, $mailBody, 'justin@recordingquestions.com');
    }

    public function getReviewCount()
    {
        return GearReviewPeer::getReviewCount($this->getId());
    }

    public function sendTweet($user_id, $messageType = 'addStudio')
    {
        $userTwitter = new TwitterUser($user_id);

        if($userTwitter->isActive() && $userTwitter->getType() == 'all')
        {
            sfProjectConfiguration::getActive()->loadHelpers("Url");

            // Shorten Url
            $gearRoute = url_for($this->getRoute(), true);
            $shortenedUrl = myUtil::shortenUrl($gearRoute);

            if($shortenedUrl)
            {
                // construct tweet
                $urlLength = strlen($shortenedUrl);
                $tweet =  $this->getMessage($messageType) . $shortenedUrl;

                $userTwitter->sendTweet($tweet);
            }
        }
    }

    private function getMessage($type)
    {
        if($type)
        {
            if($type == 'addStudio')
            {
                return 'Added the ' . $this->getGearCompany()->getName() . ' ' . $this->getName() . ' to my Studio on @recordquestions. ';
            }

            if($type == 'removeStudio')
            {
                return 'No longer have the ' . $this->getGearCompany()->getName() . ' ' . $this->getName() . ' in my Studio on @recordquestions. ';
            }

            if($type == 'wantStudio')
            {
                return 'I want the ' . $this->getGearCompany()->getName() . ' ' . $this->getName() . ' for my Studio on @recordquestions. ';
            }

            if($type == 'siteReview')
            {
                return 'I added a new review link for the ' . $this->getGearCompany()->getName() . ' ' . $this->getName() . ' on @recordquestions. ';
            }
        }

        return '';
    }

    public function getAffiliateLink()
    {
        if($this->getAdId() >= 0)       // has direct link
        {
            // get the current affiliate table of ads
            // check if there is a direct key to an affiliate link
            $affiliate_link = $this->getDirectLink();

            if(!$affiliate_link)
            {
                // Search link table for matching Affiliate link data
                $search_string = $this->getGearCompany()->getName() . ' ' . $this->getName();

                $affiliate_link = call_user_func_array(CJ::getCurrentTableName() . "::getLink", array($search_string));
            }

            return $this->createAffiliateArray($affiliate_link);
        }
        elseif($this->getAdId() < -1)       // custom links

        {
            $link = CustomLinkPeer::retrieveByPK($this->getAdId());

            return array('buy_url' => $link->getLink(), 'price' => false, 'button_text' => $link->getButtonText());
        }
        else
            return false;
    }

    public function getDirectLink()
    {
        if($this->getAdId() > 0)
        {
            $tableName = CJ::getCurrentTableName();

            return call_user_func_array($tableName . "::getBySku", array($this->getAdId()));
        }

        return false;
    }

    public function createAffiliateArray($affiliate_link)
    {
        $array = array();

        $array['id']             = $affiliate_link->getId();
        $array['sku']            = $affiliate_link->getSku();
        $array['name']           = $affiliate_link->getName();
        $array['buy_url']        = $affiliate_link->getBuyUrl();
        $array['impression_url'] = $affiliate_link->getImpressionUrl();
        $array['price']          = $affiliate_link->getPrice();
        $array['button_text']    = false;

        return $array;

    }

    public static function createRss($gears)
    {
        sfProjectConfiguration::getActive()->loadHelpers("Url");
        $studio_array = StudioCategories::getStudioArray();

        $feed = new sfRssFeed();
        $feed->initialize(
                array(
                    'title'       => 'Newest Recording Gear - Recording Questions',
                    'link'        => url_for('@gear', true) . '/rss',
                    'description' => 'A list of all the latest gear added to our socially interactive gear database',
                    'authorEmail' => sfConfig::get('app_rss_conf_author_email'),
                    'authorName'  => sfConfig::get('app_rss_conf_author_name')
        ));

        foreach ($gears as $gear)
        {
            $imagePath = 'http://recordingquestions.com/images/' . sfConfig::get('app_gear_gear_images') . '/' . $gear['Gear.Id'] . '-100.gif';

            $item = new sfFeedItem();
            $item->setTitle($gear['Gear.Name']);

            $route =  '@gear_item';
            $route .= '?company_name=' . myUtil::slugify($gear['GearCompany.Name']);
            $route .= '&gear_name=' . myUtil::slugify($gear['Gear.Name']);
            $route .= '&gear_id=' . myUtil::slugify($gear['Gear.Id']);
            $item->setLink(url_for($route, true));

            $item->setAuthorName('RecordingQuestions.com');
            $item->setPubdate(strtotime($gear['Gear.UpdatedAt']));
            $item->setDescription('Categorized as ' . $studio_array[$gear['Gear.Section']]);

            $content = '<img src="' . $imagePath . '"/><br>';
            $item->setContent($content . $gear['GearInfo.about']);

            $feed->addItem($item);
        }

        return $feed;
    }
}
