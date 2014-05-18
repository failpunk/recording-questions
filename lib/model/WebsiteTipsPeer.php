<?php

class WebsiteTipsPeer extends BaseWebsiteTipsPeer
{
    static function getAllTips()
	{
        return DbFinder::from('WebsiteTips')
            ->where('Active', true)
            ->find();
    }
}
