<?php

class fpCommentSpamControlHandler extends fpSpamControlHandler
{

	public function execute()
	{

		$spamConf = sfConfig::get('app_comment_spam', array());

		$user = self::getCurrentUser();

        $AnswerCommentCount = AnswerCommentPeer::countByUser($user->getId(), $spamConf['period']);
        $QuestionCommentCount = QuestionCommentPeer::countByUser($user->getId(), $spamConf['period']);
        $CommentCount = $AnswerCommentCount + $QuestionCommentCount;

        if($CommentCount >= $spamConf['limit'])
		{
			$this->addCredential('comment-spamer');
		}
		else
		{
			$this->removeCredential('comment-spamer');
		}
	}

}