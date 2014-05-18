<?php

class QuestionComment extends BaseQuestionComment
{
    static public function addComment($questionId, $comment, $userId)
    {
        // strip all tags
        $comment = strip_tags($comment);
        
        // Convert text to URL if user has rights
        if(fpExperience::checkForAction($userId, 'upvote'))
        {
            $comment = preg_replace('@(http://([\w-.]+)+(:\d+)?(/([\w/_.]*(\?\S+)?)?)?)@', '<a rel="nofollow" href="$1">$1</a>', $comment);
        }

        $questionComment = new QuestionComment();
        $questionComment->setQuestionId($questionId);
        $questionComment->setDescription($comment);
        $questionComment->setUserId($userId);
        $questionComment->save();

        return $questionComment;
    }
}
