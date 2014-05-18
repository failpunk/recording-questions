<?php

class indexComponents extends sfComponents
{
    public function executeRecentTag()
    {
        $questions = $this->questions;

        $recentTagCount = sfConfig::get('app_recent_tag_count');

        if(is_array($questions))
        {
            rsort($questions);

            $recentTag = array();

            foreach ($questions as $question)
            {
                foreach ($question->getTags() as $tag)
                {
                    $recentTag[] = $tag;
                    $recentTag = array_unique($recentTag);
                }
                if(count($recentTag) > $recentTagCount-1)
                {
                    break;
                }
            }
        }
        else
        {
            $recentTag = $questions->getTags();
        }

        if(count($recentTag) > $recentTagCount)
        {
           $recentTag = array_chunk($recentTag, $recentTagCount);
           $recentTag = $recentTag[0];
        }

        $user = $this->getUser();
        $tags = array();

        $user->getCurrentUser();

        // @TODO extract method
        if($user->isAuthenticated())
        {
            foreach($recentTag as $key => $tagItem)
            {
                $tags[$key]['tags'] = $tagItem;

                // @TODO fix for speedup, maybe move to SQL

                $tagResult = myTag::getTagByName($tagItem);
                $userTag = UserTag::getUserTagByTagId($tagResult->getId(), $user->getCurrentUser()->getId());

                if($userTag)
                {
                    if($userTag->getPositive())
                        $tags[$key]['act'] = true;
                    if($userTag->getNegative())
                        $tags[$key]['act'] = false;
                }
            }
        }
        else
        {
            foreach ($recentTag as $key => $tagItem)
            {
               $tags[$key]['tags'] = $tagItem;
            }
        }

        $this->recentTag = $tags;
    }

    public function executeTips()
    {
        // get all the tips from the DB
        $tips = WebsiteTipsPeer::getAllTips();

        // select a random tip to display
        $tip_count = count($tips);
        $tip_index = rand(0, $tip_count - 1);

        $this->tip = $tips[$tip_index];
    }

    public function executeTshirts()
    {
        
    }

    public function executeTagCloud()
    {
        $this->tags = TagPeer::getPopulars();
    }

    public function executeRecentAnswers()
    {
        $this->answers = AnswerPeer::getRecentAnswers(5);
    }

    public function executePagination(sfWebRequest $request)
    {
        $this->results_per_page = $request->getParameter('results', 15);
    }
}
?>