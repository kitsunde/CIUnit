<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// Is the request a class extension? If so we load it too
if (file_exists(APPPATH.$directory.'/'.config_item('subclass_prefix').'Output.php'))
{
	require(CIUPATH.'core/CIU_Output_MY_Output.php');
}
else
{
	require(CIUPATH.'core/CIU_Output_CI_Output.php');
}
/* End of file CIU_Output.php */
/* Location ./application/third_party/CIUnit/core/CIU_Output.php */