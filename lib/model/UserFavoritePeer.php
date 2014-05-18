<?php

class UserFavoritePeer extends BaseUserFavoritePeer
{
	static function getFavoriteQuestionByUserIdAndQuestionId($userId, $questionId)
	{
		return DbFinder::from('UserFavorite')
		->where('userId', $userId)
		->where('questionId', $questionId)
		->findOne();
	}

    static function getFavoriteCountByQuestionId($questionId)
	{
		return DbFinder::from('UserFavorite')
            ->where('questionId', $questionId)
            ->count();
	}

	public static function saveNewQuestion($userId, $questionId)
	{
		$questionFavorite = new UserFavorite();
        $questionFavorite->setUserId($userId);
        $questionFavorite->setQuestionId($questionId);
        $questionFavorite->save();
	}

}
