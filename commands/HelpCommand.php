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
	}
	
	public function action()
	{
		$command = $this->getArgument("command");
		
		// Temp. solution, developer has to create their owwn namespaces and not been bind to the testing namespace
		
		$namespace = "Commandr\Commands\\" . ucfirst($command) . "Command";
		
		if ($this->getApp()->getCommand($command) !== false)
		{
			$command = $this->getApp()->getCommand($command);
			
			$help = new CommandHelp($command);
			
			$this->output->message($help->generateHelp($command));
		} else {
			$this->output->error("Cannot get help for " . $command . " command, because the command does not exists!");
		}
	}
}