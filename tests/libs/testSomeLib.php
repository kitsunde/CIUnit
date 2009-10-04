<?php

include_once dirname(__FILE__).'/../CIUnit.php';

class testSomeLib extends CIUnit_TestCase{

    function setUp(){
        //$this->CI->load->library('Somelib');
        //$this->sl = this->CI->Somelib;
    }

    function tearDown(){
    
    }

    function testLibMethod(){
       $this->assertTrue(true);
    }
    
}