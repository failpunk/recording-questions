<?php

class AnswerCommentPeer extends BaseAnswerCommentPeer
{
	static function getAswerComment($answerId)
	{
		$result = DbFinder::from('AnswerComment')
		->with('User')
		->leftJoin('AnswerComment.userId', 'User.id')
		->where('answerId', $answerId)
		->find();
		return $result;
	}


	public static function countByUser($userId, $timeInterval = false)
	{
        if(!$timeInterval) {
            $timeInterval = 99999999999;
        }
        
		return DbFinder::from('AnswerComment')
						->where('AnswerComment.userId', $userId)
						->where('AnswerComment.createdAt', '>', time() - $timeInterval)
						->count();
	}
    
	public static function getActive($userId, $limit = 5)
	{
		$results = DbFinder::from('AnswerComment')
                        ->join('Answer')
                        ->join('Question')
                        ->where('Answer.visible', 1)
                        ->select(array('AnswerComment.id', 'AnswerComment.UserId', 'AnswerComment.Description', 'AnswerComment.AnswerId', 'Question.Id', 'Question.Title'))
						->where('AnswerComment.userId', $userId)
                        ->orderBy('AnswerComment.createdAt', 'desc')
                        ->limit($limit)
						->find();

        return $results;
	}
}
