<?php

/*
* fooStack, CIUnit
* Copyright (c) 2008 Clemens Gruenberger
* Released with permission from www.redesignme.com, thanks guys!
* Released under the MIT license, see:
* http://www.opensource.org/licenses/mit-license.php
*/

include_once dirname(__FILE__).'/../CIUnit.php';

class testSpyc extends PHPUnit_Framework_TestCase{

    function setUp(){
        $this->CI = &set_controller();
    }
    
    //test instantiation of controller
    public function testSpycController(){
      $this->CI->load->library('Spyc');
      $this->assertTrue(method_exists($this->CI->spyc, 'YAMLLoad'));
    }
    
    public function testLoadYaml(){
      $this->CI->load->library('Spyc');
      $yaml = Spyc::YAMLLoad(FSPATH . 'Spyc/spyc.yaml');
      $yaml2 = $this->CI->spyc->YAMLLoad(FSPATH . 'Spyc/spyc.yaml');
      $this->assertEquals($yaml, $yaml2);
      //loads allright;
      $this->assertType('array', $yaml);
      $testfile = file_get_contents(FSPATH . 'Spyc/test.php');
      $this->assertSame(1, preg_match('/YAMLLoad\(\'spyc\.yaml\'\);([\s\S]*)\?>/', $testfile, $matches));
      ob_start();
      eval($matches[1]);
      $testresults = ob_get_contents();
      ob_end_clean();
      $this->assertSame("spyc.yaml parsed correctly\n", $testresults);
    }

}