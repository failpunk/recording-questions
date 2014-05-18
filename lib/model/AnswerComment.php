<?php

class AnswerComment extends BaseAnswerComment
{
    static public function addComment($answerId, $comment, $userId)
    {
        // strip all tags
        $comment = strip_tags($comment);

        // Convert text to URL if user has rights
        if(fpExperience::checkForAction($userId, 'upvote'))
        {
            $comment = preg_replace('@(http://([\w-.]+)+(:\d+)?(/([\w/_.]*(\?\S+)?)?)?)@', '<a rel="nofollow" href="$1">$1</a>', $comment);
        }

        $answerComment = new AnswerComment();
        $answerComment->setAnswerId($answerId);
        $answerComment->setDescription($comment);
        $answerComment->setUserId($userId);
        $answerComment->save();

        return $answerComment;
    }
}
