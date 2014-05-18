<?php

class QuestionClosed extends BaseQuestionClosed
{
    public static function getLockedReason($questionId)
    {
        if($questionId)
        {
            $lockedReason = QuestionClosedPeer::getExistingReason($questionId);
            
            if($lockedReason) {
                return $lockedReason->getReasonType();
            }
        }
        return '';
    }
}
