<?php

class questionComponents extends sfComponents
{
	public function executeLockedNotification()
	{
        if($this->question_id)
        {
            $reason = QuestionClosedPeer::getExistingReason($this->question_id);

            if($reason)
            {
                $this->reason_type = strtolower($reason->getReasonType());

                if($this->reason_type == 'it is a duplicate question')
                {
                    $this->duplicate = true;
                    $this->question = QuestionPeer::retrieveByPK($reason->getReasonText());
                } else {
                    $this->duplicate = false;
                }
            }
        }
    }

    public function executeTags()
    {
        //TODO: Justin - REMOVE THIS WHEN GEAR SECTION IS ENABLED
        if(!sfConfig::get('app_gear_enable') && !myUtil::isGearBeta()) {
            $this->tags = $this->question->getTags();
        } else {
            $this->tags = myTag::getMixedTags($this->question->getId());
        }
    }
    
    public function executeTopAdminControls(sfWebRequest $request)
    {
        $this->is_admin = false;
        $this->score = 0;
        
        if($this->getUser()->isAuthenticated())
        {
            $user = $this->getUser()->getCurrentUser();

            // is admin?
            if($this->getUser()->hasCredential('admin'))
            {
                $this->is_admin = true;
            }

            $this->isDeleted = $this->question->getVisible() ? false : true;
            $this->isLocked  = $this->question->getLocked()  ? true : false;
            
            $score = $user->getExperienceScore();

            $this->score = $score;
        }
        else
            return false;
    }

    public function executeQuestionList()
    {
        // When owner id is passed in treat as favorites list
        if(isset ($this->ownerId)) {
            $this->list_class = 'favorite-list';
        } else {
            $this->list_class = '';
        }

        // if true display_compact will show a more compact version of the question listing
        if(!isset ($this->display_compact)) {
            $this->display_compact = false;
        }

        if(!$this->base_route)
        {
            $this->base_route = 'homepage_nav_pager?nav='.$this->nav;
        }

        // does user have twitter account
        $this->has_twitter = TwitterUser::hasTwitter($this->getUser()->getCurrentUser()->getId());
    }
}
?>