<?php

class InformationTemplates extends BaseInformationTemplates implements fpINotification
{
	public function getNotification()
	{
		// @TODO compilie for curren user
		return $this->getValue();
	}
}
