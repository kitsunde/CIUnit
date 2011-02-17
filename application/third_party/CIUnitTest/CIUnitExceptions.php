<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CIUnitExceptions extends CI_Exceptions
{
	function show_php_error($severity, $message, $filepath, $line)
	{
		// Muted :-X
	}
	
	function show_error($heading, $message, $template = 'error_general', $status_code = 500)
	{
		return "\n\nCodeigniter: $heading\nMessage: $message\n\n";
	}
}

/* End of file Exceptions.php */
/* Location: ./system/libraries/Exceptions.php */