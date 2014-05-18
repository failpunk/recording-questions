<?php

class AnswerVotePeer extends BaseAnswerVotePeer
{
    public static function getAllAnswerVotesForQuestionByUser($QuestionId, $userId)
    {
        $con = Propel::getConnection(self::DATABASE_NAME);

        $sql = "select av.answer_id as id, av.weight as weight
                from answer_vote av
                left join answer a on a.id = av.answer_id
                where a.question_id = ?
                and av.user_id = ?";
        $stmt = $con->Prepare($sql);
        $stmt->bindValue(1, $QuestionId);
        $stmt->bindValue(2, $userId);
        $stmt->execute();

        $results = array();

        while($row = $stmt->fetch()) {
          $vote = array(
            'id' => $row['id'],
            'weight' => $row['weight']
          );

          $results[] = $vote;
        }

        return $results;
    }

    public static function removeVote($answerId, $UserId)
    {
        $c = new Criteria();
        $c->add(self::ANSWER_ID, $answerId);
        $c->add(self::USER_ID, $UserId);
        $vote = self::doSelectOne($c);

        if($vote) {
            $vote->delete();
        }
    }

    public static function getCountByUser($userId, $timeInterval)
    {
    	return DbFinder::from('AnswerVote')
    	               ->where('userId', $userId)
    	               ->where('createdAt', '>', time() - $timeInterval)
    	               ->count();
    }

    public static function getByUserId($userId, $answerId = "")
    {
    	$query = DbFinder::from('AnswerVote')
        ->where('userId', $userId);

        if($answerId)
        {
            $query->where('answerId', $answerId);
            $result = $query->findOne();
        }
        else
            $result = $query->find();

        return $result;
    }

    public static function getByAnswers($answers, $userId = "")
    {
    	$answerId = array();
    	foreach ($answers as $answer)
    	{
    		$answerId[$answer->getId()] = $answer->getId();
    	}
         $query = DbFinder::from('AnswerVote');

         if($userId)
            $query->where('userId', $userId);

        $query->where('AnswerVote.AnswerId', 'in', $answerId);

        $result = $query->find();

        $arrayRes = array();
        foreach ($result as $res)
        {
        	$arrayRes[$res->getAnswerId()] = $res;
        }

        return $arrayRes;
    }

    public static function getByAnswerIds($answers)
    {
        return DbFinder::from('AnswerVote')
                    ->where('AnswerId', 'in', $answers)
                    ->find();
    }

    static public function getCountBetweenDates($from, $to, $voteType = 'upvote')
    {
        if(!$from) {
            $from = '2009-01-01 00:00:00';
        }

        if(!$to) {
            $to = '2099-01-01 00:00:00';
        }

        if($voteType != 'upvote')
        {
            return DbFinder::from('AnswerVote')
					        ->filterBy('CreatedAt', array('from' => $from, 'to' => $to))
                            ->where('Negative', 1)
                            ->count();
        }
        else
        {
            return DbFinder::from('AnswerVote')
					        ->filterBy('CreatedAt', array('from' => $from, 'to' => $to))
                            ->where('Positive', 1)
                            ->count();
        }
    }
    
    public static function getUpvotesForUser($userId)
    {
        $result = DbFinder::from('Answer')->
                  where('Answer.UserId', $userId)->
                  where('Answer.Visible', 1)->
                  join('AnswerVote')->
                  where('AnswerVote.Positive', 1)->
                  count();

        return $result;
    }

    public static function getDownvotesForUser($userId)
    {
        $result = DbFinder::from('Answer')->
                  where('Answer.UserId', $userId)->
                  where('Answer.Visible', 1)->
                  join('AnswerVote')->
                  where('AnswerVote.Negative', 1)->
                  count();

        return $result;
    }
    
    public static function getDownvotesGivenByUser($userId)
    {
        $result = DbFinder::from('Answer')->
                  where('Answer.Visible', 1)->
                  join('AnswerVote')->
                  where('AnswerVote.UserId', $userId)->
                  where('AnswerVote.Negative', 1)->
                  count();

        return $result;
    }

}
