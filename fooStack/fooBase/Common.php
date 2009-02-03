<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* fooStack, CIUnit
* modified CI file
*/


/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2006, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Common Functions
 *
 * Loads the base classes and executes the request.
 *
 * @package		CodeIgniter
 * @subpackage	codeigniter
 * @category	Common Functions
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/
 */

// ------------------------------------------------------------------------

include(dirname(__FILE__) . '/config.php');

/**
 * Tests for file writability
 *
 * is_writable() returns TRUE on Windows servers
 * when you really can't write to the file
 * as the OS reports to PHP as FALSE only if the
 * read-only attribute is marked.  Ugh?
 *
 * @access	private
 * @return	void
 */
function is_really_writable($file)
{
	if (is_dir($file))
	{
		$file = rtrim($file, '/').'/'.md5(rand(1,100));

		if (($fp = @fopen($file, FOPEN_WRITE_CREATE)) === FALSE)
		{
			return FALSE;
		}

		fclose($fp);
		@chmod($file, DIR_WRITE_MODE);
		@unlink($file);
		return TRUE;
	}
	elseif (($fp = @fopen($file, FOPEN_WRITE_CREATE)) === FALSE)
	{
		return FALSE;
	}

	fclose($fp);
	return TRUE;
}

// ------------------------------------------------------------------------

/**
* Class registry
*
* This function acts as a singleton.  If the requested class does not
* exist it is instantiated and set to a static variable.  If it has
* previously been instantiated the variable is returned.
*
* @access	public
* @param	string	the class name being requested
* @param	bool	optional flag that lets classes get loaded but not instantiated
* @return	object
*/
function &load_class($class, $instantiate = TRUE)
{
	static $objects = array();

    $prefix = config_item('subclass_prefix');
    $fs = foo_config();
    $fooprefix = $fs['prefix'];

    $is_fooclass = FALSE;

    //is it in a subfolder?
    $folders = explode('/', $class);
    if(count($folders) > 1){
          $class = array_pop($folders);
          $folders = join('/', $folders).'/';
    }else{
        $folders = '';
    }
    //echo "folder:".print_r($folders,1);
    //echo "class:".print_r($class,1)." *\n";



	// Does the class exist?  If so, we're done...
	if (isset($objects[$class]))
	{
		return $objects[$class];
	}

	// user extension class?
	if (file_exists(APPPATH.'libraries/'.$folders.$prefix.$class.EXT))
	{
        // require Base Class
		require(BASEPATH.'libraries/'.$class.EXT);


        // extend with fooStack class
        if(file_exists(FSPATH.$fooprefix.$class.EXT)){
            require(FSPATH.$fooprefix.$class.EXT);
            $is_fooclass = TRUE;
        }

        // load user class
		require(APPPATH.'libraries/'.$folders.$prefix.$class.EXT);
		$is_subclass = TRUE;
	}

	else
    {
        // independent user class?
        if (file_exists(APPPATH.'libraries/'.$folders.$class.EXT))
		{
            //load it
			require(APPPATH.'libraries/'.$folders.$class.EXT);
			$is_subclass = FALSE;
            $is_fooclass = FALSE;
		}
		else
		{
            // so it must be a base class / or foostack class
			require(BASEPATH.'libraries/'.$class.EXT);
            if(file_exists(FSPATH.$fooprefix.$class.EXT)){
                require(FSPATH.$fooprefix.$class.EXT);
                $is_fooclass = TRUE;
            }
			$is_subclass = FALSE;
		}
	}

	if ($instantiate == FALSE)
	{
		$objects[$class] = TRUE;
		return $objects[$class];
	}

	if ($is_subclass == TRUE)
	{
		$name = $prefix.$class;
        echo "Subclass ". $name . " loading..";
		$objects[$class] =& new $name();
		return $objects[$class];
	}

    $prefix = $is_fooclass? $fooprefix:'CI_';
	$name = ($class != 'Controller') ? $prefix.$class : $class;

    //echo "Class ". $name. " loading..";

	$objects[$class] =& new $name();
	return $objects[$class];
}


/**
* fooStack lets plugins each extend their own CI libraries.
* in order to be able to do that we have to find out what files are to be included
* and what objects have to be intermediary
*/
function find_load_order($class){

    //user prefix
    $prefix = config_item('subclass_prefix');

    //foostack config var
    $fs = foo_config();

    //foostack end user class prefix - foostack classes can be exended by the user
    $fooprefix = $fs['prefix'];

    //main cases:

    //base classes - fooextension classes - fooadditional classes - user classes - user extension classes

    // load base class (fooconfig decideds if we extend it)
    // load non-base class, either fooclass


    $is_fooclass = FALSE;

    //is it in a subfolder?
    $folders = explode('/', $class);
    if(count($folders) > 1){
          $class = array_pop($folders);
          $folders = join('/', $folders).'/';
    }else{
        $folders = '';
    }
    //echo "folder:".print_r($folders,1);
    //echo "class:".print_r($class,1)." *\n";



	// Does the class exist?  If so, we're done...
	if (isset($objects[$class]))
	{
		return $objects[$class];
	}

	// user extension class?
	if (file_exists(APPPATH.'libraries/'.$folders.$prefix.$class.EXT))
	{
        // require Base Class
		require(BASEPATH.'libraries/'.$class.EXT);


        // extend with fooStack class
        if(file_exists(FSPATH.$fooprefix.$class.EXT)){
            require(FSPATH.$fooprefix.$class.EXT);
            $is_fooclass = TRUE;
        }

        // load user class
		require(APPPATH.'libraries/'.$folders.$prefix.$class.EXT);
		$is_subclass = TRUE;
	}

	else
    {
        // independent user class?
        if (file_exists(APPPATH.'libraries/'.$folders.$class.EXT))
		{
            //load it
			require(APPPATH.'libraries/'.$folders.$class.EXT);
			$is_subclass = FALSE;
            $is_fooclass = FALSE;
		}
		else
		{
            // so it must be a base class / or foostack class
			require(BASEPATH.'libraries/'.$class.EXT);
            if(file_exists(FSPATH.$fooprefix.$class.EXT)){
                require(FSPATH.$fooprefix.$class.EXT);
                $is_fooclass = TRUE;
            }
			$is_subclass = FALSE;
		}
	}

	if ($instantiate == FALSE)
	{
		$objects[$class] = TRUE;
		return $objects[$class];
	}

	if ($is_subclass == TRUE)
	{
		$name = $prefix.$class;
        echo "Subclass ". $name . " loading..";
		$objects[$class] =& new $name();
		return $objects[$class];
	}

    $prefix = $is_fooclass? $fooprefix:'CI_';
	$name = ($class != 'Controller') ? $prefix.$class : $class;

    //echo "Class ". $name. " loading..";

	$objects[$class] =& new $name();
	return $objects[$class];

}

/**
* Loads the main config.php file
*
* @access	private
* @return	array
*/
function &get_config()
{
	static $main_conf;

	if ( ! isset($main_conf))
	{
		if ( ! file_exists(APPPATH.'config/config'.EXT))
		{
			exit('The configuration file config'.EXT.' does not exist.');
		}

		require(APPPATH.'config/config'.EXT);

		if ( ! isset($config) OR ! is_array($config))
		{
			exit('Your config file does not appear to be formatted correctly.');
		}

		$main_conf[0] =& $config;
	}
	return $main_conf[0];
}

/**
* Gets a config item
*
* @access	public
* @return	mixed
*/
function config_item($item)
{
	static $config_item = array();

	if ( ! isset($config_item[$item]))
	{
		$config =& get_config();

		if ( ! isset($config[$item]))
		{
			return FALSE;
		}
		$config_item[$item] = $config[$item];
	}

	return $config_item[$item];
}


/**
* Error Handler
*
* This function lets us invoke the exception class and
* display errors using the standard error template located
* in application/errors/errors.php
* This function will send the error page directly to the
* browser and exit.
*
* @access	public
* @return	void
*/
function show_error($message)
{
	$error =& load_class('Exceptions');
	echo $error->show_error('An Error Was Encountered', $message);
	exit;
}


/**
* 404 Page Handler
*
* This function is similar to the show_error() function above
* However, instead of the standard error template it displays
* 404 errors.
*
* @access	public
* @return	void
*/
function show_404($page = '')
{
	$error =& load_class('Exceptions');
	$error->show_404($page);
	exit;
}


/**
* Error Logging Interface
*
* We use this as a simple mechanism to access the logging
* class and send messages to be logged.
*
* @access	public
* @return	void
*/
function log_message($level = 'error', $message, $php_error = FALSE)
{
	static $LOG;
	
	$config =& get_config();
	if ($config['log_threshold'] == 0)
	{
		return;
	}

	$LOG =& load_class('Log');	
	$LOG->write_log($level, $message, $php_error);
}

/**
* Exception Handler
*
* This is the custom exception handler that is declaired at the top
* of Codeigniter.php.  The main reason we use this is permit
* PHP errors to be logged in our own log files since we may
* not have access to server logs. Since this function
* effectively intercepts PHP errors, however, we also need
* to display errors based on the current error_reporting level.
* We do that with the use of a PHP error template.
*
* @access	private
* @return	void
*/
function _exception_handler($severity, $message, $filepath, $line)
{	
	 // We don't bother with "strict" notices since they will fill up
	 // the log file with information that isn't normally very
	 // helpful.  For example, if you are running PHP 5 and you
	 // use version 4 style class functions (without prefixes
	 // like "public", "private", etc.) you'll get notices telling
	 // you that these have been deprecated.
	
	if ($severity == E_STRICT)
	{
		return;
	}

	$error =& load_class('Exceptions');

	// Should we display the error?
	// We'll get the current error_reporting level and add its bits
	// with the severity bits to find out.
	
	if (($severity & error_reporting()) == $severity)
	{
		$error->show_php_error($severity, $message, $filepath, $line);
	}
	
	// Should we log the error?  No?  We're done...
	$config =& get_config();
	if ($config['log_threshold'] == 0)
	{
		return;
	}

	$error->log_exception($severity, $message, $filepath, $line);
}



/* End of file Common.php */
/* Location: ./system/codeigniter/Common.php */