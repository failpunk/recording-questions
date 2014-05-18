<?php

class fpCaptchaValidator extends  sfCaptchaGDValidator
{
	public function execute (&$value, &$error)
	{

		$user = sfContext::getInstance()->getUser();

		if($user->hasCredential('question-spamer') || $user->hasCredential('comment-spamer') || !$user->hasCredential('user') || $user->hasCredential('answer-spamer'))
		{
		  return parent::execute($value, $error);
		}
		else
		  return true;


	}
}