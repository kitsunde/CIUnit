# CIUnit Foostack

Originally created  by: Clemens "rafsoaken" Gruenberger

Modified and Updated by:

- Mario "Kuroir" Ricalde
- Grzegorz "Grisha" Godlewski
- Tatsuya Fukata
- Kenji "kenjis" Suzuki

## Notes:

- "default" branch is for CodeIgniter 2.1.0.
- To CodeIgniter 2.0.3 users, please use "CI 2.0.3" branch. You can get the latest code from [https://bitbucket.org/kenjis/my-ciunit/get/CI%202.0.3.zip](https://bitbucket.org/kenjis/my-ciunit/get/CI%202.0.3.zip)
- Known Issues: See [https://bitbucket.org/kenjis/my-ciunit/wiki/Home](https://bitbucket.org/kenjis/my-ciunit/wiki/Home)
- CIUnit was updated to work completely with CodeIgniter 2.0.3.
- CIUnit is completely separated from the CodeIgniter Core Files.
  * CIUnit has it's own modified core files and will load them only when needed (by using the console for instance).
  * CIUnit won't use the system index.php anymore, instead it'll use application/third_party/CIUnit/bootstrap_phpunit.php
  * This is to prevent CIUnit/Foostack to cause any extra load on production.

### Folder structure:
- application/third_party/CIUnit/bootstrap_phpunit.php (Application and System Folder)
- tests/phpunit.xml (Optional: only edit if you want to move bootstrap_phpunit.php)

## Install:

### Install by shell script:

	$ cd ciunit
	$ tools/install.sh CI2_Project_Path [DB_Name [DB_User [DB_Passwd [DB_host]]]]

### Install manually:

	$ cp -R ciunit/application CI2_Project_Path/
	$ cp -R ciunit/tests CI2_Project_Path/

create application/config/testing/database.php for database testing.
Database name must end with "_test".

If you use MY_Loader, MY_Output, MY_Session, please change the parent classes below:

- application/third_party/CIUnit/core/CIU_*.php
- application/third_party/CIUnit/libraries/CIU_*.php

## Run Tests:

All Tests:

	$ cd [CI2 Project Path]/tests
	$ phpunit

Some Tests:

	$ cd [CI2 Project Path]/tests
	$ phpunit models

Single Test:

	$ cd [CI2 Project Path]/tests
	$ phpunit models/PhoneCarrierModelTest.php

## (Optional) Execute Tests of CodeIgniter Unit Testing Class:

Limitation:

- You must execute all tests in index() function of testing controllers.

Example:

	function index()
	{
		$this->test_no_additional_headers();
		$this->test_x_forwarded_for();
		$this->test_client_ip();
		$this->test_x_forwarded_for_and_client_ip();

		echo $this->unit->report();
	}

See tests/controllers/CI_Unit_Test_class_Test.php.
In test_CI_Unit_Test_Class() function, set the folder where testing controllers are in.

	$test_path = APPPATH . 'controllers';
	$test_folder = 'tests';

It runs all *.php files in "application/controllers/tests" folder.

PHPUnit shows all test file names and failed test names.
If more than one test fails, PHPUnit reports 1 failure, even if 100 fails occurres.

## Tutorial

If you are not familiar with PHPUnit/CIUnit, tutorial below may help you.

- How to use PHPUnit (CIUnit) with CodeIgniter 2.1.0 [http://d.hatena.ne.jp/Kenji_s/20120117/1326763908](http://d.hatena.ne.jp/Kenji_s/20120117/1326763908)
- Database Testing of CodeIgniter Application with PHPUnit (CIUnit) [http://d.hatena.ne.jp/Kenji_s/20120118/1326848578](http://d.hatena.ne.jp/Kenji_s/20120118/1326848578)
