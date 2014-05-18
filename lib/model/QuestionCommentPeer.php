<?php

class QuestionCommentPeer extends BaseQuestionCommentPeer
{
	public static function getQuestionComment($quetionId, $limit = 0)
	{
        return DbFinder::from('QuestionComment')
					        ->with('User')
					        ->leftJoin('QuestionComment.userId', 'User.id')
					        ->where('questionId', $quetionId)
                            ->limit($limit)
					        ->find();
	}

    public static function countByUser($userId, $timeInterval = false)
    {
        if(!$timeInterval) {
            $timeInterval = 99999999999;
        }

        return DbFinder::from('QuestionComment')
                        ->where('QuestionComment.userId', $userId)
                        ->where('QuestionComment.createdAt', '>', time() - $timeInterval)
                        ->count();
    }

    public static function countByQuestionId($questionId)
    {
        return DbFinder::from('QuestionComment')
                            ->where('questionId', $questionId)
                            ->count();
    }

    public static function getActive($userId, $limit = 5)
	{
        $results = DbFinder::from('QuestionComment')
                        ->join('Question')
                        ->where('Question.visible', 1)
                        ->select(array('QuestionComment.id', 'QuestionComment.UserId', 'QuestionComment.Description', 'Question.Id', 'Question.Title'))
						->where('QuestionComment.userId', $userId)
                        ->orderBy('QuestionComment.createdAt', 'desc')
                        ->limit($limit)
						->find();

        return $results;
	}
}
