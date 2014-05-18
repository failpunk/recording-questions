<?php

function notification_display()
{
    if($independant_message = check_for_independant_msg())
    {
        return $independant_message;
    }

    $messages = fpNotification::getMessages(1);

	$results = array();

	foreach ($messages as $message)
	{
		if($message)
		{
			$results[] = notification_type($message);
		}
	}

	return join('', $results);
}


function notification_type($msg, $type = 'two')
{
    return '<div id="alertTop" class="popup '.$type.'">' .$msg. '<p class="close"><a href="#">X</a></p></div><!-- .popup -->';
}

/**
 * There may be times when we want to send a message to a guest user (if they try to ask a question without logging in),
 * but we cannot use the database notification system until they have user id, so a message can be displayed by setting the
 * display_independant_message flash and passing a message in independant_message_text.
 */
function check_for_independant_msg()
{
    $user = sfContext::getInstance()->getUser();
    
    if($user->hasFlash('display_independant_message'))
    {
        if($user->hasFlash('display_independant_text'))
        {
            $type = ($user->hasFlash('independant_message_type')) ? $user->getFlash('independant_message_type') : 'two';
            return notification_type($user->getFlash('display_independant_text'), $type);
        }
    }
}
