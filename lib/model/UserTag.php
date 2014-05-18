<?php

class UserTag extends BaseUserTag
{
	static function getUserTagByTagId($tagId, $userId)
	{
        $result = DbFinder::from("UserTag")
                       ->where("tagId", $tagId)
                       ->where("userId", $userId)
                       ->findOne();
	    return $result;
	}

	static function getUserTagByUserId($userId)
	{
        $userTag = DbFinder::from('userTag')
                   ->with('Tag')
                   ->leftJoin('Tag')
                   ->where('userId', $userId)
                   ->find();
        return $userTag;
	}

	static function getPositiveUserTagByUserId($userId)
	{
		$userTag = DbFinder::from('userTag')
                   ->with('Tag')
                   ->leftJoin('Tag')
                   ->where('userId', $userId)
                   ->where('Positive', true)
                   ->find();
        return $userTag;
	}

    static function getNegativeUserTagByUserId($userId)
    {
        $userTag = DbFinder::from('userTag')
                   ->with('Tag')
                   ->leftJoin('Tag')
                   ->where('userId', $userId)
                   ->where('Negative', true)
                   ->find();
        return $userTag;
    }
}
