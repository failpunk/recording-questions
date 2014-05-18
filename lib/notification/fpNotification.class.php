<?php

class fpNotification
{

	/**
	 * @param string $name
	 * @return CustomTemplates
	 */
	static public function getCustomTemplate($name)
	{

		// @TODO move to peer

		$template = DbFinder::from('CustomTemplates')
		->where('name', $name)
		->findOne();

		if($template)
		{
			return $template->getNotification();
		}

		return '';
	}

	static public function compileCustomTemplate($templateName, $data = array())
	{
		return self::compile(self::getCustomTemplate($templateName), $data);
	}

	static public function compile($text, $data = array())
	{
		$source = array();

		foreach ($data as $key => $value)
		{
			$source['%%' . $key . '%%'] = $value;
		}
		return strtr($text, $source);
	}

	/**
	 * @return sfBasicSecurityUser
	 */
	static public function getUser()
	{
		return sfContext::getInstance()->getUser();
	}

	/**
	 * @return User
	 */
	static public function getCurrentUser()
	{
		$user = self::getUser();

		if ($user->isAuthenticated() && $user->hasCredential('user'))
		{
			return myUser::getCurrentUser();
		}
	}

	static public function resolveInformMessages($template)
	{
		$check = new CheckInformation();
		$check->setUserId(self::getCurrentUser()->getId());
		$check->setInformationId($template->getId());
		$check->save();

	}

	static public function getInformMessages()
	{
		$user = self::getCurrentUser();

		$results = array();


		if($user)
		{
			$con = Propel::getConnection();

			$sql = "
			SELECT
			    it.id, it.value, it.exp_date
			FROM
			    information_templates as it
			LEFT JOIN
			    check_information as ci
			ON
			    ci.information_id = it.id
			AND
			    ci.user_id = ?
			WHERE
                it.exp_date > ?
            AND
			    ci.user_id IS NULL
			AND
			    ci.information_id IS NULL";

			$stmt = $con->Prepare($sql);

			$stmt->bindValue(1, $user->getId());
			$stmt->bindValue(2, date('Y-m-d H:i:s'));

			$stmt->execute();

			while($row = $stmt->fetch()) {

				$template = new InformationTemplates();
				$template->setId($row['id']);
				$template->setValue($row['value']);
				$template->setExpDate($row['exp_date']);

				self::resolveInformMessages($template);

				$results[] = $template->getNotification();
			}


		}

		return $results;

	}

	static public function modelsToArray($models)
	{
		$result = array();

		foreach ($models as $key => $model)
		{
			$result = array_merge($result, self::modelToArray($model, $key . '.'));
		}

		return $result;
	}

	static public function modelToArray($model, $prefix = '')
	{
		$result = array();

		foreach ($model->toArray() as $key => $value)
		{
			$result[$prefix . $key] = $value;
		}

		return $result;

	}

	static public function addUserExperienceMessage($userId, $expAfter, $data = array())
	{
		$user = UserPeer::retrieveByPK($userId);

		$data = array_merge($data, self::modelToArray($user, 'user.'));

		//        ExperienceTemplates::getExperience()

		$expBefore = $user->getExperienceScore();

		$templateBefor = DbFinder::from('ExperienceTemplates')
		->where('Experience', '<=', $expBefore)
		->orderBy('Experience', 'DESC')
		->findOne();

		$templatesAfter = DbFinder::from('ExperienceTemplates')
		->where('Experience', '>', $expBefore)
		->where('Experience', '<=', $expBefore + $expAfter)
		->orderBy('Experience', 'DESC')
		->find();

		foreach ($templatesAfter as $templateAfter)
		{
			if(
			($templateAfter && $templateBefor && $templateBefor->getId() != $templateAfter->getId())
			||
			($templateAfter && !$templateBefor)
			)
			{
				self::addUserMessage($userId, $templateAfter->getValue(), $data);
			}
		}

	}

	static public function addUserCustomMessage($userId, $customTemplate, $data = array())
	{
		// Don't send messages to yourself
        $currentUserId = (self::getCurrentUser()) ? self::getCurrentUser()->getId() : 1;
        
        if($currentUserId == $userId) {
            return false;
        }
        
        self::addUserMessage($userId, self::getCustomTemplate($customTemplate), $data);
	}

	static public function addUserMessage($userId, $message, $data = array())
	{
		$msg = new UserMessage();
		$msg->setUserId($userId);
		$msg->setMessage(self::compile($message, $data));
		$msg->save();
	}

	static public function getUserMessages()
	{
		$user = self::getCurrentUser();

		$messages = DbFinder::from('UserMessage')
		->where('UserId', $user->getId())
		->find();

		$result = array();

		foreach ($messages as $message)
		{
			$result[] = $message->getNotification();
			$message->delete();
		}

		return $result;

	}

	static public function isFirstVisit()
	{
		$isFirst = sfContext::getInstance()->getRequest()->getCookie('guest') ? false : true;

		if($isFirst)
		{
			sfContext::getInstance()->getResponse()->setCookie('guest', 1);
		}

		return $isFirst;
	}

   /**
    * Gets all the system and individual messages for the current user
    * @param int $maxMessages   The number of messages to return (per type).  Returns all messages by default.
    * @return array             An array of messages
    */
	static public function getMessages($maxMessages = null)
	{

		$result = array();

		if(self::getCurrentUser())
		{
			$informMessage = self::getInformMessages();
			$userMessage = self::getUserMessages();

            // only return specified number of messages
            $arrInform = array();
            $arrUser = array();
            
            if(!is_null($maxMessages))
            {
                // informational messages
                for ($i = 0 ; $i < $maxMessages ; $i++)
                {
                    if(!isset($informMessage[$i])){
                        break;
                    }
                    $arrInform[] = $informMessage[$i];
                }

                // user messages
                for ($i = 0 ; $i < $maxMessages ; $i++)
                {
                    if(!isset($userMessage[$i])){
                        break;
                    }
                    $arrUser[] = $userMessage[$i];
                }
            } else {
                $arrInform = $informMessage;
                $arrUser = $userMessage;
            }
            
			// Only return the newest of each message
            $result = array_merge($arrInform, $arrUser);
		}
		else
		{
			// guest
			$result[] = self::getGuestMessage();
		}

		return $result;
	}

	static public function getGuestMessage()
	{
		if(self::isFirstVisit())
		{
			return self::getCustomTemplate('guest_message');
		}
	}


}