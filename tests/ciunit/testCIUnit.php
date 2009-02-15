<?php

/*
* fooStack, CIUnit
* Copyright (c) 2008 Clemens Gruenberger
* Released with permission from www.redesignme.com, thanks guys!
* Released under the MIT license, see:
* http://www.opensource.org/licenses/mit-license.php
*/

include_once dirname(__FILE__).'/../CIUnit.php';

class testCIUnit extends CIUnit_TestCase{
    function setUp(){
        $this->CI = &set_controller();
    }

    //test instantiation of controller
    public function testController(){
      $this->assertTrue(method_exists($this->CI, '_ci_initialize'));
      $this->assertFalse(method_exists($this->CI, 'test'));
    }

    //test new Controller instantiation for each test
    public function testControllerRegeneration01(){
      //$this->CI->_ci_scaffolding=True;
      //echo 'before';
    }

    public function testControllerRegeneration02(){
      $this->assertFalse($this->CI->_ci_scaffolding);
      //echo 'in between';
    }
    
    public function testControllerRegeneration03(){
      $this->CI->_ci_scaffolding=True;
      //echo 'after';
    }

    //testing loader class
    public function testLoadLibrary(){
      //$this->CI = set_controller('../tests/fixtures/Controller_fixt');
      $this->CI->load->library('Email');
      $this->assertTrue(method_exists($this->CI->email, 'send'));
    }

    public function testOutput(){
        global $OUT;
        $this->assertSame($OUT, $this->CI->output);
    }

    //testing outputting views
    public function testView(){
      $this->assertSame('', output());
      
      $some_var = array(1,2,3);
      $viewdata = array(
        'data' => $some_var
      );
      $this->CI->load->view('../tests/fixtures/view_fixt.php', $viewdata);

      //view variables  /*strange assignment*/
      //print_r($data);
      //print_r(viewvars());
      $this->assertEquals($viewdata, viewvars());
      //no assignment of $data to controller
      $this->assertFalse(isset($data));

      //check output
      $expected = print_r($some_var, True);
      $this->assertEquals($expected, output());

      //output is cleared after being called
      $this->assertSame('', output());

      //multiple view calls
      $this->CI->load->view('../tests/fixtures/view_fixt2.php', $viewdata);
      //find rendered result concatenated in output()
      $this->assertEquals($expected.$expected, output());
      //the nested assignment of data in the second fixture extracts $some_var
      $this->assertEquals(array('data'=>$some_var, '0'=>1, '1'=>2, '2'=>3), viewvars());
      //->that means variables from higher levels are available..
    }

    public function testViewIndependent(){
      $this->assertEquals('', output());
      $this->assertEquals(array(), viewvars());
    }

    //*****************************************
    // NICE, we can now switch to different controllers
    //see hackery in MY_Loader / MY_Controller

    //test instantiation of custom application controllers
    public function testApplicationController(){
      //lets set a different controller
      $this->CI = set_controller('../tests/fixtures/Controller_fixt');
      $this->assertTrue(method_exists($this->CI, 'test'));
      $this->assertEquals($this->CI->test('input'), 'input');
    }

    public function testView2(){
      $this->CI = set_controller('../tests/fixtures/Controller_fixt');
      $some_var = array(1,2,3);
      $data = array(
        'data' => $some_var
      );
      $expected = print_r($some_var, True);

      $this->CI->show1($some_var); //includes view fixture
      
      $this->assertEquals($expected, output()); 

      $this->CI->show2(); //calls another function + view fixture
      $this->assertEquals($expected, output());
      
      $this->CI->show3(); //includes view that includes other file + loads another view
      $this->assertEquals($expected.$expected, output());
    }

    function testFilterArr(){
        $arr=array('first'=>'clemens', 'second'=>'manfred', 'third'=>'bibi');
        $arr2=array('first'=>array('name'=>'clemens', 'id'=>34), 'second'=>array('name'=>'manfred', 'id'=>99), 'third'=>array('name'=>'bibi'));
        $this->assertEquals(array('first'=>'clemens', 'second'=>'manfred'), $this->filter_arr($arr, array('/e/')));
        $this->assertEquals(array('first'=>$arr2['first'], 'second'=>$arr2['second']), $this->filter_arr($arr2, array('name'=>'/e/')));
        $this->assertEquals(array('first'=>$arr2['first']), $this->filter_arr($arr2, array('name'=>'clemens')));
        $this->assertEquals(array('first'=>$arr2['first'], 'second'=>$arr2['second']), $this->filter_arr($arr2, array('id'=>'/\d+/')));

        $this->assertEquals(array('first'=>'clemens'), $this->filter_arr($arr, array('/./', '/first/')));
        $this->assertEquals(array('first'=>'clemens',  'third'=>'bibi'), $this->filter_arr($arr, array('/./', '/ir/')));
        $this->assertEquals(array('first'=>'clemens',  'third'=>'bibi'), $this->filter_arr($arr, array('/./i', '/ir/i')));
    }

}