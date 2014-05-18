<?php

class QuestionVotePeer extends BaseQuestionVotePeer
{
	public static function removeVote($questionId, $UserId)
	{
		$c = new Criteria();
		$c->add(self::QUESTION_ID, $questionId);
		$c->add(self::USER_ID, $UserId);
		$vote = self::doSelectOne($c);

		if($vote) {
			$vote->delete();
		}
	}

	public static function getVotesByUser($questionId, $userId)
	{
		$c = new Criteria();
		$c->add(self::QUESTION_ID, $questionId);
		$c->add(self::USER_ID, $userId);

		return self::doSelectOne($c);
	}

	public static function getCountByUser($userId, $timeInterval = false)
	{
		return DbFinder::from('QuestionVote')
		->where('userId', $userId)
		->where('createdAt', '>', time() - $timeInterval)
		->count();
	}

	public static function getByUserId($userId, $questionId = "")
	{
		$query = DbFinder::from('QuestionVote')
		->where('userId', $userId);

		if($questionId)
		{
			$query->where('questionId', $questionId);
			$result = $query->findOne();
		}
		else
		$result = $query->find();

		return $result;
	}

	public static function getByQuestionId(array $questions)
	{
        return DbFinder::from('QuestionVote')
                    ->where('QuestionId', 'in', $questions)
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
            return DbFinder::from('QuestionVote')
					        ->filterBy('CreatedAt', array('from' => $from, 'to' => $to))
                            ->where('Negative', 1)
                            ->count();
        }
        else
        {
            return DbFinder::from('QuestionVote')
					        ->filterBy('CreatedAt', array('from' => $from, 'to' => $to))
                            ->where('Positive', 1)
                            ->count();
        }
    }

    public static function getUpvotesForUser($userId)
    {
        $result = DbFinder::from('Question')->
                  where('Question.UserId', $userId)->
                  where('Question.Visible', 1)->
                  join('QuestionVote')->
                  where('QuestionVote.Positive', 1)->
                  count();

        return $result;
    }

    public static function getDownvotesForUser($userId)
    {
        $result = DbFinder::from('Question')->
                  where('Question.UserId', $userId)->
                  where('Question.Visible', 1)->
                  join('QuestionVote')->
                  where('QuestionVote.Negative', 1)->
                  count();

        return $result;
    }

    public static function getDownvotesGivenByUser($userId)
    {
         $result = DbFinder::from('Question')->
                  where('Question.Visible', 1)->
                  join('QuestionVote')->
                  where('QuestionVote.UserId', $userId)->
                  where('QuestionVote.Negative', 1)->
                  count();

        return $result;
    }
}
