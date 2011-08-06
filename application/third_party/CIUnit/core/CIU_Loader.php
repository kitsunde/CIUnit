<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// Is the request a class extension? If so we load it too
if (file_exists(APPPATH.$directory.'/'.config_item('subclass_prefix').'Loader.php'))
{
	require(CIUPATH.'core/CIU_Loader_MY_Loader.php');
}
else
{
	require(CIUPATH.'core/CIU_Loader_CI_Loader.php');
}
/* End of file CIU_Loader.php */
/* Location: ./application/third_party/CIUnit/core/CIU_Loader.php */