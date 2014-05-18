<?php

class QuestionVote extends BaseQuestionVote
{
    static private function addVotingStatistics($questionId, $UserId, $weight)
    {
      if($weight == sfConfig::get('app_experience_upvote'))
      {
          // update vote count in question table
          Question::incrementUpvotes($questionId);
      }

      if($weight == sfConfig::get('app_experience_downvote'))
      {
          // update vote count in question table
          Question::incrementDownvotes($questionId);
      }

      // update vote count in user table
      UserPeer::incrementTodaysVotes($UserId);

      // update experience points
      //TODO: Justin - INcrement user experience
    }

    static private function removeVotingStatistics($questionId, $UserId, $weight)
    {
      if($weight == sfConfig::get('app_experience_upvote'))
      {
          // update vote count in question table
          Question::decrementUpvotes($questionId);
      }

      if($weight == sfConfig::get('app_experience_downvote'))
      {
          // update vote count in question table
          Question::decrementDownvotes($questionId);
      }

      // update vote count in user table
      UserPeer::DecrementTodaysVotes($UserId);
      
      // update experience points
      //TODO: Justin - Decrement user experience
    }

    public function addUpvote($questionId, $UserId)
    {
        $this->setUserId($UserId);
        $this->setQuestionId($questionId);
        $this->setWeight(sfConfig::get('app_experience_upvote'));
        $this->save();
    }

    public function addDownvote($questionId, $UserId)
    {
        $this->setUserId($UserId);
        $this->setQuestionId($questionId);
        $this->setWeight(sfConfig::get('app_experience_downvote'));
        $this->save();
    }
    
    static public function removeUpvote($questionId, $UserId)
    {
        QuestionVotePeer::removeVote($questionId, $UserId);
        self::removeVotingStatistics($questionId, $UserId, sfConfig::get('app_experience_upvote'));
    }

    static public function removeDownvote($questionId, $UserId)
    {
        QuestionVotePeer::removeVote($questionId, $UserId);
        self::removeVotingStatistics($questionId, $UserId, sfConfig::get('app_experience_downvote'));
    }

    public function removeVote()
    {
        if($this->getWeight() == sfConfig::get('app_experience_upvote')) {
            $this->removeUpvote($this->getQuestionId(), $this->getUserId());
        } else {
            $this->removeDownvote($this->getQuestionId(), $this->getUserId());
        }
    }

    public function save(PropelPDO $con = null)
    {
        // Save the vote and update all the statistics
        if(parent::save($con)) {
            $this->addVotingStatistics($this->getQuestionId(), $this->getUserId(), $this->getWeight());
        }
    }

}
