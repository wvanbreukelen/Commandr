<?php

$config = array(
	'commands' => array(
		'Commandr\Commands\TestCommand'
	),
	
	'errors' => array(
		'commandNotFound' => "This command cannot been found.",
		'notEnoughArguments' => "Command %s does not matches the amount of required arguments!",
	),

	'messages' => array(
		'listCommands' => "%s - %s",
	),
);

function dumpConfig()
{
	global $config;

	return $config;
}

return $config;