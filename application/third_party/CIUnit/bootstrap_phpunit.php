<?php

/*
echo '<pre>';
var_dump($GLOBALS);
echo '</pre>';
exit;
*/

/*
 * ------------------------------------------------------
 *  CIUnit Version
 * ------------------------------------------------------
 */
	define('CIUnit_Version', '0.17');

/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *   development
 *   testing
 *   production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 *
 */
	define('ENVIRONMENT', 'testing');

/*
 *---------------------------------------------------------------
 * PHP ERROR REPORTING LEVEL
 *---------------------------------------------------------------
 *
 * By default CI runs with error reporting set to ALL.  For security
 * reasons you are encouraged to change this to 0 when your site goes live.
 * For more info visit:  http://www.php.net/error_reporting
 *
 */
    error_reporting(E_ALL);

/*
 *---------------------------------------------------------------
 * SYSTEM FOLDER NAME
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" folder.
 * Include the path if the folder is not in the same  directory
 * as this file.
 * 
 * NO TRAILING SLASH!
 * 
 * The test should be run from inside the tests folder.  The assumption
 * is that the tests folder is in the same directory path as system.  If
 * it is not, update the paths appropriately.
 */
    $system_path = dirname(__FILE__) . "/../../../system";

/*
 *---------------------------------------------------------------
 * APPLICATION FOLDER NAME
 *---------------------------------------------------------------
 *
 * If you want this front controller to use a different "application"
 * folder then the default one you can set its name here. The folder
 * can also be renamed or relocated anywhere on your server.  If
 * you do, use a full server path. For more info please see the user guide:
 * http://codeigniter.com/user_guide/general/managing_apps.html
 *
 * NO TRAILING SLASH!
 * 
 * The tests should be run from inside the tests folder.  The assumption
 * is that the tests folder is in the same directory as the application
 * folder.  If it is not, update the path accordingly.
 */
    $application_folder = dirname(__FILE__) . "/../..";

/**
 * --------------------------------------------------------------
 * CIUNIT FOLDER NAME
 * --------------------------------------------------------------
 * 
 * Typically this folder will be within the application's third-party
 * folder.  However, you can place the folder in any directory.  Just
 * be sure to update this path.
 *
 * NO TRAILING SLASH!
 *
 */
    $ciunit_folder = dirname(__FILE__);
 
/**
 * --------------------------------------------------------------
 * UNIT TESTS FOLDER NAME
 * --------------------------------------------------------------
 *
 * This is the path to the tests folder.
 */
    $tests_folder = dirname(__FILE__) . "/../../../tests";

// --------------------------------------------------------------------
// END OF USER CONFIGURABLE SETTINGS.  DO NOT EDIT BELOW THIS LINE
// --------------------------------------------------------------------


/*
 * ---------------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ---------------------------------------------------------------
 */
    if (realpath($system_path) !== FALSE)
    {
        $system_path = realpath($system_path).'/';
    }

    // ensure there's a trailing slash
    $system_path = rtrim($system_path, '/').'/';
    
    // Is the system path correct?
    if ( ! is_dir($system_path))
    {
        exit("Your system folder path does not appear to be set correctly. Please open the following file and correct this: ".pathinfo(__FILE__, PATHINFO_BASENAME));
    }

/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */
    // The name of THIS file
    define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

    // The PHP file extension
    define('EXT', '.php');

    // Path to the system folder
    define('BASEPATH', str_replace("\\", "/", $system_path));

    // Path to the front controller (this file)
    define('FCPATH', str_replace(SELF, '', __FILE__));

    // Name of the "system folder"
    define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));


    // The path to the "application" folder
    if (is_dir($application_folder))
    {
        define('APPPATH', $application_folder.'/');
    }
    else
    {
        if ( ! is_dir(BASEPATH.$application_folder.'/'))
        {
            exit("Your application folder path does not appear to be set correctly. Please open the following file and correct this: ".SELF);
        }

        define('APPPATH', BASEPATH.$application_folder.'/');
    }
    
    // The path to CIUnit
    if (is_dir($ciunit_folder))
    {
        define('CIUPATH', $ciunit_folder . '/');
    }
    else
    {
        if ( ! is_dir(APPPATH . 'third_party/' . $ciunit_folder))
        {
            exit("Your CIUnit folder path does not appear to be set correctly. Please open the following file and correct this: ".SELF);
        }
        
        define ('CIUPATH', APPPATH . 'third_party/' . $ciunit_folder);
    }
    
    
    // The path to the Tests folder
    define('TESTSPATH', $tests_folder . '/');

/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILES
 * --------------------------------------------------------------------
 */

// Load the CIUnit CodeIgniter Core
require_once CIUPATH . 'core/CodeIgniter' . EXT;

// Autoload the PHPUnit Framework
require_once ('PHPUnit/Autoload.php');

// Load the CIUnit Framework
require_once CIUPATH. 'libraries/CIUnit.php';