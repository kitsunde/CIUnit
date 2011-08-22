<?php

/**
 * @group Controller
 */

class CI_Unit_Test_class_Test extends CIUnit_TestCase
{
	public function setUp()
	{
	}
	
	public function test_CI_Unit_Test_Class()
	{
		$test_path = APPPATH . 'controllers';
		$test_folder = 'tests';
		
		$has_failed = FALSE;
		
		foreach (glob("$test_path/$test_folder/*.php") as $filename)
		{
			$filename = basename($filename, '.php');
			$this->CI = set_controller("$test_folder/$filename");
			
			echo "\nCI Unit Testing Class: $test_folder/$filename\n";
			if ($this->_run_ci_unit_test() === FALSE)
			{
				$has_failed = TRUE;
			}
		}
		
		if ($has_failed)
		{
			$this->fail();
		}
	}
	
	function _run_ci_unit_test()
	{
		// Output buffering
		ob_start();
		
		// Call the controllers method
		$this->CI->index();
		
		// Fetch the buffered output
		$output = ob_get_contents();
		
		// Clear buffer
		ob_end_clean();
		
		//echo 'output: ', $output;

		$has_failed = FALSE;
		$lines = explode("\n", $output);
		foreach ($lines as $line)
		{
			$all = 0;
			$passed = 0;
			$failed = 0;
			
			//echo $line, "\n";
			
			if (preg_match('/All:(\d) Passed:(\d) Failed:(\d)/', $line, $matches))
			{
				$all = $matches[1];
				$passed = $matches[2];
				$failed = $matches[3];
				
				if ($failed > 0)
				{
					$has_failed = TRUE;
				}
			}
			else if (substr($line, 0 ,1) === ' ')	// failed test name
			{
				echo "\x1b[31m" . $line . "\x1b[0m" . "\n";
			}
		}
		
		
		if ($has_failed)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}
