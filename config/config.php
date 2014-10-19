<?php

$config = array(
	'commands' => array(
		'Commandr\Commands\TestCommand'
	),
	
	'errors' => array(
		'commandNotFound' => "This command cannot been found.",
		'notEnoughArguments' => "Command %s does not matches the amount of required arguments!",
	),
);

function dumpConfig()
{
	return $config;
}

return $config;