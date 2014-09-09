<?php

namespace Commandr\Commands;

use Commandr\Core\Command;
use Commandr\Core\CommandHelp;

class HelpCommand extends Command {

	public $callsign = "help";
	
	public function prepare()
	{
		$this->setConfig(
			array("arguments" => array("command"))
		);

		$this->setSummary("Display help about a specified command");
		$this->setDescription("Display help about a specified command");
		$this->setUsage("[command]");
	}
	
	public function action()
	{
		$callsign = $this->getArgument("command");
		
		$namespace = $this->getApp()->findCommand($callsign, true);
		
		if ($this->getApp()->getCommand($callsign) !== false)
		{
			$command = $this->getApp()->getCommand($callsign);
			
			$help = new CommandHelp($command);
			
			$this->output->message($help->generateHelp($command));
		} else {
			$this->output->error("Cannot get help for " . $command . " command, because the command does not exists!");
		}
	}
}