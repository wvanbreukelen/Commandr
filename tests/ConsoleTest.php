<?php

require('config/config.php');

use Commandr\Core\Application;
use Commandr\Core\Input;
use Commandr\Core\Output;
use Commandr\Core\Dialog;
use Commandr\Core\Config;

class ConsoleTest extends PHPUnit_Framework_TestCase
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
		
		$config = $this->generateNewConfig();
		
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

	public function testConsoleList()
	{
		$list = new \Commandr\Commands\ListCommand();

		$this->app->setConfig($this->generateNewConfig());

		$this->app->registerCommand(new \Commandr\Commands\HelpCommand);
		$this->app->registerCommand($list);

		$this->app->runCommand($list);
	}

	private function generateNewConfig()
	{
		return new Config(dumpConfig());
	}
}