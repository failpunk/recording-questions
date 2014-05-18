<?php

class OpenidPeer extends BaseOpenidPeer
{
	/**
	 * @param string $openId
	 * @return Openid
	 */
	static public function retrieveByOpenId($openId)
	{

		return DbFinder::from('Openid')->
		where('openid', $openId)->
		findOne();

	}

}
