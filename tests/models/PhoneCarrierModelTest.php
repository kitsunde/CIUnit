<?php

/**
 * @group Model
 */

class PhoneCarrierModelTest extends CIUnit_TestCase
{
	protected $tables = array(
		'phone_carrier' => 'phone_carrier'
	);
	
	private $_pcm;
	
	public function __construct($name = NULL, array $data = array(), $dataName = '')
	{
		parent::__construct($name, $data, $dataName);
	}
	
	public function setUp()
	{
		parent::setUp();
		
		/*
		* this is an example of how you would load a product model,
		* load fixture data into the test database (assuming you have the fixture yaml files filled with data for your tables),
		* and use the fixture instance variable
		
		$this->CI->load->model('Product_model', 'pm');
		$this->pm=$this->CI->pm;
		$this->dbfixt('users', 'products');
		
		the fixtures are now available in the database and so:
		$this->users_fixt;
		$this->products_fixt;
		
		*/
		
		$this->CI->load->model('Phone_carrier_model');
		$this->_pcm = $this->CI->Phone_carrier_model;
	}
	
	public function tearDown()
	{
		parent::tearDown();
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * @dataProvider GetCarriersProvider
	 */
	public function testGetCarriers(array $attributes, $expected)
	{
		$actual = $this->_pcm->getCarriers($attributes);
		
		$this->assertEquals($expected, count($actual));
	}
	
	public function GetCarriersProvider()
	{
		return array(
			array(array('name'), 5)
		);
	}
	
	// ------------------------------------------------------------------------
	
}
