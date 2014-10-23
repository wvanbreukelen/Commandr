<?php

namespace Commandr\Core;

class Input
{

	protected $argv;

	public function __construct()
	{
		$this->argv = $_SERVER['argv'];
	}
	
	/**
	 * @param integer $id
	 */
	public function receiveArgument($id = null)
	{
		$arguments = $this->argv;
	
		if (is_null($id))
		{
			unset($arguments[0]);
			unset($arguments[1]);
			
			return $arguments;
		}
		
		$id = $id + 1;
		return $arguments[$id];
	}
	
	public function waitForInput()
	{
		return $this->getLineInput();
	}
	
	public function getLineInput()
	{
		$inputStream = 'php://stdin';
        if (!$this->hasStdinSupport()) {
            $inputStream = 'php://input';
        }
	
		$handle = fopen($inputStream, 'r');
		$line = fgets($handle);
		fclose($handle);
		
		return $line;
	}
	
	
	protected function hasStdinSupport()
    {
        return ('OS400' != php_uname('s'));
    }
	
		
}