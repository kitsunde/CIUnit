<?php

/**
 * @group Model
 */

class SomeModelTest extends CIUnit_TestCase
{
	protected $tables = array(
		//'group'		 => 'group',
		//'user'		  => 'user',
		//'user_group'	=> 'user_group'
	);
	
	public function __construct($name = NULL, array $data = array(), $dataName = '')
	{
		parent::__construct($name, $data, $dataName);
	}
	
	public function setUp()
	{
		parent::tearDown();
		parent::setUp();
		
		/*
		* this is an example of how you would load a product model,
		* load fixture data into the test database (assuming you have the fixture yaml files filled with data for your tables),
		* and use the fixture instance variable
		
		$this->CI->load->model('Product_model', 'pm');
		$this->pm=$this->CI->pm;
		$this->dbfixt('users', 'products')
		
		the fixtures are now available in the database and so:
		$this->users_fixt;
		$this->products_fixt;
		
		*/
	}

	public function testProductFetching()
	{
		/*
		$this->assertEqual($this->products_fixt['first'], $this->pm->product(1));
		*/
	}
}
