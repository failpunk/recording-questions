<?php
class fpTooltips
{

	public static function getTooltip($key)
	{
		return TooltipsPeer::getByKey($key);
	}

	public static function QuestionVote($questionId, $userId, $vote = '')
	{
		$question = QuestionPeer::retrieveByPK($questionId);

		$user = sfContext::getInstance()->getUser();

		if(!$user->hasCredential('user'))
		return self::getTooltip('vote_unregistered_user');

		if($userId == $question->getUserId())
		{
			return self::getTooltip('vote_self_question');
		}

		if($vote == 'add')
		{
			if($user->getCurrentUser()->getExperienceScore() < sfConfig::get('app_experience_needed_upvote'))
			{
				return self::getTooltip('vote_needed_for_upvote');
			}
		}
        
		if($vote == 'sub')
		{
			if($user->getCurrentUser()->getExperienceScore() < sfConfig::get('app_experience_needed_downvote'))
			{
				return self::getTooltip('vote_needed_for_downvote');
			}
		}

		if($vote == 'old')
		{
            return self::getTooltip('vote_is_too_old');
		}

        if($vote == 'too_many')
		{
            return self::getTooltip('too_many_votes_today');
        }
		return false;
	}

	public static function AnswerVote($answerId, $userId, $vote = '')
	{
		$answer = AnswerPeer::retrieveByPK($answerId);

		$user = sfContext::getInstance()->getUser();

		if(!sfContext::getInstance()->getUser()->hasCredential('user'))
		return self::getTooltip('vote_unregistered_user');


		if($userId == $answer->getUserId())
		{
			return self::getTooltip('vote_self_answer');
		}

		if($vote == 'add')
		{
			if($user->getCurrentUser()->getExperienceScore() < sfConfig::get('app_experience_needed_upvote'))
			{
				return self::getTooltip('vote_needed_for_upvote');
			}
		}

		if($vote == 'sub')
		{
			if($user->getCurrentUser()->getExperienceScore() < sfConfig::get('app_experience_needed_downvote'))
			{
				return self::getTooltip('vote_needed_for_downvote');
			}
		}
        
        if($vote == 'old')
		{
            return self::getTooltip('vote_is_too_old');
		}

        if($vote == 'too_many')
		{
            return self::getTooltip('too_many_votes_today');
        }
		return false;
	}

	public static function QuestionComment($questionId, $userId)
	{
		$user = UserPeer::getById($userId);

		if($user->getIsGuest() || !sfContext::getInstance()->getUser()->isAuthenticated())
		{
			return self::getTooltip('add_comment_by_unregistered');
		}

		if($user->getExperienceScore() < sfConfig::get('app_experience_needed_add_comment'))
		{
			return self::getTooltip('add_comment');
		}
	}

    public static function AnswerComment($answerId, $userId)
    {
        $user = UserPeer::getById($userId);

        if($user->getIsGuest() || !sfContext::getInstance()->getUser()->isAuthenticated())
        {
            return self::getTooltip('add_comment_by_unregistered');
        }

        if($user->getExperienceScore() < sfConfig::get('app_experience_needed_add_comment'))
        {
            return self::getTooltip('add_comment');
        }
    }

	public static function QuestionOffensive($questionId, $userId)
	{
        $user = UserPeer::getById($userId);
		if($user->getExperienceScore() < sfConfig::get('app_experience_needed_offensive'))
	    {
	        return self::getTooltip('offensive');
	    }
	}

	public static function FavoritesAdd()
	{
        $user = sfContext::getInstance()->getUser();
        
		if(!$user->hasCredential('user')) {
            return self::getTooltip('favorite_unregistered_user');
        }
        
//        $question = QuestionPeer::retrieveByPK($questionId);
//
//		$user = sfContext::getInstance()->getUser();
//
//		if(!$user->hasCredential('user'))
//		return self::getTooltip('vote_unregistered_user');
//
//		if($userId == $question->getUserId())
//		{
//			return self::getTooltip('vote_self_question');
//		}
//
//		if($vote == 'add')
//		{
//			if($user->getCurrentUser()->getExperienceScore() < sfConfig::get('app_experience_needed_upvote'))
//			{
//				return self::getTooltip('vote_needed_for_upvote');
//			}
//		}
//
//		if($vote == 'sub')
//		{
//			if($user->getCurrentUser()->getExperienceScore() < sfConfig::get('app_experience_needed_downvote'))
//			{
//				return self::getTooltip('vote_needed_for_downvote');
//			}
//		}
//
//		if($vote == 'old')
//		{
//            return self::getTooltip('vote_is_too_old');
//		}
		return false;
	}
}