<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* fooStack, CIUnit for CodeIgniter
* Copyright (c) 2008-2009 Clemens Gruenberger
* Released under the MIT license, see:
* http://www.opensource.org/licenses/mit-license.php
*/

/*
* CodeIgniter source modified for fooStack / CIUnit
* CIU_Loader_CI_Loader.php and CIU_Loader_MY_Loader.php are the same except parent class. 
*/

class CIU_Loader extends CI_Loader {

	/**
	 * Instantiates a class
	 *
	 * @param	string
	 * @param	string
	 * @param	string	an optional object name
	 * @return	null
	 */
	protected function _ci_init_class($class, $prefix = '', $config = FALSE, $object_name = NULL)
	{
		// Is there an associated config file for this class? Note: these should always be lowercase
		if ($config === NULL)
		{
			// Fetch the config paths containing any package paths
			$config_component = $this->_ci_get_component('config');

			if (is_array($config_component->_config_paths))
			{
				// Break on the first found file, thus package files
				// are not overridden by default paths
				foreach ($config_component->_config_paths as $path)
				{
					// We test for both uppercase and lowercase, for servers that
					// are case-sensitive with regard to file names. Check for environment
					// first, global next
					if (defined('ENVIRONMENT') AND file_exists($path .'config/'.ENVIRONMENT.'/'.strtolower($class).'.php'))
					{
						include_once($path .'config/'.ENVIRONMENT.'/'.strtolower($class).'.php');
						break;
					}
					elseif (defined('ENVIRONMENT') AND file_exists($path .'config/'.ENVIRONMENT.'/'.ucfirst(strtolower($class)).'.php'))
					{
						include_once($path .'config/'.ENVIRONMENT.'/'.ucfirst(strtolower($class)).'.php');
						break;
					}
					elseif (file_exists($path .'config/'.strtolower($class).'.php'))
					{
						include_once($path .'config/'.strtolower($class).'.php');
						break;
					}
					elseif (file_exists($path .'config/'.ucfirst(strtolower($class)).'.php'))
					{
						include_once($path .'config/'.ucfirst(strtolower($class)).'.php');
						break;
					}
				}
			}
		}

		if ($prefix == '')
		{
			if (class_exists('CI_'.$class))
			{
				$name = 'CI_'.$class;
			}
			elseif (class_exists(config_item('subclass_prefix').$class))
			{
				$name = config_item('subclass_prefix').$class;
			}
			else
			{
				$name = $class;
			}
		}
		else
		{
			$name = $prefix.$class;
		}

		// Is the class name valid?
		if ( ! class_exists($name))
		{
			log_message('error', "Non-existent class: ".$name);
			show_error("Non-existent class: ".$class);
		}

		// Set the variable name we will assign the class to
		// Was a custom class name supplied? If so we'll use it
		$class = strtolower($class);

		if (is_null($object_name))
		{
			$classvar = ( ! isset($this->_ci_varmap[$class])) ? $class : $this->_ci_varmap[$class];
		}
		else
		{
			$classvar = $object_name;
		}

		// Save the class name and object name
		$this->_ci_classes[$class] = $classvar;
		// Instantiate the class
		$CI =& get_instance();
		if ($config !== NULL)
		{
			if ( ! defined('CIUnit_Version'))
			{
				$CI->$classvar = new $name($config);
			}
			elseif ( ! isset($CI->$classvar))
			{
				//redesignme: check if we have got one already..
				$CI->$classvar = new $name($config);
			}
		}
		else
		{
			if ( ! defined('CIUnit_Version'))
			{
				$CI->$classvar = new $name;
			}
			elseif ( ! isset($CI->$classvar))
			{
				//redesignme: check if we have got one already..
				$CI->$classvar = new $name;
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Autoloader
	 *
	 * The config/autoload.php file contains an array that permits sub-systems,
	 * libraries, and helpers to be loaded automatically.
	 *
	 * This function is public, as it's used in the CI_Controller class.
	 * However, there is no reason you should ever needs to use it.
	 *
	 * @param	array
	 * @return	void
	 */
	public function ci_autoloader()
	{
		if (defined('ENVIRONMENT') AND file_exists(APPPATH.'config/'.ENVIRONMENT.'/autoload.php'))
		{
			// enable multiple autoload during tests
			include(APPPATH.'config/'.ENVIRONMENT.'/autoload.php');
		}
		else
		{
			// enable multiple autoload during tests
			include(APPPATH.'config/autoload.php');
		}


		if ( ! isset($autoload))
		{
			return FALSE;
		}

		// Autoload packages
		if (isset($autoload['packages']))
		{
			foreach ($autoload['packages'] as $package_path)
			{
				$this->add_package_path($package_path);
			}
		}

		// Load any custom config file
		if (count($autoload['config']) > 0)
		{
			$CI =& get_instance();
			foreach ($autoload['config'] as $key => $val)
			{
				$CI->config->load($val);
			}
		}

		// Autoload helpers and languages
		foreach (array('helper', 'language') as $type)
		{
			if (isset($autoload[$type]) AND count($autoload[$type]) > 0)
			{
				$this->$type($autoload[$type]);
			}
		}

		// A little tweak to remain backward compatible
		// The $autoload['core'] item was deprecated
		if ( ! isset($autoload['libraries']) AND isset($autoload['core']))
		{
			$autoload['libraries'] = $autoload['core'];
		}

		// Load libraries
		if (isset($autoload['libraries']) AND count($autoload['libraries']) > 0)
		{
			// Load the database driver.
			if (in_array('database', $autoload['libraries']))
			{
				$this->database();
				$autoload['libraries'] = array_diff($autoload['libraries'], array('database'));
			}

			// Load all other libraries
			foreach ($autoload['libraries'] as $item)
			{
				$this->library($item);
			}
		}

		// Autoload models
		if (isset($autoload['model']))
		{
			$this->model($autoload['model']);
		}
	}

	// --------------------------------------------------------------------

	/*
	* Can load a view file from an absolute path and
	* relative to the CodeIgniter index.php file
	* Handy if you have views outside the usual CI views dir
	*/
	function viewfile($viewfile, $vars = array(), $return = FALSE)
	{
		return $this->_ci_load(
			array('_ci_path' => $viewfile,
				'_ci_vars' => $this->_ci_object_to_array($vars),
				'_ci_return' => $return)
		);
	}

	// --------------------------------------------------------------------

	function reset()
	{
		$this->_ci_cached_vars = array();
		$this->_ci_classes = array();
		$this->_ci_loaded_files = array();
		$this->_ci_models = array();
		$this->_ci_helpers = array();
	}
}

/* End of file CIU_Loader_CI_Loader.php */
/* Location: ./application/third_party/CIUnit/core/CIU_Loader_CI_Loader.php */