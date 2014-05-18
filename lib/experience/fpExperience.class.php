<?php

class fpExperience
{
	private static function getExperience($userId)
	{
		return UserPeer::getExperienceScore($userId);
	}

	public static function checkForAction($userId, $action)
	{
		$expConf = sfConfig::get('app_experience_needed_'.$action);

		$experience = self::getExperience($userId);

		if($experience >= $expConf)
		return true;
		else
		return false;
	}

	public static function updatePositiveForUser($userId, $action)
	{
		// @TODO create update SQL
		$expConf = sfConfig::get('app_experience_add_'.$action);

        // don't add experience to guest user
        if($userId == 1){
            return false;
        }

		if(self::checkUserExp($userId) || $action == 'best_answer')
		{
            // don't add experience to guest user
            if($userId == 1){
                return false;
            }

			// @TODO move to event handler
			fpNotification::addUserExperienceMessage($userId, $expConf, array(
            'vote' => $expConf
			));

			$user = UserPeer::retrieveByPK($userId);

			$user->setExperienceScore($user->getExperienceScore() + $expConf);

			$user->save();

			UserExperiencePeer::addExp($userId, $expConf);
		}
	}

	public static function updateNegativeForUser($userId, $action)
	{
		// @TODO create update SQL

        // don't add experience to guest user
        if($userId == 1){
            return false;
        }

		$expConf = sfConfig::get('app_experience_sub_'.$action);

		$user = UserPeer::retrieveByPK($userId);
		if( ($user->getExperienceScore() - $expConf) >= 1)
		{
			$user->setExperienceScore($user->getExperienceScore() - $expConf);
			$user->save();

			UserExperiencePeer::subExp($userId, $expConf);
		}
	}

	private static function checkUserExp($userId)
	{
		$userExp = UserExperiencePeer::getByUserId($userId);

		$maxExpPerDay = sfConfig::get('app_experience_default_max_per_day');

		if(!$userExp)
		{
			UserExperiencePeer::addNewUser($userId);
			return true;
		}
		else
		{
			$createdAt = $userExp->getCreatedAt('m-d-Y');
			$timeArray = explode('-', $createdAt);
			$createdAtTimestamp = mktime('0', '0', '0', $timeArray[0], $timeArray[1], $timeArray[2]);

			$nowTime = date('m-d-Y');
			$nowTimeArray = explode('-', $nowTime);
			$nowTimeTimestamp = mktime('0', '0', '0', $nowTimeArray[0], $nowTimeArray[1], $nowTimeArray[2]);

			if( $createdAtTimestamp != $nowTimeTimestamp  )
			{
				UserExperiencePeer::nullingUserExp($userId);
				return true;
			}
			elseif( $createdAtTimestamp == $nowTimeTimestamp )
			{
				$exp       = $userExp->getExperience();
				if($exp < $maxExpPerDay )
				{
					return true;
				}
				else
				    return false;
			}
		}
	}
}