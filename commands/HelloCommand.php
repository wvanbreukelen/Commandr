<?php

namespace Commandr\Commands;

use Commandr\Core\Command;

class HelloCommand extends Command
{

	public $callsign = "hello";

	public function prepare()
	{
		$this->setConfig(
			array(
				'arguments' => array("debug")
			)
		);
	}
	
	public function action()
	{
		$this->output->writeln("\n\n");
		$this->output->info("Welkom in het programma, om te beginnen ga ik je nu een paar vragen stellen.\n");
		
		$firstName = $this->ask("Wat is je voornaam?");
		$lastName = $this->ask("Wat is je achternaam?");
		$age = $this->ask("Wat is je leeftijd?");
		
		$this->output->writeln("Bedankt voor de informatie, dit is het resultaat");
		
		$this->output->success("Jij bent " . $firstName . " " . $lastName . " en je bent " . $age . " jaar oud...");
		
		
	}
}