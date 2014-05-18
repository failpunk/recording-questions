<?php

class User extends BaseUser
{
  public function refreshVoteCount()
  {
    // refresh vote counts for all users questions
    $questions = $this->getQuestions();
    
    foreach($questions as $question) {
      $question->refreshVoteCount();
    }

    // refresh vote counts for all users answers
    $answers = $this->getAnswers();
      
    foreach($answers as $answer) {
      $answer->refreshVoteCount();
    }

    // get the sum of all question upvotes and downvotes
//    $con = Propel::getConnection(QuestionPeer::DATABASE_NAME);
//
//    $sql = "SELECT sum(upvotes) as upvotes, sum(downvotes) as downvotes FROM question where user_id = " . $this->getId();
//    $stmt = $con->Prepare($sql);
//    $stmt->execute();
//    while($row = $stmt->fetch()) {
//      $questionUpvotes = $row['upvotes'];
//      $questionDownvotes = $row['downvotes'];
//    }
//
//    // get the sum of all answer upvotes and downvotes
//    $sql = "SELECT sum(upvotes) as upvotes, sum(downvotes) as downvotes FROM answer where user_id = " . $this->getId();
//    $stmt = $con->Prepare($sql);
//    $stmt->execute();
//    while($row = $stmt->fetch()) {
//      $answerUpvotes = $row['upvotes'];
//      $answerDownvotes = $row['downvotes'];
//    }
//
//    // consolidate vote counts and save them to user vote columns
//    $totalUpvotes   = $questionUpvotes + $answerUpvotes;
//    $totalDownvotes = $questionDownvotes + $answerDownvotes;
//
//    $this->setUpVotes($totalUpvotes);
//    $this->setDownVotes($totalDownvotes);
//    $this->save();
  }

  static public function checkVotingRights($userId)
  {
      $user = UserPeer::retrieveByPK($userId);

      if(!$user) {
        return 'You must login or register to vote.';
      }

      // does user have at least 15 experience
      if($user->getExperienceScore() < 15){
          return 'You must have at least 15 experience points to vote.';
      }

      // has this user voted 30 times today yet?
      if($user->getTodayVotes() > 29){
          return 'You have already used your 30 votes for the day.  You can vote again tomorrow.';
     }

      // user can vote
      return true;
    }

    static public function getTotalCommentCount($userId)
    {
        $answerComments = AnswerCommentPeer::countByUser($userId);
        $questionComments = QuestionCommentPeer::countByUser($userId);

        return $answerComments + $questionComments;
    }

    public function getQuestions($criteria = null, PropelPDO $con = null)
	{
        if ($criteria === null) {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
		}

        $criteria->add(QuestionPeer::VISIBLE, 1);
        
        return parent::getQuestions($criteria, $con);
    }

    public function setWebpage($v)
	{
        if($v == "http://")
        {
            $v = "";
        }

		return parent::setWebpage($v);
	}

    public function getRoute()
	{
        $route  = "@profile";
        $route .= "?display_name=" . myUtil::createSlug($this->getDisplayName());
        $route .= "&userId=" . $this->getId();

        return $route;
    }

    public function getStudioImage()
    {
        return '/images/' . sfConfig::get('app_gear_studio_images') . '/' .$this->getId() . '-250.jpg';
    }

    /**
     * Returns the percent complete for this user
     */
    public function getProfilePercentComplete()
    {
        $completeCount = 0;
        $numberColumns = 9;

        if($this->getDisplayName() != '')
            $completeCount++;

        if($this->getEmail() != '')
            $completeCount++;

        if($this->getRealName() != '')
            $completeCount++;

        if($this->getLocation() != '')
            $completeCount++;

        if($this->getWebpage() != '')
            $completeCount++;

        if($this->getCountry() != '')
            $completeCount++;

        if($this->getPostalCode() != '')
            $completeCount++;

        if($this->getBirthday() != '')
            $completeCount++;

        if($this->getInfo() != '')
            $completeCount++;

        return round($completeCount / $numberColumns, 2) * 100;
    }

    /**
     * Award user if they have completed their profile
     */
    public function checkForCompleteProfile()
    {
        if($this->getDisplayName() == '')
            return false;

        if($this->getEmail() == '')
            return false;

        if($this->getRealName() == '')
            return false;

        if($this->getLocation() == '')
            return false;

        if($this->getWebpage() == '')
            return false;

        if($this->getCountry() == '')
            return false;

        if($this->getPostalCode() == '')
            return false;

        if($this->getBirthday() == '')
            return false;

        if($this->getInfo() == '')
            return false;

        // award user
        UserAward::giveAward($this->getId(), 23);

        // mark profile as complete
        UserMeta::addMeta($this->getId(), 'profile-complete', 1);
    }
}
