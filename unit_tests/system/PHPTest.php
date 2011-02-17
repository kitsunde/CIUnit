<?php

require_once dirname(__FILE__).'/../bootstrap.php';

class PHPTest extends CIUnit_TestCase
{
	function setUp()
	{
		// Setup
	}

	public function testFunctionJsonEncode()
	{
		$this->assertTrue(function_exists('json_encode'));
	}

	public function testPhpVersion()
	{
		$this->assertTrue(phpversion() > 5.1);
	}
}