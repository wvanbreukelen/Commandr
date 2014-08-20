<?php

namespace Commandr\Core;

class Command
{
	public $callsign;
	
	public $summary = "Has not been set!";
	
	public $description = "Has not been set!";
	
	public $usage;
	
	public $optionsDescription = "Has not been set!";
	
	public $config = array();
	
	public $input, $output, $dialog;
	
	public $app;
	
	public function action() {}
	
	public function ask($question)
	{
		return $this->getDialog()->ask($this->output, $question);
	}
	
	public function confirm($question = null, $default = null)
	{
		return $this->getDialog()->confirm($this->output, $question, $default);
	}
	
	public function getArgument($name = null)
	{
		if (is_null($name))
		{
			return $this->input->receiveArgument();
		}
		
		$position = $this->resolveArgumentPosition($name);
		
		return $this->input->receiveArgument($position);
		
	}
	
	public function setSummary($summary)
	{
		$this->summary = $summary;
	}
	
	public function getSummary()
	{
		return $this->summary;
	}
	
	public function setDescription($description)
	{
		$this->description = $description;
	}
	
	public function getDescription()
	{
		return $this->description;
	}
	
	public function setUsage($usage)
	{
		$this->usage = $usage;
	}
	
	public function getUsage()
	{
		return $this->usage;
	}
	
	public function setConfig(array $config = array())
	{
		$this->config = $config;
	}
	
	public function getConfig()
	{
		return $this->config;
	}
	
	public function setOptionsDescription(array $optionsDesc = array())
	{
		$this->optionsDescription = $optionsDesc;
	}
	
	public function getOptionsDescription()
	{
		return $this->optionsDescription;
	}
	
	public function setDialog($dialog)
	{
		$this->dialog = $dialog;
		$this->dialog->configure($this->input, $this->output);
	}	
	public function getDialog()
	{
		return $this->dialog;
	}
	
	public function setApp($app)
	{
		$this->app = $app;
	}
	
	public function getApp()
	{
		return $this->app;
	}
	
	protected function resolveArgumentPosition($name)
	{
		if (isset($this->getConfig()['arguments']) && in_array($name, $this->getConfig()['arguments']))
		{
			$i = 1;
			$arguments = $this->getConfig()['arguments'];
			
			
			foreach ($arguments as $rowName)
			{
				if ($rowName = $name)
				{
					return $i;
				}
				
				$i = $i + 1;
			}
		}
		
		return null;
	}
}