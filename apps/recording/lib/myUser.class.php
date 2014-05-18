<?php

class myUser extends sfBasicSecurityUser
{
	static $user = null;
	static $userOpenId = null;
	static $userId = null;

	static public function getUserId()
	{
		return self::getInstance()->getAttribute('userId');
	}

	static public function setUserId($userId)
	{
		self::getInstance()->setAttribute("userId", $userId);
	}

	static public function getOpenId()
	{
		return self::getInstance()->getAttribute('userOpenId');
	}

	static public function setOpenId($openId)
	{
		self::getInstance()->setAttribute("userOpenId", $openId);
	}

    /**
    * @return User
    */
	static function getGuestUser()
	{
		return UserPeer::retrieveGuest();
	}

	/**
	* @return User
	*/
	static public function getCurrentUser()
	{
		if(!self::$user)
		{
			$user_id = self::getUserId();

			if(!$user_id)
			{
				self::$user = self::getGuestUser();
			}
			else
			{
				self::$user = UserPeer::retrieveByPK($user_id);

			}

		}

		if(!self::$user)
		{
			throw new Exception('User not found');
		}

		return self::$user;
	}

	static function getUserOpenIdInfo()
	{
		if(!self::$userOpenId)
		{
			self::$userOpenId = self::getOpenId();
		}
		return self::$userOpenId;
	}

	/**
	 * Enter description here...
	 *
	 * @return myUser
	 */
	static function getInstance()
	{
		return sfContext::getInstance()->getUser();
	}

	static function getUserById($user_id)
	{
		// @TODO getUserById
		if(!$user_id || $user_id == 1)
		return self::getGuestUser();
		else
		return UserPeer::retrieveByPK($user_id);
	}

	static function getUserRank()
	{
		return UserPeer::getRank(self::getUserId());
	}
}
