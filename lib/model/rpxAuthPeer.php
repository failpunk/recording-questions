<?php

class rpxAuthPeer extends BaserpxAuthPeer
{
	static function retriveByIdentifier($identifier)
	{
        return DbFinder::from('rpxAuth')
                        ->where('identifier', $identifier)
                        ->findOne();
	}

	static function saveNewUser($identifier, $userId)
	{
		$user = new rpxAuth();
		$user->setUserId($userId);
		$user->setIdentifier($identifier);
		$user->save();
	}
}
