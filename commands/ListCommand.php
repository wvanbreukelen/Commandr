<?php

namespace Commandr\Commands;

use Commandr\Core\Command;
use Commandr\Core\CommandHelp;

class ListCommand extends Command
{
	public $callsign = 'list';

	public function prepare()
	{
		$this->setConfig(array("arguments" => array()));

		$this->setSummary("Lists all the registered command");
		$this->setDescription("This command lists all the application binded command into the application");
		$this->setUsage("");
	}

	public function action()
	{
		print_r($this->getApp()->listCommands());

		echo 'Done!';
	}
}