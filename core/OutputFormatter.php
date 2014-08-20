<?php

namespace Commandr\Core;

class OutputFormatter
{

	protected $formatted;

	public function __construct($value)
	{
		if (is_string($string))
		{
			$this->formatted = $this->formatString($string);
		}
	}

	public function formatString()
	{
		$string = str_replace("-", "\n", $string);
		$string = str_replace("{TAB}", "   ", $string);
		
		return $string;
	}
	
	public function getFormatted()
	{
		return $this->formatted;
	}
}