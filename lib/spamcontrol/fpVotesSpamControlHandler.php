<?php

class fpVotesSpamControlHandler extends fpSpamControlHandler
{
	public function execute()
	{
		$spamConf = sfConfig::get('app_votes_spam', array());
		$user = self::getCurrentUser();
		$VotesCheck = $this->checkVotesCount($user->getId(), $spamConf['period'], $spamConf['limit']);

		if(!$VotesCheck)
		{
			$this->addCredential('vote-spamer');
		}
		else
		{
			$this->removeCredential('vote-spamer');
		}

	}

	private function checkVotesCount($userId, $timeInterval, $limit)
	{

		$AnswerVotes = AnswerVotePeer::getCountByUser($userId, $timeInterval);

		$QuestionVotes = QuestionVotePeer::getCountByUser($userId, $timeInterval);

		$AllUserVotes = $AnswerVotes + $QuestionVotes;
		if($AllUserVotes > $limit)
		  return false;
		else
		  return true;
	}

}