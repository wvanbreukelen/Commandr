<?php

require('config/config.php');

use Commandr\Core\Application;
use Commandr\Core\Input;
use Commandr\Core\Output;
use Commandr\Core\Dialog;
use Commandr\Core\Config;

class ConsoleCreationTest extends PHPUnit_Framework_TestCase
{

	protected $app;

	public function __construct()
	{
		$this->app = new Application(
			new Input,
			new Output,
			new Dialog,
			'PHPUnit Console TestCase',
			'1.0'
		);
	}

	public function testConsoleCreation()
	{
		$this->assertTrue($this->app instanceof Commandr\Core\Application);
	}
	
	public function testConsoleAddConfig()
	{
		//$this->assertTrue(function_exists('dumpConfig'));
		
		$config = new Config(dumpConfig());
		
		$this->app->setConfig($config);
		
		$this->assertTrue(is_object($this->app->getConfig()));
	}
	
	public function testConsoleGetConfig()
	{
		$config = new Config(array(
			"category" => array("value1" => "hello")
		));
		
		$this->assertEquals($config->get("category", "value1"), "hello");
		
		$this->assertEquals($config->get("category"), array("value1" => "hello"));
		
		$config->setDefaultCategory("category");
		
		$this->assertEquals($config->get(null, "value1"), "hello");
	}
}