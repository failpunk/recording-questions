<?php
/**
 * This helper provides some basic information for jQuery AJAX calls when used on a view
 */
echo '<script type="text/javascript">';

echo 'var routes = new Array();';
echo 'routes["base"]="http://'.sfContext::getInstance()->getRequest()->getHost().'";';

echo '</script>';
