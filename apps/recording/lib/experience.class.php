<?php
/**
 * Description of Experience
 *
 * This class will handle the calculation and modification of the user experience system.
 *
 * @author justin
 */
class Experience
{
   /**
    * Rebuilds a users experience score from the database.
    *
    * @param int $userId                A users id
    * @param bool $refreshAll           Optional prameter that when set to true will recalculate all the vote counts on the users questions and answers
    *                                   before attempting to recalculate the users experience.  Set to false the existings count values will not be updated.
    * @return int                       The users newly calculated experience score
    */
    public static function rebuildUserExperience($userId, $refreshAll = true)
    {
        //todo: figure out how to combine some of the queries into 1.
        $user = UserPeer::retrieveByPK($userId);

        if(!$user) {
          sfContext::getInstance()->getLogger()->warning("function: rebuildUserExperience could not find userId: $userId");
          return false;
        }

        // check if we should refresh all the vote count columns before calculation begins
        if($refreshAll) {
          $user->refreshVoteCount();
        }


        // get questions and answers with upvotes
        $questionUpVotes = QuestionVotePeer::getUpvotesForUser($userId);
        $answerUpVotes   = AnswerVotePeer::getUpvotesForUser($userId);
        $totalUpVotes    = $questionUpVotes + $answerUpVotes;


        // get downvotes received
        $questionDownVotesReceived = QuestionVotePeer::getDownvotesForUser($userId);
        $answerDownVotesReceived   = AnswerVotePeer::getDownvotesForUser($userId);
        $totalDownVotesReceived    = $questionDownVotesReceived + $answerDownVotesReceived;


        // get question and answer downvotes given
        $questionDownVotesGiven = QuestionVotePeer::getDownvotesGivenByUser($userId);
        $answerDownVotesGiven   = AnswerVotePeer::getDownvotesGivenByUser($userId);
        $totalDownVotesGiven    = $questionDownVotesGiven + $answerDownVotesGiven;


        // get answers marked as best answer
        $acceptedAnswers = AnswerPeer::getBestAnswersReceivedCount($userId);
        
        // get answers user marked as best answer
        $answersAccepted = AnswerPeer::getBestAnswersGivenCount($userId);


        // get questions voted offensive > 5 times

        // Get any gear added
        $gearAdded = RecentActivityPeer::countGearAddedByUser($userId);

        // Get any user reviews added
        $reviewsAdded = GearReviewPeer::getCount($userId);

        // don't add experience to recording questions account
        if($userId == 4)
        {
            $gearAdded = 0;
            $reviewsAdded = 0;
        }

        // calculate experience points
        $upvotesReceievedPoints  = $totalUpVotes * sfConfig::get('app_experience_add_vote');
        $downvotesReceivedPoints = $totalDownVotesReceived * sfConfig::get('app_experience_sub_vote');
        $downvotesGivenPoints    = $totalDownVotesGiven * sfConfig::get('app_experience_sub_you_downvote');
        $acceptedAnswersPoints   = $acceptedAnswers * sfConfig::get('app_experience_add_best_answer');
        $acceptedAnAnswerPoints  = $answersAccepted * sfConfig::get('app_experience_add_select_best_answer');
        
        $gearAddedPoints         = $gearAdded * sfConfig::get('app_experience_add_gear');
        $reviewsAddedPoints      = $reviewsAdded * sfConfig::get('app_experience_add_user_review');

        $experiencePoints = $upvotesReceievedPoints - $downvotesReceivedPoints - $downvotesGivenPoints + $acceptedAnswersPoints + $acceptedAnAnswerPoints + $gearAddedPoints + $reviewsAddedPoints;

        // update users experience field.
        $user->setExperienceScore($experiencePoints);
        $user->save();

        return $experiencePoints;
    }

    public static function recalcAllUsers()
    {
        $users = UserPeer::doSelect(new Criteria());

        foreach($users as $user) 
        {
            if($user->getId() != 1)
            {
                echo $user->getDisplayName();
                $points = self::rebuildUserExperience($user->getId());
                echo " - Experience: $points\n";
            }
        }
    }
}
?>
