<?php

class OffensivePeer extends BaseOffensivePeer
{
    public static function getVotesCast($userId, $timeInterval)
	{
		return DbFinder::from('Offensive')
		->where('userId', $userId)
        ->where('createdAt', '>', $timeInterval)
		->count();
	}

    public static function findPreviousVote($type, $key, $userId)
	{
		return DbFinder::from('Offensive')
		->where('type', $type)
		->where('key', $key)
		->where('userId', $userId)
		->count();
	}
}
