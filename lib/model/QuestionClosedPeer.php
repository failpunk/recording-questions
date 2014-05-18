<?php

class QuestionClosedPeer extends BaseQuestionClosedPeer
{
    public static function deleteExistingReason($questionId)
    {
        $questionClosed = DbFinder::from('QuestionClosed')
                ->where('questionId', $questionId)
                ->delete();
    }

    public static function getExistingReason($questionId)
    {
        return DbFinder::from('QuestionClosed')
                ->where('questionId', $questionId)
                ->findOne();
    }
}
