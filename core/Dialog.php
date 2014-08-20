<?php

namespace Commandr\Core;

class Dialog
{

	protected $input;

	public function ask($output, $question)
	{
		$output->write($question);
		return $this->getInput()->waitForInput();
	}
	
	public function confirm($output, $question = null, $default = null)
	{
		if (is_null($question))
		{
			$question = "Are you sure you want to perform this action?";
		}
		
		if (!is_null($default))
		{
			if ($default == true)
			{
				$question .= " (yes)";
			} else if ($default == false) {
				$question .= " (no)";
			}
		}
		
		$output->write($question);
		
		$answer = $this->getInput()->waitForInput();
		
		if (is_bool($default))
		{
			return $default;
		}
		
		if ($answer = 'y' || $answer = 'yes') 
		{
			return true;
		}
		
		return false;
	}
	
	public function configure($input)
	{
		$this->input = $input;
	}
	
	public function setInput($input)
	{
		$this->input = $input;
	}
	
	public function getInput()
	{
		return $this->input;
	}
}