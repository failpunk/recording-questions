<?php

class fpExperienceQuestionControlHandler extends fpSpamControlHandler
{
	public function execute()
	{

		$spamConf = sfConfig::get('app_answer_spam', array());

		$user = self::getCurrentUser();

		$AnswerCount = AnswerPeer::countByUser($user->getId(), $spamConf['period']);

		if($AnswerCount >= $spamConf['limit'])
		{
			$this->addCredential('answer-spamer');
		}
		else
		{
			$this->removeCredential('answer-spamer');
		}
	}

}