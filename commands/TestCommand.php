<?php

namespace Commandr\Commands;

use Commandr\Core\Command;

class TestCommand extends Command
{
 	public $callsign = 'test';

	public function prepare()
	{
		$this->setConfig(
			array(
				'arguments' => array()
			)
		);
		
		
		$this->setDescription("Simple to use test command, for testablity for the application");
		$this->setSummary("Simple to use test command");

	}
	
	public function action()
	{
		$this->output->writeln("This is a formatted message");
	}
}