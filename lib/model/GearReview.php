<?php

class GearReview extends BaseGearReview
{
    public function getDomainOnly()
    {
        $raw_url = parse_url($this->getUrl());
        return str_replace('www.', '', $raw_url['host']);
    }

    public function getUserReviewRoute($gearName, $companyName)
    {
        $route =  '@gear_user_review_detail';
        $route .= '?company_name=' . myUtil::slugify($companyName);
        $route .= '&gear_name=' . myUtil::slugify($gearName);
        $route .= '&gear_id=' . $this->getGearId();
        $route .= '&title=' . myUtil::slugify($this->getTitle());
        $route .= '&review_id=' . myUtil::slugify($this->getId());

        return $route;
    }

    public function getFullReviewRoute($gearName, $companyName)
    {
        $route =  '@gear_user_review_full';
        $route .= '?company_name=' . myUtil::slugify($companyName);
        $route .= '&gear_name=' . myUtil::slugify($gearName);
        $route .= '&gear_id=' . $this->getGearId();
        $route .= '&review_title=' . myUtil::slugify($this->getTitle());
        $route .= '&review_id=' . myUtil::slugify($this->getId());

        return $route;
    }

    public function addNewSiteReview($gearId, $userId, $url, $title, $summary, $publishDate)
    {
        $this->setGearId($gearId);
        $this->setUserId($userId);
        $this->setType(0);
        $this->setUrl($url);
        $this->setTitle($title);
        $this->setSummary(myUtil::cleanText($summary));
        $this->setPublishedDate($publishDate);
        $this->save();

        // don't send mail or add activity record if recording questions.
        if($userId != 4) 
        {
            // Send email reminder to admin
            $this->sendmail('Site');

            // Add to recent activity table
            RecentActivity::addActivity($userId, 'review link', array('GearId' => $gearId));
        }
    }

    public function addNewUserReview($gearId, $userId, $title, $summary, $review)
    {
        $this->setGearId($gearId);
        $this->setUserId($userId);
        $this->setType(1);
        $this->setTitle($title);
        $this->setSummary(myUtil::cleanText($summary));
        $this->setReview(myUtil::cleanText($review));
        $this->save();

        // Don't do extra processing if recording questions.
        if($userId != 4)
        {
            // Send email reminder to admin
            $this->sendmail('User');

            // Add to recent activity table
            RecentActivity::addActivity($userId, 'user review', array('GearId' => $gearId));

            // Add to experience score
            fpExperience::updatePositiveForUser(myUser::getCurrentUser()->getId(), 'user_review');
            
            // add a notification for user
            $message = fpNotification::getCustomTemplate('user_review');
            fpNotification::addUserMessage($userId, $message);
            
            // Send a tweet for the user
            $this->sendTweet($userId);
        }
    }

    public function sendmail($type = 'unknown')
    {
        sfProjectConfiguration::getActive()->loadHelpers("Url");
        
        $subject = "New $type Review Was Added";
        $mailBody  = "New Review:  " .$this->getTitle(). " was added to the database\n";
        $mailBody .= url_for('@gear_item?company_name=blah&gear_name=blah&gear_id='.$this->getGearId(), true) . "\n";

        $email = new Mail();
        $email->sendTextEmail($subject, $mailBody, 'justin@recordingquestions.com');
    }

    public function sendTweet($userId)
    {
        $userTwitter = new TwitterUser($userId);

        if($userTwitter->isActive())
        {
            $gear = GearPeer::retrieveByPK($this->getGearId());
            
            if($gear)
            {
                sfProjectConfiguration::getActive()->loadHelpers("Url");

                $company = $gear->getGearCompany();

                // Shorten Url
                $url = url_for($this->getUserReviewRoute($gear->getName(), $company->getName()), true);
                $shortenedUrl = myUtil::shortenUrl($url);

                if($shortenedUrl)
                {
                    // construct tweet
                    $urlLength = strlen($shortenedUrl);
                    $tweet =  'I just added my own review for the ' . $company->getName() . ' ' . $gear->getName() . ' @recordquestions. ' . $shortenedUrl;

                    $userTwitter->sendTweet($tweet);

                }
            }
        }
    }
}