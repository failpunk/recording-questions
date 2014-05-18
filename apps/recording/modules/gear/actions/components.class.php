<?php

class gearComponents extends sfComponents
{
    public function executeCompanies()
    {
        if(!$this->listings)
        {
            $this->listings = 5;
        }

        $this->recent_companies = GearCompanyPeer::getRecentCompanies($this->listings);
    }

    public function executeCategories()
    {
        $this->categories = GearPeer::getCategoryCounts();
//        $this->studio_array = StudioCategories::getStudioArray();
        $this->studio_array = GearCategory::$_sections;
    }

    public function executeCompanyProducts()
    {
        if(!$this->company)
        {
            return "No company provided";
        }

        if(!$this->title)
        {
            $this->title = 'Top Products';
        }

        $this->products = GearPeer::getByCompany($this->company->getId(), '', 7);
    }

    public function executeEbayListings()
    {
        if(!$this->title)
        {
            $this->title = 'Find It On Ebay';
        }

        $results = Ebay::findProduct($this->gear_name, 5);

        $this->results = $results;
        $this->result_count = count($results);
    }

    /**
     *  Lists all the gear
     */
    public function executeListGear(sfWebRequest $request)
    {
        if(!$this->base_route)
        {
            $this->base_route = 'gear';
        }

        if($this->getUser()->isAuthenticated())
        {
            $this->user_id = $this->getUser()->getCurrentUser()->getId();
        }
    }

    /**
     *  Lists all the companies
     */
    public function executeListCompanies(sfWebRequest $request)
    {
        $page    = $request->getParameter('page', 1);
        $results = $request->getParameter('results', 15);

        $this->company_list = GearCompanyPeer::getCompanies($page, $results);
    }

    public function executeUserStudio()
    {
        $user = UserPeer::retrieveByPK($this->user_id);

        if($user)
        {
            $this->user = $user;
            $this->user_gear = GearPeer::getByUser($this->user_id);

            $this->studio = Gear::getStudioArray();
        }
    }

    public function executeGearInfo()
    {

    }

    public function executeProductMembers()
    {
        $this->has   = UserGearPeer::getUsersByGear($this->gear->getId(), 'userhas', 8);
        $this->wants = UserGearPeer::getUsersByGear($this->gear->getId(), 'userwants', 8);

        if(count($this->has) > 0)
            $this->display_has = 'block';
        else
            $this->display_wants = 'block';
    }

    public function executeGearInfoAbout()
    {
        if($this->gear_info)
        {
            $this->about = $this->gear_info->getAbout();
        } else
        {
            $this->about = "";
        }
    }

    public function executeCompanyAbout()
    {
        if($this->company_info)
        {
            $this->about = $this->company_info->getAbout();
            $this->website = $this->company_info->getWebsite();
        } else
        {
            $this->about = "";
            $this->website = "";
        }
    }

    public function executeGearInfoSpecs()
    {
        if($this->gear_info)
        {
            $this->specs = $this->gear_info->getSpecs();
        } else
        {
            $this->specs = "";
        }
    }

    public function executeGearInfoReview()
    {
        $this->site_reviews = GearReviewPeer::getLatestSiteReviews($this->gear->getId(), 15);
        $this->user_reviews = GearReviewPeer::getLatestUserReviews($this->gear->getId(), 15);

        // prebuild basic review route
        $route =  '@gear_user_review_detail';
        $route .= '?company_name=' . myUtil::slugify($this->gear->getGearCompany()->getName());
        $route .= '&gear_name=' . myUtil::slugify($this->gear->getName());
        $route .= '&gear_id=' . $this->gear->getId();

        $this->user_review_route = $route;
    }

    public function executeGearRelatedQuestions()
    {
        if(get_class($this->object) == 'GearCompany')
        {
            $tags = $this->object->getGearCompanyTags();
        }

        if(get_class($this->object) == 'Gear')
        {
            $tags = $this->object->getGearTags();
        }

        if($tags)
        {
            $this->tags = $tags;

            $question_ids = myTag::getObjIdByTagId($tags[0]->getTagId());

            if($question_ids)
            {
                $this->questions = QuestionPeer::getByIdPKs($question_ids);
            } else
            {
                $this->questions = false;
            }
        }
        else
            $this->questions = false;
    }

    public function executeRecentActivity()
    {
        $this->recent_activity = RecentActivityPeer::getActivity(false, 5);
    }

    public function executeFlagPage()
    {

    }

    public function executeGearDetail()
    {
        $this->affiliate_link = $this->gear->getAffiliateLink();

        if($this->affiliate_link['button_text'])
            $this->buy_now = $this->affiliate_link['button_text'];
        else
            $this->buy_now = 'Buy Now';
    }

    public function executeLeaderBoard()
    {
        $this->most_gear    = GearInfoPeer::getNewGearLeaders(4);
        $this->site_review  = GearReviewPeer::getSiteReviewLeaders(4);
        $this->user_review  = GearReviewPeer::getUserReviewLeaders(4);
    }
}
?>