<?php

class QuestionOffensivePeer extends BaseQuestionOffensivePeer
{

    public static function getCountByUser($userId, $timeInterval)
    {
        return DbFinder::from('QuestionOffensive')
        ->where('userId', $userId)
        ->where('createdAt', '>', $timeInterval)
        ->count();
    }

    public static function addOffensive($userId, $questionId)
    {
    	$questionOffensive = new QuestionOffensive();
    	$questionOffensive->setUserId($userId);
    	$questionOffensive->setQuestionId($questionId);
    	$questionOffensive->save();
    }

    public static function getByUserId($userId, $questionId)
    {
        return DbFinder::from('QuestionOffensive')
                        ->where('userId', $userId)
                        ->where('questionId', $questionId)
                        ->findOne();
    }

    static public function getBetweenDates($from, $to)
    {
        if(!$from) {
            $from = '2009-01-01 00:00:00';
        }

        if(!$to) {
            $to = '2099-01-01 00:00:00';
        }

        return DbFinder::from('QuestionOffensive')
					        ->filterBy('CreatedAt', array('from' => $from, 'to' => $to))
                            ->withColumn('COUNT(Id)', 'count')
                            ->groupBy('QuestionId')
                            ->find();
    }
}
