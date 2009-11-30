<?php

include_once dirname(__FILE__).'/../CIUnit.php';

class testSomeLib extends CIUnit_TestCase {

    function setUp() {

    }

    function tearDown() {
    
    }

    public function testLibMethod(){
       $this->assertTrue(true);
    }

    public function testMethod() {

    }
    
}