<?php

class AnswerPeer extends BaseAnswerPeer
{
	public function updateOffensiveAnswer($answerId)
	{
		$con = Propel::getConnection(AnswerPeer::DATABASE_NAME);

		$selc = new Criteria();
		$selc->add(AnswerPeer::ID, $answerId);

		$updc = new Criteria();
		$updc->add(AnswerPeer::OFFENSIVE, array('raw' =>  AnswerPeer::OFFENSIVE. ' + ?', 'value' => 1), Criteria::CUSTOM_EQUAL);

		BasePeer::doUpdate($selc, $updc, $con);
	}

	public static function getAnswerByQuestion($questionId, $orderBy = '', $limit = null)
	{
		$query = DbFinder::from('Answer')
		->leftJoin('Answer.userId', 'User.Id')
		->leftJoin('AnswerComment')
		->withColumn('(Answer.upvotes - Answer.downvotes)', 'total_vote')
		->where('Answer.questionId', $questionId)
		->where('Answer.Visible', true)
        ->withColumn('count(AnswerComment.Id)', 'total_answer_comment');

		$query->orderBy('bestanswer', 'desc');

		if(!$orderBy)
		$query->orderBy('total_vote', 'desc');
		if($orderBy == 'newest')
		$query->orderBy('createdAt', 'desc');
		if($orderBy == 'oldest')
		$query->orderBy('createdAt', 'asc');
		if($orderBy == 'votes')
		$query->orderBy('total_vote', 'desc');

		if($limit)
		  $query->limit($limit);

	    $query->groupBy('Answer.Id');

		$result = $query->find();

		return $result;
	}

	public static  function countByUser($userId, $timeInterval)
	{
		return DbFinder::from('Answer')
                       ->where('Answer.userId', $userId)
                       ->where('Answer.createdAt', '>', time() - $timeInterval)
                       ->where('Answer.Visible', true)
                       ->count();
	}

    public static function updateVote($answerId, $state, $reverse = false)
    {
        $con = Propel::getConnection(AnswerPeer::DATABASE_NAME);

        $selc = new Criteria();
        $selc->add(AnswerPeer::ID, $answerId);

        $updc = new Criteria();

        if(!$reverse)
        {
            if($state)
                $updc->add(AnswerPeer::UPVOTES, array('raw' =>  AnswerPeer::UPVOTES. ' + ?', 'value' => 1), Criteria::CUSTOM_EQUAL);
            else
                $updc->add(AnswerPeer::DOWNVOTES, array('raw' =>  AnswerPeer::DOWNVOTES. ' + ?', 'value' => 1), Criteria::CUSTOM_EQUAL);
        }
        else
        {
            if($state)
                $updc->add(AnswerPeer::UPVOTES, array('raw' =>  AnswerPeer::UPVOTES. ' - ?', 'value' => 1), Criteria::CUSTOM_EQUAL);
            else
                $updc->add(AnswerPeer::DOWNVOTES, array('raw' =>  AnswerPeer::DOWNVOTES. ' - ?', 'value' => 1), Criteria::CUSTOM_EQUAL);
        }
        BasePeer::doUpdate($selc, $updc, $con);

        $c = new Criteria();
        $c->add(AnswerPeer::ID, $answerId);
        $answerPeer = BaseAnswerPeer::doSelectOne($c);
        $answerPeer->reload();

        return $answerPeer->getUpvotes() - $answerPeer->getDownvotes();
    }

    public function getTotalVotes()
	{
	   return $this->getUpvotes() - $this->getDownvotes();
	}

	public static function getByUser($userId, $page = '', $perPage = 10)
    {
        $query = DbFinder::from("Answer")
                        ->where('userId', $userId)
                        ->where('Answer.Visible', true);
        if($page)
            return $query->paginate($page, $perPage);
        else
            return $query->find();
    }

    public static function getByIdPk($answerId, $isAdmin = false)
    {
    	$query =  DbFinder::from('Answer')
    	        ->where('id', $answerId);

    	        if(!$isAdmin)
    	           $query->where('Answer.Visible', true);

        return $query->findOne();
    }

    public static function getDeleteAnswer($currentPage, $maxResultsPerPage, $questionId = '')
    {
    	$query = DbFinder::from('Answer')
    	->leftJoin('Answer.userId', 'User.Id')
        ->leftJoin('AnswerComment')
        ->leftJoin('User')
        ->with('User')
        ->withColumn('(Answer.upvotes - Answer.downvotes)', 'total_vote')
        ->withColumn('count(AnswerComment.Id)', 'total_answer_comment')
        ->where('Answer.Visible', false);

        if(isset($questionId))
            $query->where('Answer.QuestionId', $questionId);

        $query->orderBy('updatedAt', 'desc')
              ->groupBy('Answer.Id');

        $result = $query->paginate($currentPage, $maxResultsPerPage);
        return $result;
    }

    static function getNewAnswersByUser($userId, $afterThisDate = false)
	{
        // default to 7 days ago.
        if(!$afterThisDate) {
            $afterThisDate = date('Y-m-d h:i:s', time() - (86400 * 7));
        }
 
        $results = DbFinder::from('Answer')
            ->join('Question')
            ->where('Question.UserId', $userId)
            ->where('Answer.CreatedAt', '>', $afterThisDate)
            ->find();
            
        return $results;
    }

    static public function getCountBetweenDates($from, $to)
    {
        if(!$from) {
            $from = '2009-01-01 00:00:00';
        }

        if(!$from) {
            $to = '2099-01-01 00:00:00';
        }

        return DbFinder::from('Answer')
					        ->filterBy('CreatedAt', array('from' => $from, 'to' => $to))
                            ->count();
    }

    public static function getBestAnswersReceivedCount($userId)
    {
        $result = DbFinder::from('Answer')->
                  where('UserId', $userId)->
                  where('Bestanswer', 1)->
                  count();

        return $result;
    }
    
    public static function getBestAnswersGivenCount($userId)
    {
        $result = DbFinder::from('Question')->
                  where('Question.UserId', $userId)->
                  join('Answer')->
                  where('Answer.Bestanswer', 1)->
                  count();

        return $result;
    }

    public static function softDeleteByQuestion($questionId)
    {
        DbFinder::from('Answer')
              ->where('questionId', $questionId)
              ->set(array('visible' => 0));
    }

    public static function getRecentAnswers($limit = 5)
    {
        return DbFinder::from('Answer')
                  ->join('Question')
                  ->join('User')
                  ->where('Answer.Visible', 1)
                  ->where('Question.Visible', 1)
                  ->orderBy('CreatedAt', 'desc')
                  ->select(array('Answer.Id', 'Answer.QuestionId', 'Answer.Answer', 'Answer.UserId', 'Answer.CreatedAt', 'User.DisplayName', 'Question.Title'))
                  ->limit($limit)
                  ->find();
    }
}