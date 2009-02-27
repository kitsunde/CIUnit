<?php

/*
* fooStack, CIUnit
* Copyright (c) 2008 Clemens Gruenberger
* Released with permission from www.redesignme.com, thanks guys!
* Released under the MIT license, see:
* http://www.opensource.org/licenses/mit-license.php
*/

/*
* CIUnit Controller fixture, leave it here!
*/
class Controller_fixt extends Controller {

  function test($in){
    $out = $in;
    return $out;
  }
  
  function show1($data){
    $this->load->view('../tests/fixtures/view_fixt', array('data' => $data));
  }
  
  function show2(){
    $some_var=array(1,2,3);
    $data=array(
      'data' => $some_var
    );
    $this->load->view('../tests/fixtures/view_fixt', $data);
  }
  
  function show3(){
    $some_var=array(1,2,3);
    $data=array(
      'data' => $some_var
    );
    $this->load->view('../tests/fixtures/view_fixt2', $data);
  }

}
?>