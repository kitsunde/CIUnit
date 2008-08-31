<?php

/*
* fooStack, CIUnit
* Copyright (c) 2008 Clemens Gruenberger
* Released with permission from www.redesignme.com, thanks guys!
* Released under the MIT license, see:
* http://www.opensource.org/licenses/mit-license.php
*/

class CIUnitTestSuite{

    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

}