# CIUnit Foostack

### Folder structure:
- application/third_party/CIUnit/bootstrap_phpunit.php (Application and System Folder)
- tests/phpunit.xml (Optional: only edit if you want to move bootstrap_phpunit.php)

## Install:

### Install by shell script:

	tools/install.sh CI2_Project_Path [DB_Name [DB_User [DB_Passwd [DB_host]]]]

### Install manually:

	cp -R ciunit/application CI2_Project_Path/
	cp -R ciunit/tests CI2_Project_Path/

create application/config/testing/database.php for database testing.
Database name must end with "_test".

If you use MY_Loader, MY_Output, MY_Session, please change the parent classes below:

- application/third_party/CIUnit/core/CIU_*.php
- application/third_party/CIUnit/libraries/CIU_*.php

## Run Tests:

Go into the `/tests` directory as normal with phpunit and run.

	phpunit
