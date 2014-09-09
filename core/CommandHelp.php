<?php

namespace Commandr\Core;

class CommandHelp
{

	protected $callsign, $summary, $usage, $description, $optionsDescription;

	public function __construct($command)
	{
		if (is_object($command))
		{	
			$this->callsign = $command->callsign;
			$this->summary = $command->getSummary();
			$this->usage = $command->getUsage();
			$this->description = $command->getDescription();
			$this->optionsDescription = $command->getOptionsDescription();
		}
	
	}
	
	public function generateHelp()
	{
		$message = "SUMMARY\n   " . $this->summary . "\n\n";
		$message .= "USAGE\n   " . $this->callsign . " " . $this->usage . "\n\n";
		$message .= "DESCRIPTION\n    " . $this->description . "\n\n";
		
		return $message;
	}
}