<?php

class UserPeer extends BaseUserPeer
{
	/**
	 * @param string $openId
	 * @return User
	 */
	static public function cerateUserByOpenId($openId)
	{
		$user = new User();
		$user->setCreatedAt(time());
		$user->save();

		$userOpenId = new Openid();
		$userOpenId->setOpenid($openId);
		$userOpenId->setUserId($user->getId());
		$userOpenId->setCreatedAt(time());
		$userOpenId->save();

		return $user;

	}

	/**
	 * @return User
	 */
	static public function retrieveGuest()
	{
		return DbFinder::from('User')
		->where('isGuest', true)
		->findOne();
	}


    static public function IncrementTodaysVotes($userId)
    {
        $user = self::retrieveByPK($userId);
        $user->setTodayVotes($user->getTodayVotes()+1);
        $user->save();
    }

    static public function DecrementTodaysVotes($userId)
    {
        $user = self::retrieveByPK($userId);
        $user->setTodayVotes($user->getTodayVotes()-1);
        $user->save();
    }

    static public function getExperienceScore($userId)
    {
    	$result = DbFinder::from('User')
    	                   ->where('Id' , $userId)
    	                   ->findOne();
        return $result->getExperienceScore();
    }

    static public function getUserLike($likeString, $maxResultsPerPage, $filter)
    {
        $direction = "DESC";

        if($filter == 'newest') {
            $orderBy = 'CreatedAt';
        }
        elseif($filter == 'oldest') {
            $orderBy = 'CreatedAt';
            $direction = "ASC";
        }
        else {
            $orderBy = 'ExperienceScore';
        }

        return DbFinder::from("User")
                         ->where("DisplayName", "like", "$likeString%")
                         ->where('Id', '<>', 1)   // exclude guest user
                         ->select(array('Id'))
    	                 ->orderBy($orderBy, $direction)
                         ->limit($maxResultsPerPage)
    	                 ->find();
    }

	static public function getMostRecentUsers($maxResults)
    {
        return DbFinder::from('User')
                        ->where('Id', '<>', 1)
                        ->orderBy('CreatedAt', 'desc')
                        ->limit($maxResults)
                        ->find();
    }

    static public function getRank($userId)
    {
    	$results = DbFinder::from("User")
    	                 ->orderBy("ExperienceScore", 'DESC')
    	                 ->find();
        foreach ($results as $key => $user)
        {
            if($user->getId() == $userId)
            {
                return $key+1;
            }
        }

        return 0;
    }

    static public function getById($userId)
    {
    	return self::retrieveByPK($userId);
    }

    static public function getInactiveUsers($inactiveDate = false)
    {
        if(!$inactiveDate) {
            $inactiveDate = date('Y-m-d h:i:s', time() - (86400 * 7));
        }

    	$users = DbFinder::from("User")
                        ->join('rpxAuth')
                        ->where('rpxAuth.LastLogin', '<=', $inactiveDate)
                        ->find();

        return $users;
    }

    // reset all users vote count for the day
    static public function resetDailyVotingLimit()
    {
        DbFinder::from('User')->
          set(array('todayVotes' => 0));
    }

    static public function getByExperience($currentPage, $maxResultsPerPage)
    {
        return DbFinder::from("User")
    	                 ->orderBy("ExperienceScore", 'DESC')
                         ->paginate($currentPage, $maxResultsPerPage);
    }

    static public function getStats(array $userids)
    {
        if($userids)
        {
            $con = Propel::getConnection();
            $results = array();
            
            foreach($userids as $userid)
            {
                $user_id = $userid['Id'];
                
                $sql = "SELECT u.id, u.experience_score, u.email, u.display_name,
                        (select count(*) from user_award where user_id = $user_id) as award_count,
                        (select count(*) from question where user_id = $user_id and visible = 1) as question_count,
                        (select count(*) from answer where user_id = $user_id and visible = 1) as answer_count,
                        (select count(*) from question_vote where user_id = $user_id) as question_vote_count,
                        (select count(*) from answer_vote where user_id = $user_id) as answer_vote_count
                        FROM user u
                        WHERE u.id = $user_id;";

                
                $stmt = $con->Prepare($sql);
                $stmt->execute();

                while($row = $stmt->fetch())
                {
                  $results[] = $row;
                }
            }
            return $results;
        }
        
        return false;
    }

    static public function getCountBetweenDates($from, $to)
    {
        if(!$from) {
            $from = '2009-01-01 00:00:00';
        }

        if(!$from) {
            $to = '2099-01-01 00:00:00';
        }
        
        return DbFinder::from('User')
					        ->filterBy('CreatedAt', array('from' => $from, 'to' => $to))
                            ->count();
    }
}
