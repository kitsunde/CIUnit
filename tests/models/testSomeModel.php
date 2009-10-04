<?php

include_once dirname(__FILE__).'/../CIUnit.php';

class testSomeModel extends CIUnit_TestCase{
    function setUp(){
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

    function testProductFetching(){
        /*
        $this->assertEqual($this->products_fixt['first'], $this->pm->product(1));
        */
    }



}