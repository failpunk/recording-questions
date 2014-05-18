<?php

class fpEventHandler
{

	public function init($args)
	{
	}

	public function execute()
	{
	}

	/**
	* @return User
	*/
	public function getCurrentUser()
	{
		return myUser::getCurrentUser();
	}

	/**
	* @return sfUser
	*/
	public function getUser()
	{
		return sfContext::getInstance()->getUser();
	}

	public function addCredential($credential)
	{
		$this->getUser()->addCredential($credential);
	}

    public function hasCredential($credential)
    {
        $this->getUser()->hasCredential($credential);
    }

    public function removeCredential($credential)
    {
        $this->getUser()->removeCredential($credential);
    }

}
