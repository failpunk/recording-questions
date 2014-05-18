<?php

class UserExperiencePeer extends BaseUserExperiencePeer
{
	public static function getByUserId($userId)
	{
		return DbFinder::from('UserExperience')
		->where('userId', $userId)
		->findOne();
	}

	public static function addNewUser($userId)
	{
		$userExp = new UserExperience();
		$userExp->setUserId($userId);
		$userExp->setExperience(0);
		$userExp->setCreatedAt(time());
		$userExp->save();
	}

	public static function nullingUserExp($userId)
	{
		$userExp = self::getByUserId($userId);
		$userExp->setExperience(0);
		$userExp->setCreatedAt(time());
		$userExp->save();
	}

	public static function addExp($userId, $exp)
	{
		$userExp = self::getByUserId($userId);
		$userExp->setExperience($userExp->getExperience() + $exp);
		$userExp->save();
	}

	public static function subExp($userId, $exp)
	{
		$userExp = self::getByUserId($userId);
		if( ( $userExp->getExperience() - $exp ) > 0 )
		{
			$userExp->setExperience($userExp->getExperience() - $exp);

		}
		else
		  $userExp->setExperience(0);

		$userExp->save();
	}
}
