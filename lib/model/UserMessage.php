<?php

class UserMessage extends BaseUserMessage implements fpINotification
{
	public function getNotification()
	{
		return $this->getMessage();
	}

	public static function greetNewUser($userId)
	{
        UserMessagePeer::createNewUserMessage($userId, self::getNewUserMessage());
	}

	private static function getNewUserMessage()
	{
        $message = '<h4>Thanks for joining Recording Questions!</h4>
                    <p>We want you to help make this the best place on the web to find answers to recording related questions.</p>
                    <p>This is your new profile page, you can use it to:</p>
                    <ul>
                        <li>Update your personal profile information so others in the community can learn a bit about you.</li>
                        <li>Find a list of recent questions and answers you have contributed to.</li>
                        <li>View your list of favorite questions. (You can add questions to this list by clicking the star near the title of each question)</li>
                    </ul>
                   ';
		return $message;
	}
}
