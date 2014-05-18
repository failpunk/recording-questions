<?php

class TooltipsPeer extends BaseTooltipsPeer
{
	public static function getByKey($key)
	{
		$result = DbFinder::from('Tooltips')
		                  ->where('key', $key)
		                  ->findOne();
        
        if($result) {
            return $result->getValue();
        }
	}
}
