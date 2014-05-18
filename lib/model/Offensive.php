<?php

class Offensive extends BaseOffensive
{
    // check if offensive vote limit has been reached
    public function save(PropelPDO $con = null)
	{
        $datearray = getdate();
        $timeInterval = mktime ('0','0', '0', $datearray["mon"], $datearray["mday"], $datearray["year"]);
        $offensive = sfConfig::get('app_offensive_spam', array());

        if(OffensivePeer::getVotesCast($this->getUserId(), $timeInterval) < $offensive['limit'])
        {
            parent::save($con);
            return true;
        }
        else
            return 'You have reached your limit of ' . $offensive['limit'] . ' offensive votes for the day';
    }

    // check if offensive vote limit has been reached
    public function flagPage($type, $key, $userId, $reason)
	{
        $this->setType($type);
        $this->setKey($key);
        $this->setUserId($userId);
        $this->setReason($reason);

        return $this->save();
    }
}
