<?php

namespace Commandr\Core;

class Config
{

	protected $defaultCategory;
	
	protected $config;

	public function __construct($config)
	{
		$this->config = $config;
	}
	
	public function setDefaultCategory($category)
	{
		$this->defaultCategory = $category;
	}
	
	public function get($category = null, $item = null)
	{
		if (!is_null($this->defaultCategory))
		{
			if (is_null($item))
			{
				return $this->config[$this->defaultCategory];
			}
			
			if (isset($this->config[$this->defaultCategory][$item]))
			{
				return $this->config[$this->defaultCategory][$item];
			}
		}
	
		if (isset($this->config[$category]))
		{
			if (is_null($item))
			{
				return $this->config[$category];
			}
			
			if (isset($this->config[$category][$item]))
			{
				return $this->config[$category][$item];
			}
		}
		
		return null;
	}
}