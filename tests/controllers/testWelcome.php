<?php

include_once dirname(__FILE__).'/../CIUnit.php';

class testWelcome extends CIUnit_TestCase{

    function setUp(){
        $this->CI = set_controller('welcome');
    }

    public function testWelcomeController(){
      $this->CI->index();
      $out = output();
      $this->assertSame(0, preg_match('/(error|notice)/i', $out));
    }

}