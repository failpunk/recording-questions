<?php

class UserMessagePeer extends BaseUserMessagePeer
{
    public static function createNewUserMessage($userId, $message)
	{
		$userMessage = new UserMessage();
        $userMessage->setUserId($userId);
        $userMessage->setMessage($message);
        $userMessage->save();
	}

    public static function getMessagesForUser($userId)
	{
		$messages = DbFinder::from('UserMessage')
            ->where('UserId', $userId)
            ->find();

        return $messages;
	}
}
