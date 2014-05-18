<?php

class AnswerVote extends BaseAnswerVote
{
    public function addUpvote($answerId, $UserId)
    {
        $this->setUserId($UserId);
        $this->setAnswerId($answerId);
        $this->setWeight(sfConfig::get('app_experience_upvote'));
        $this->save();
    }

    public function addDownvote($answerId, $UserId)
    {
        $this->setUserId($UserId);
        $this->setAnswerId($answerId);
        $this->setWeight(sfConfig::get('app_experience_downvote'));
        $this->save();
    }

    static public function removeUpvote($answerId, $UserId)
    {
        AnswerVotePeer::removeVote($answerId, $UserId);
        self::removeVotingStatistics($answerId, $UserId, sfConfig::get('app_experience_upvote'));
    }

    static public function removeDownvote($answerId, $UserId)
    {
        AnswerVotePeer::removeVote($answerId, $UserId);
        self::removeVotingStatistics($answerId, $UserId, sfConfig::get('app_experience_downvote'));
    }

    static private function addVotingStatistics($answerId, $UserId, $weight)
    {
      if($weight == sfConfig::get('app_experience_upvote'))
      {
          // update vote count in question table
          Answer::incrementUpvotes($answerId);
      }

      if($weight == sfConfig::get('app_experience_downvote'))
      {
          // update vote count in question table
          Answer::incrementDownvotes($answerId);
      }

      // update vote count in user table
      UserPeer::incrementTodaysVotes($UserId);

      // update experience points
      //TODO: Justin - INcrement user experience
    }

    static private function removeVotingStatistics($answerId, $UserId, $weight)
    {
      if($weight == sfConfig::get('app_experience_upvote'))
      {
          // update vote count in question table
          Answer::decrementUpvotes($answerId);
      }

      if($weight == sfConfig::get('app_experience_downvote'))
      {
          // update vote count in question table
          Answer::decrementDownvotes($answerId);
      }

      // update vote count in user table
      UserPeer::DecrementTodaysVotes($UserId);

      // update experience points
      //TODO: Justin - Decrement user experience
    }

    public function removeVote()
    {
        if($this->getWeight() == sfConfig::get('app_experience_upvote')) {
            $this->removeUpvote($this->getAnswerId(), $this->getUserId());
        } else {
            $this->removeDownvote($this->getAnswerId(), $this->getUserId());
        }
    }

    public function save(PropelPDO $con = null)
    {
        // Save the vote and update all the statistics
        if(parent::save($con)) {
            $this->addVotingStatistics($this->getAnswerId(), $this->getUserId(), $this->getWeight());
        }
    }
}
