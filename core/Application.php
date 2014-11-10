<?php

namespace Commandr\Core;

use Commandr\Core\Command;
use Commandr\Core\Config;
use Commandr\Core\Output;
use Commandr\Core\Dialog;

class Application
{

	protected $name;
	
	protected $version;
	
	protected $commands = array();
	
	protected $commandsConfig = array();
	
	protected $match;
	
	protected $config;
	
	protected $input, $output, $dialog;

	public function __construct(Input $input, Output $output, Dialog $dialog, $name, $version)
	{
		$this->input = $input;
		$this->output = $output; 
		$this->dialog = $dialog;
		$this->name = $name;
		$this->version = $version;
	}

	public function registerCommand($command, $callsign = null)
	{
		if ($command instanceof Command)
		{
			$this->commands[$command->callsign] = $this->addCommandHelpers($command);
			
			$this->commands[$command->callsign]->prepare();
			
			if (count($this->commands[$command->callsign]->getConfig() > 0))
			{
				$this->commandsConfig[$command->callsign] = $this->commands[$command->callsign]->getConfig();
			}
		} else {
			$this->commands[$callsign] = $command;
		}
	}
	
	public function addCommands(array $namespaces = array())
	{
		foreach ($namespaces as $namespace)
		{
			if (class_exists($namespace))
			{
				$command = new $namespace($this->input, $this->output);
				
				$this->registerCommand($command, $command->callsign);
			}
		}
	}
	
	public function listCommand($command)
	{
		if ($command instanceof Command)
		{
			$this->output->write(sprintf($this->getConfig()->get('messages', 'listCommand'), $command->callsign, $command->description));
		} else if (is_string($command) && isset($this->commands[$command])) {
		
		}
	}

	public function findCommand($callsign, $namespace = false)
	{
		if (isset($this->commands[$callsign]))
		{
			if ($namespace)
			{
				return get_class($this->commands[$callsign]);
			} else {
				return $this->commands[$callsign];
			}
		}

		return null;
	}
	
	public function listCommands()
	{
		$list = null;
	
		foreach ($this->commands as $command)
		{

			$list .= sprintf($this->getConfig()->get('messages', 'listCommands') . "\n", $command->callsign, $command->description);
			//echo $list;
		}
		
		if (!is_null($list)) $this->output->write($list);
	}
	
	public function isCommand($callsign)
	{
		return isset($this->commands[$callsign]);
	}
	
	public function run(Output $output, $argv = null)
	{
		$this->getConfig()->setDefaultCategory('errors');

		if (is_null($argv)) $argv = $this->getArgv();
		
		$command = $this->match;
		
		if (is_null($command))
		{
			$this->output->writeColor($this->getConfig()->get(null, 'commandNotFound'), 'red');
			
			return;
		}
		
		return $this->runCommand($command);
	}

	public function runCommand(Command $command)
	{
		if (!$this->checkRequiredArguments($command))
		{
			$this->output->error(sprintf($this->getConfig()->get('errors', 'notEnoughArguments'), $command->callsign));
			
			return;
		}
		
		// Share the current app instance with the command, so the command can handle specified actions
		
		$command->setApp($this);
		
		return $command->action();
	}
	
	public function setConfig(Config $config)
	{
		$this->config = $config;
	}
	
	public function getConfig()
	{
		return $this->config;
	}
	
	public function getCommands()
	{
		return $this->commands;
	}
	
	public function getCommand($callsign)
	{
		return (isset($this->commands[$callsign])) ? $this->commands[$callsign] : false;
	}
	
	public function getArgv()
	{
		return $_SERVER['argv'];
	}
	
	public function match()
	{
		$argv = $this->getArgv();
		
		if (isset($argv[1]))
		{
			$callsign = $argv[1];
		
			$this->match = (isset($this->commands[$callsign])) ? $this->commands[$callsign] : null;
		} else {
			$this->match = null;
		}

		return $this;
	}
	
	protected function addCommandHelpers(Command $command)
	{
		$command->input = $this->input;
		$command->output = $this->output;
		$command->setDialog($this->dialog);
		return $command;
	}
	
	protected function checkRequiredArguments(Command $command)
	{
		if (isset($this->commandsConfig[$command->callsign]))
		{
			$config = $this->commandsConfig[$command->callsign];
			$penalty = 0;
			
			foreach ($config['arguments'] as $value)
			{
				if ($value[0] = "*")
				{
					$penalty = $penalty + 1;
				}
			}
			
			if (isset($config['arguments']))
			{
				if (count($config['arguments']) != max(count($this->getArgv()) - 2, 0))
				{
					return false;
				}
			}
		}
		
		return true;
	}
	
	protected function descriptionCommand($command)
	{
		if (is_object($command) && $command instanceof Command)
		{
			return $command->description;
		}
	}
	
	protected function helpCommand($command)
	{
		if (is_object($command) && $command instanceof Command)
		{
			return $command->help;
		}
	}
}