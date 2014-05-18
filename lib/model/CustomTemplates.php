<?php

class CustomTemplates extends BaseCustomTemplates implements fpINotification
{
	public function getNotification()
	{
		return $this->getValue();
	}
}
