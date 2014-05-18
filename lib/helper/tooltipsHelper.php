<?php

function dispalay_tooltip($action, $objId, $someVar = '')
{
	$user = sfContext::getInstance()->getUser()->getCurrentUser();
    
    $message = fpTooltips::$action($objId, $user->getId(), $someVar);

    if($message)
        return getHtmlMessage($message);
}

function getHtmlMessage($message)
{
	$id = rand(10, 10000);
	return "


	<div id='".$id."' class='small-alert'>
                        <p>".$message."</p>
                        <p class='close'><a onclick=\"xclose('".$id."');\">X</a></p>
                    </div>";

}