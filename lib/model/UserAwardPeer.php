<?php

class UserAwardPeer extends BaseUserAwardPeer
{
    static public function awardFirstUpvoteGiven($awardId, $date)
    {
        $sql = "
            INSERT IGNORE INTO user_award (user_id, award_id, created_at)
              SELECT qv.user_id, $awardId, '$date'
              FROM question_vote qv
              WHERE qv.positive = 1
              GROUP BY qv.user_id
              UNION ALL
              SELECT av.user_id, $awardId, '$date'
              FROM answer_vote av
              WHERE av.positive = 1
              GROUP BY av.user_id;
        ";

        self::executeSql($sql);
    }
    
    static public function awardFirstDownvoteGiven($awardId, $date)
    {
        $sql = "
            INSERT IGNORE INTO user_award (user_id, award_id, created_at)
              SELECT qv.user_id, $awardId, '$date'
              FROM question_vote qv
              WHERE qv.negative = 1
              GROUP BY qv.user_id
              UNION ALL
              SELECT av.user_id, $awardId, '$date'
              FROM answer_vote av
              WHERE av.negative = 1
              GROUP BY av.user_id;
        ";

        self::executeSql($sql);
    }
    
    static public function awardFirstUpvotedQuestion($awardId, $date)
    {
        $sql = "
            INSERT IGNORE INTO user_award (user_id, award_id, created_at)
              SELECT q.user_id, $awardId, '$date'
              FROM question q
              WHERE q.upvotes > 0
              GROUP BY q.user_id;
        ";

        self::executeSql($sql);
    }

    static public function awardFirstUpvotedAnswer($awardId, $date)
    {
        $sql = "
            INSERT IGNORE INTO user_award (user_id, award_id, created_at)
              SELECT a.user_id, $awardId, '$date'
              FROM answer a
              WHERE a.upvotes > 0
              GROUP BY a.user_id;
        ";

        self::executeSql($sql);
    }

    static public function awardFirstQuestion($awardId, $date)
    {
        $sql = "
            INSERT IGNORE INTO user_award (user_id, award_id, created_at)
              SELECT q.user_id, $awardId, '$date'
              FROM question q
              GROUP BY q.user_id;
        ";

        self::executeSql($sql);
    }

    static public function awardFirstAnswer($awardId, $date)
    {
        $sql = "
            INSERT IGNORE INTO user_award (user_id, award_id, created_at)
              SELECT a.user_id, $awardId, '$date'
              FROM answer a
              GROUP BY a.user_id;
        ";

        self::executeSql($sql);
    }

    static public function awardFirstComment($awardId, $date)
    {
        $sql = "
            INSERT IGNORE INTO user_award (user_id, award_id, created_at)
              SELECT qc.user_id, $awardId, '$date'
              FROM question_comment qc
              GROUP BY qc.user_id
              UNION ALL
              SELECT ac.user_id, $awardId, '$date'
              FROM answer_comment ac
              GROUP BY ac.user_id;
        ";

        self::executeSql($sql);
    }

    static public function awardTenComments($awardId, $date)
    {
        $sql = "
            INSERT IGNORE INTO user_award (user_id, award_id, created_at)
              SELECT final.user_id, $awardId, '$date'
              FROM (
                SELECT comments.user_id, sum(comments.count) as count
                FROM (
                  SELECT qc.user_id, count(qc.id)as count
                  FROM question_comment qc
                 GROUP BY qc.user_id
                  UNION ALL
                 SELECT ac.user_id, count(ac.id)as count
                  FROM answer_comment ac
                  GROUP BY ac.user_id
                ) as comments
                GROUP BY comments.user_id
              ) as final
              WHERE final.count >= 10;
        ";

        self::executeSql($sql);
    }

    static public function awardQuestionWithFiveFavorites($awardId, $date)
    {
        $sql = "
            INSERT IGNORE INTO user_award (user_id, award_id, created_at)
              SELECT q.user_id, $awardId, '$date'
                FROM (
                  SELECT uf.question_id, count(uf.user_id) as count
                  FROM user_favorite uf
                  GROUP BY uf.question_id
                ) as favorites
                JOIN question q
                ON q.id = favorites.question_id
                where favorites.count >= 5;
        ";

        self::executeSql($sql);
    }

    static public function awardQuestionWithOneFavorite($awardId, $date)
    {
        $sql = "
            INSERT IGNORE INTO user_award (user_id, award_id, created_at)
              SELECT q.user_id, $awardId, '$date'
                FROM (
                  SELECT uf.question_id, count(uf.user_id) as count
                  FROM user_favorite uf
                  GROUP BY uf.question_id
                ) as favorites
                JOIN question q
                ON q.id = favorites.question_id
                where favorites.count > 1;
        ";

        self::executeSql($sql);
    }

    static public function getAwardsForUser($userId)
    {
        return DbFinder::from('UserAward')
            ->where('UserId', $userId)
            ->where('UserId', '<>', 1)      //exclude guest user
            ->find();
    }

    static public function getAwardsWithInfo($userId)
    {
        return DbFinder::from('Award')
            ->join('UserAward')
            ->where('UserAward.UserId', $userId)
            ->find();
    }

    static public function getUserAwardCount($userId)
    {
        $result = DbFinder::from('UserAward')
            ->withColumn('COUNT(UserAward.UserId)', 'Count')
            ->where('UserId', $userId)
            ->select(array('Count'))
            ->find();

        return $result[0]['Count'];
    }

    static public function awardFirstGearAdded($awardId, $date)
    {
        $sql = "
            INSERT IGNORE INTO user_award (user_id, award_id, created_at)
              SELECT ug.user_id, $awardId, '$date'
                  FROM user_gear ug
                  GROUP BY ug.user_id;
        ";

        self::executeSql($sql);
    }

    static public function awardTenGearAdded($awardId, $date)
    {
        $sql = "
            INSERT IGNORE INTO user_award (user_id, award_id, created_at)
              SELECT gears.user_id, $awardId, '$date'
                FROM (
                  SELECT ug.user_id, count(ug.user_id) as count
                  FROM user_gear ug
                  GROUP BY ug.user_id
                ) as gears
                where gears.count > 9;
        ";

        self::executeSql($sql);
    }

    static public function awardFirstGearInfoEdit($awardId, $date)
    {
        $sql = "
            INSERT IGNORE INTO user_award (user_id, award_id, created_at)
              SELECT gi.user_id, $awardId, '$date'
                  FROM gear_info gi
                  GROUP BY gi.user_id;
        ";

        self::executeSql($sql);
    }

    static public function awardFirstGearReview($awardId, $date)
    {
        $sql = "
            INSERT IGNORE INTO user_award (user_id, award_id, created_at)
              SELECT gr.user_id, $awardId, '$date'
                  FROM gear_review gr
                  WHERE gr.type = 1
                  GROUP BY gr.user_id;
        ";

        self::executeSql($sql);
    }

    static public function awardFirstSiteReview($awardId, $date)
    {
        $sql = "
            INSERT IGNORE INTO user_award (user_id, award_id, created_at)
              SELECT gr.user_id, $awardId, '$date'
                  FROM gear_review gr
                  WHERE gr.type = 0
                  GROUP BY gr.user_id;
        ";

        self::executeSql($sql);
    }

    static public function awardFirstGearToDb($awardId, $date)
    {
        $sql = "
            INSERT IGNORE INTO user_award (user_id, award_id, created_at)
              SELECT ra.user_id, $awardId, '$date'
                  FROM recent_activity ra
                  WHERE ra.activity = 'created'
                  GROUP BY ra.user_id;
        ";

        self::executeSql($sql);
    }

    static public function awardAddedTwitter($awardId, $date)
    {
        $sql = "
            INSERT IGNORE INTO user_award (user_id, award_id, created_at)
              SELECT um.user_id, $awardId, '$date'
                  FROM user_meta um
                  WHERE um.key = 'twittername'
                  GROUP BY um.user_id;
        ";

        self::executeSql($sql);
    }

    static public function awardFirstBestAnswer($awardId, $date)
    {
        $sql = "
            INSERT IGNORE INTO user_award (user_id, award_id, created_at)
              SELECT a.user_id, $awardId, '$date'
              FROM answer a
              WHERE a.bestAnswer = 1
              GROUP BY a.user_id;
        ";

        self::executeSql($sql);
    }

    static public function awardTenBestAnswers($awardId, $date)
    {
        $sql = "
            INSERT IGNORE INTO user_award (user_id, award_id, created_at)
                SELECT answers.user_id, $awardId, '$date'
                FROM (
                    SELECT a.user_id, count(a.bestAnswer) as count
                      FROM answer a
                      WHERE a.bestAnswer = 1
                      GROUP BY a.user_id
                    ) as answers
                WHERE answers.count > 9;
        ";

        self::executeSql($sql);
    }

    static public function getAwardsCount()
    {
        $results = DbFinder::from('UserAward')
            ->withColumn('COUNT(UserAward.UserId)', 'Count')
            ->select(array('AwardId', 'Count'))
            ->orderBy('AwardId')
            ->groupBy('AwardId')
            ->find();

        // return an array with AwardId as key and Count as value
        $newArray = array();
        foreach($results as $result)
        {
            $newArray[$result['AwardId']] = $result['Count'];
        }

        return $newArray;
    }

    static public function markAllAwardsAsNotified()
    {

        $con = Propel::getConnection();

        $sql = "
            UPDATE user_award
              set notification_sent = 1
              WHERE notification_sent = 0;
        ";

        $stmt = $con->Prepare($sql);
        $stmt->execute();
    }

    private static function executeSql($sql)
    {
        $con = Propel::getConnection();
        $stmt = $con->Prepare($sql);
        $stmt->execute();
    }

    static public function giveAward($userId, $awardId)
    {
        $date = date("Y-m-d h:i:s");
        
        $sql = "
            INSERT IGNORE INTO user_award (user_id, award_id, created_at)
              SELECT $userId, $awardId, '$date'";

        self::executeSql($sql);
    }
}
