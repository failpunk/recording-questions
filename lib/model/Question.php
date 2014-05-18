<?php

class Question extends BaseQuestion
{
    public function refreshVoteCount()
    {
        // get all votes for this answer
        $upvotes   = DbFinder::from('Question')->
                where('id', $this->getId())->
                join('QuestionVote')->
                where('QuestionVote.positive', 1)->
                count();

        $downvotes = DbFinder::from('Question')->
                where('id', $this->getId())->
                join('QuestionVote')->
                where('QuestionVote.Negative', 1)->
                count();

        // update answer in DB
        $this->setUpvotes($upvotes);
        $this->setDownvotes($downvotes);

        $originalDate = $this->getUpdatedAt();
        $this->save();

        $this->setUpdatedAt($originalDate);
        $this->save();
    }

    public function getTotalVotes()
    {
        return $this->getUpvotes() - $this->getDownvotes();
    }

    public static function incrementUpvotes($questionId)
    {
        $question = QuestionPeer::retrieveByPK($questionId);

        if($question)
        {
            $question->setUpvotes($question->getUpvotes() + 1);
            $question->save();
        }
    }

    public static function decrementUpvotes($questionId)
    {
        $question = QuestionPeer::retrieveByPK($questionId);

        if($question)
        {
            $question->setUpvotes($question->getUpvotes() - 1);
            $question->save();
        }
    }

    public static function incrementDownvotes($questionId)
    {
        $question = QuestionPeer::retrieveByPK($questionId);

        if($question)
        {
            $question->setDownvotes($question->getDownvotes() + 1);
            $question->save();
        }
    }

    public static function decrementDownvotes($questionId)
    {
        $question = QuestionPeer::retrieveByPK($questionId);

        if($question)
        {
            $question->setDownvotes($question->getDownvotes() - 1);
            $question->save();
        }
    }

    public function setDescription($v)
    {
        // strip tags based on current user experience.
        $userId = sfContext::getInstance()->getUser()->getCurrentUser()->getId();

        if(fpExperience::checkForAction($userId, 'post_link'))
        {
            $allowed_tags = sfConfig::get('app_posts_allowed_tags_trusted');
        } else
        {
            $allowed_tags = sfConfig::get('app_posts_allowed_tags_untrusted');
        }

        $sanitized_string = strip_tags($v, $allowed_tags);

        // add nofollow tag
        $final_string = str_replace('<a ', '<a rel="nofollow" ', $sanitized_string);

        parent::setDescription($final_string);

        return $this;
    }

    /**
     *  Overwite the base method so that we done get deleted questions
     */
    public function getAnswers($criteria = null, PropelPDO $con = null)
    {
        if ($criteria === null)
        {
            $criteria = new Criteria(QuestionPeer::DATABASE_NAME);
        }

        $criteria->add(AnswerPeer::VISIBLE, 1);

        return parent::getAnswers($criteria);
    }

    /**
     *  Sets the column Active to 1 for this question and any answers attached to it
     */
    public function softDelete()
    {
        // soft delete any answers
        AnswerPeer::softDeleteByQuestion($this->getId());

        // soft delete this question
        $this->setVisible(false);
        $this->save();
    }

    public static function constructQuestionRoute($questionTitle, $questionId)
    {
        if($questionId && $questionTitle)
        {
            $route = '@question_detail';
            $route .= '?question_title=' . myUtil::createSlug($questionTitle);
            $route .= '&question_id=' . $questionId;

            return $route;
        }
    }

    public function constructUrlForTask()
    {
        $url = 'http://' . sfConfig::get('app_domain_url');
        $url .= '/question/';
        $url .= myUtil::createSlug($this->getTitle());
        $url .= '/' . $this->getId();

        return $url;
    }

    public function sendTweets($fromTask = false)
    {
        $tweet = $this->createQuestionTweet($fromTask);

        if($tweet)
        {
            myUtil::sendTweetViaPosterous($tweet);

            // if user added twitter account, send a tweet for them, and not in dev environment
            if(sfConfig::get('sf_environment') == 'prod')
            {
                $userTwitter = new TwitterUser($this->getUserId());
                $userTwitter->sendTweet($tweet);
            }
        }
        else
            return false;
    }
    
    public function createQuestionTweet($fromTask = false)
    {
        // Do not load helper if this is being called from a task
        if(!$fromTask) {
            sfProjectConfiguration::getActive()->loadHelpers("Url");
        }

        // Contruct URL manually if being called from a task
        if($fromTask)
            $questionUrl = 'http://' . sfConfig::get('app_domain_url') . '/question/' . myUtil::createSlug($this->getTitle()) . '/'.$this->getId();
        else
            $questionUrl = url_for(self::constructQuestionRoute($this->getTitle(), $this->getId()), true);
        
        $shortenedUrl = myUtil::shortenUrl($questionUrl);

        if($shortenedUrl)
        {
            // construct tweet
            $urlLength = strlen($shortenedUrl);
            $message = substr($this->getTitle(), 0, 140 - ($urlLength + 3));
            $tweet = $message . '.. ' . $shortenedUrl;
            
            return $tweet;
        }
        else
            return false;

    }
}

sfPropelBehavior::add('Question', array('sfPropelActAsTaggableBehavior'));