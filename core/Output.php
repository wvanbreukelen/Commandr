<?php

namespace Commandr\Core;

use Commandr\Core\OutputStyle;
use Commandr\Core\OutputFormatter;

class Output
{

	public function format($string)
	{
		$formatter = new OutputFormatter($string);
		
		return $formatter->getFormatted();
	}

	/**
	 * @param string $message
	 */
	public function message($message)
	{
		$this->write($message);
	}
	
	public function success($message)
	{
		$this->writeColor($message, 'green');
	}
	
	public function info($message)
	{
		$this->writeColor($message, 'blue');
	}
	
	public function warning($message)
	{
		$this->writeColor($message, 'yellow');
	}
	
	/**
	 * @param string $message
	 */
	public function error($message)
	{
		$this->writeColor($message, 'red');
	}

	/** 
	* Output a given text to the console screen
	*/
	
	public function write($value)
	{
		$this->display("\n\n" . $value . "\n");
	}
	
	public function writeln($value = "")
	{
		$this->display($value . "\n");
	}
	
	/** 
	* Output any given text with a style to the console screen
	* @param string $color
	*/
	
	public function writeColor($value, $color)
	{
		$this->display($this->applyTextColor($value, $color) . "\n");
	}
	
	/**
	* Apply a color style to a given text
	*/
	
	protected function applyTextColor($text, $color)
	{
		if ($this->hasColorSupport())
		{
			$style = new OutputStyle;
		
			$style->setForeground($color);
			return $style->apply($text);
		}
		return $text;
	}
	
	/**
	 * @param string $value
	 */
	protected function display($value)
	{
		$outputStream = 'php://stdout';
        if (!$this->hasStdoutSupport()) {
            $outputStream = 'php://output';
        }
        
        $write = fopen($outputStream, 'w');
        fwrite($write, $value);
        fclose($write);
	}
	
	
	protected function hasStdoutSupport()
    {
        return ('OS400' != php_uname('s'));
    }

    protected function hasColorSupport()
    {
    	if (DIRECTORY_SEPARATOR === '\\') {
            return false !== getenv('ANSICON');
        }

        return function_exists('posix_isatty') && @posix_isatty(STDOUT);
    }
	
}