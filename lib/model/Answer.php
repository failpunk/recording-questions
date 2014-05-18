<?php

class Answer extends BaseAnswer
{
  public function refreshVoteCount()
  {
    // get all votes for this answer
    $upvotes   = DbFinder::from('Answer')->
                 where('id', $this->getId())->
                 join('AnswerVote')->
                 where('AnswerVote.Positive', 1)->
                 count();

    $downvotes = DbFinder::from('Answer')->
                 where('id', $this->getId())->
                 join('AnswerVote')->
                 where('AnswerVote.Negative', 1)->
                 count();

    // update answer in DB
    $this->setUpvotes($upvotes);
    $this->setDownvotes($downvotes);
    $originalDate = $this->getUpdatedAt();
    $this->setUpdatedAt($originalDate);
    $this->save();
  }

  public function getTotalVotes()
  {
    return $this->getUpvotes() - $this->getDownvotes();
  }

  public static function incrementUpvotes($answerId)
  {
    $answer = AnswerPeer::retrieveByPK($answerId);

    if($answer) {
      $answer->setUpvotes($answer->getUpvotes() + 1);
      $answer->save();
    }
  }

  public static function decrementUpvotes($answerId)
  {
    $answer = AnswerPeer::retrieveByPK($answerId);

    if($answer) {
      $answer->setUpvotes($answer->getUpvotes() - 1);
      $answer->save();
    }
  }

  public static function incrementDownvotes($answerId)
  {
    $answer = AnswerPeer::retrieveByPK($answerId);

    if($answer) {
      $answer->setDownvotes($answer->getDownvotes() + 1);
      $answer->save();
    }
  }

  public static function decrementDownvotes($answerId)
  {
    $answer = AnswerPeer::retrieveByPK($answerId);

    if($answer) {
      $answer->setDownvotes($answer->getDownvotes() - 1);
      $answer->save();
    }
  }

  public function setAnswer($v)
    {
        // strip tags based on current user experience.
        $userId = sfContext::getInstance()->getUser()->getCurrentUser()->getId();

        if(fpExperience::checkForAction($userId, 'post_link')){
            $allowed_tags = sfConfig::get('app_posts_allowed_tags_trusted');
        } else {
            $allowed_tags = sfConfig::get('app_posts_allowed_tags_untrusted');
        }
        
        $sanitized_string = strip_tags($v, $allowed_tags);

        // add nofollow tag
        $final_string = str_replace('<a ', '<a rel="nofollow" ', $sanitized_string);
        
        parent::setAnswer($final_string);

        return $this;
    }


  public static function constructAnswerRoute($questionTitle, $questionId, $answerId)
  {
    if($questionId && $questionTitle && $answerId)
    {
        $route = '@question_detail';
        $route .= '?question_title=' . myUtil::createSlug($questionTitle);
        $route .= '&question_id=' . $questionId;
        $route .= '#' . $answerId;
        
        return $route;
    }
  }

  public static function getShortenedDescription($answerText)
  {
    if($answerText)
    {
        $text = strip_tags(html_entity_decode($answerText));
        return substr($text, 0, sfConfig::get('app_recent_answer_length'));
    }
  }
}