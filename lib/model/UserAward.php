<?php
/**
 * Adding a new award:
 *
 * 1) Add award record to Award table
 * 2) Create sql for award in UserAwardPeer
 * 3) Add award logic to UserAward
 */
class UserAward extends BaseUserAward
{
    /**
     * New awards are kicked off from here.
     */
    static public function giveAwards()
    {
        $result = true;
        $date = date("Y-m-d h:i:s");

        // Give users any new awards
        UserAwardPeer::awardFirstUpvoteGiven(1, $date);
        UserAwardPeer::awardFirstDownvoteGiven(2, $date);
        UserAwardPeer::awardFirstUpvotedQuestion(5, $date);
        UserAwardPeer::awardFirstUpvotedAnswer(8, $date);
        UserAwardPeer::awardFirstQuestion(3, $date);
        UserAwardPeer::awardFirstAnswer(4, $date);
        UserAwardPeer::awardFirstComment(6, $date);
        UserAwardPeer::awardTenComments(7, $date);
        UserAwardPeer::awardQuestionWithOneFavorite(12, $date);
        UserAwardPeer::awardQuestionWithFiveFavorites(9, $date);
        UserAwardPeer::awardFirstBestAnswer(22, $date);
        UserAwardPeer::awardTenBestAnswers(20, $date);

        // Gear Awards
        UserAwardPeer::awardFirstGearAdded(14, $date);
        UserAwardPeer::awardTenGearAdded(13, $date);
        UserAwardPeer::awardFirstGearInfoEdit(15, $date);
        UserAwardPeer::awardFirstGearReview(16, $date);
        UserAwardPeer::awardFirstSiteReview(17, $date);
        UserAwardPeer::awardFirstGearToDb(18, $date);

        // Other Awards
        UserAwardPeer::awardAddedTwitter(19, $date);

        // Notify users with any new awards
        self::notifyOfNewAwards();

        // Mark all award records as notified
        UserAwardPeer::markAllAwardsAsNotified();
    }

    /**
     * Give a single award
     */
    static public function giveAward($userId, $awardId)
    {
        // give award
        if($userId && $awardId)
        {
            UserAwardPeer::giveAward($userId, $awardId);
        }
    }

    private static function notifyOfNewAwards()
    {
        // get all awards that have not yet had a notification sent
        $newAwards = DbFinder::from('UserAward')
                ->with('Award')
                ->where('UserAward.NotificationSent', 0)
                ->find();

        // insert a notification into the DB to the user
        foreach($newAwards as $award)
        {
            $awardName = $award->getAward()->getName();

            $message = self::createAwardNotificationText($awardName);
            UserMessagePeer::createNewUserMessage($award->getUserId(), $message);
        }
    }

    private static function createAwardNotificationText($awardName)
    {
        $message  = "<h4>You have just gained the $awardName award!</h4>";
        $message .= '<p><a href="/award">Visit the awards page</a>.</p>';
        return $message;
    }
}
