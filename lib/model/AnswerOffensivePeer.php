<?php

class AnswerOffensivePeer extends BaseAnswerOffensivePeer
{

    public static function getCountByUser($userId, $timeInterval)
    {
        return DbFinder::from('AnswerOffensive')
        ->where('userId', $userId)
        ->where('createdAt', '>', $timeInterval)
        ->count();
    }

    public static function addOffensive($userId, $questionId)
    {
        $answerOffensive = new AnswerOffensive();
        $answerOffensive->setUserId($userId);
        $answerOffensive->setAnswerId($questionId);
        $answerOffensive->save();
    }

    public static function getByUserId($userId, $answerId)
    {
        return DbFinder::from('AnswerOffensive')
                        ->where('userId', $userId)
                        ->where('answerId', $answerId)
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

        return DbFinder::from('AnswerOffensive')
					        ->filterBy('CreatedAt', array('from' => $from, 'to' => $to))
                            ->withColumn('COUNT(Id)', 'count')
                            ->groupBy('AnswerId')
                            ->find();
    }
}
