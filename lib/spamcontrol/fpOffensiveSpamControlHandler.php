<?php

class fpOffensiveSpamControlHandler extends fpSpamControlHandler
{
	public function execute()
	{
		$spamConf = sfConfig::get('app_offensive_spam', array());
		$user = self::getCurrentUser();
		$offensiveCheck = $this->checkOffensiveCount($user->getId(), $spamConf['period'], $spamConf['limit']);

		if(!$offensiveCheck)
		{
			$this->addCredential('offensive-spamer');
		}
		else
		{
			$this->removeCredential('offensive-spamer');
		}
	}

	private function checkOffensiveCount($userId, $timeInterval, $limit)
	{

		$datearray = getdate();
        $date = mktime ('0','0', '0', $datearray["mon"], $datearray["mday"], $datearray["year"]);

		$AnswerOffensive = AnswerOffensivePeer::getCountByUser($userId, $date);

		$QuestionOffensive = QuestionOffensivePeer::getCountByUser($userId, $date);

		$AllUserOffensive = $AnswerOffensive + $QuestionOffensive;

		if($AllUserOffensive >= $limit)
		  return false;
		else
		  return true;
	}

}