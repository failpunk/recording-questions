<?php

class userComponents extends sfComponents
{
	public function executeRecentUsers()
	{
        $this->users = UserPeer::getMostRecentUsers(sfConfig::get('app_recent_users_to_display'));
	}
}
?>