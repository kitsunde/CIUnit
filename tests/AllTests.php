<?php

/*
* fooStack, CIUnit
* Copyright (c) 2008 Clemens Gruenberger
* Released with permission from www.redesignme.com, thanks guys!
* Released under the MIT license, see:
* http://www.opensource.org/licenses/mit-license.php
*/

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'AllTests::main');
}

require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

require_once 'controllers/ControllersAllTests.php';
require_once 'models/ModelsAllTests.php';
require_once 'views/ViewsAllTests.php';
require_once 'libs/LibsAllTests.php';
require_once 'helpers/HelpersAllTests.php';
require_once 'system/SystemAllTests.php';
require_once 'ciunit/CiunitAllTests.php';

class AllTests extends CIUnitTestSuite
{

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('APPLICATION testsuite');

        $suite->addTestSuite('CiunitAllTests');  //make sure tests function correctly
        $suite->addTestSuite('SystemAllTests');  //env variables, php version, etc.

        //test CI framework libs and extensions
        $suite->addTestSuite('LibsAlltests');

        //test application
        $suite->addTestSuite('ModelsAlltests');
        $suite->addTestSuite('ViewsAlltests');
        $suite->addTestSuite('ControllersAlltests');
        $suite->addTestSuite('HelpersAlltests');

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'AllTests::main') {
    AllTests::main();
}