<?php
function jq_bind($field_id, $event, $function_body)
{
    return "jQuery('{$field_id}').bind( '{$event}', function(event){ {$function_body} })";
}

function jq_observe_field($field_id, $options = array())
{
    return javascript_tag( jq_bind('#' . $field_id, 'blur', ' var value = event.currentTarget.value; ' . jq_remote_function($options)) );
}
