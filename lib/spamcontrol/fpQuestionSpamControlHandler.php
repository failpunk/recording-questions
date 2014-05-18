<?php

class fpQuestionSpamControlHandler extends fpSpamControlHandler
{
	public function execute()
	{
		$spamConf = sfConfig::get('app_question_spam', array());

		$user = self::getCurrentUser();

		$QuestionAskCount = QuestionPeer::countByUser($user->getId(), $spamConf['period']);
                
		if($QuestionAskCount >= $spamConf['limit'])
		{
            $this->addCredential('question-spamer');
		}
		else
		{
            $this->removeCredential('question-spamer');
		}
	}
}
