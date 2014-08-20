<?php

$config = array(
	'commands' => array(
		'Commandr\Commands\TestCommand',
		'Commandr\Commands\HelloCommand',
		'Commandr\Commands\HelpCommand',
	),
	
	'errors' => array(
		'commandNotFound' => "This command cannot been found.",
	),
);

function dumpConfig()
{
	return $config;
}

return $config;