<?php

class fpExperienceVoteControlHandler extends fpSpamControlHandler
{
	private $obj;
	private $act;

	public function init($args)
	{
		$this->obj    = $args[0];
		$this->act    = $args[1];
	}

	public function execute()
	{
		$userId = $this->obj->getUserId();

		if($this->act == "add")
		{
            fpExperience::updatePositiveForUser($userId, "vote");
		}
		if($this->act =="sub")
		{
            fpExperience::updateNegativeForUser($userId, "vote");
            fpExperience::updateNegativeForUser($this->getCurrentUser()->getId(), "you_downvote");
		}

		if($this->act == "subReverse")
		{
			fpExperience::updatePositiveForUser($userId, "remove_downvote");
			fpExperience::updatePositiveForUser($this->getCurrentUser()->getId(), "remove_you_downvote");
		}
	    if($this->act == "addReverse")
        {
            fpExperience::updateNegativeForUser($userId, "remove_upvote");
        }
	}

}