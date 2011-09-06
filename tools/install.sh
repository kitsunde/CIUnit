#!/bin/sh

# CIUnit install script
# 2011/09/05  Kenji Suzuki

if [ $# -eq 0 ]; then
    echo " usage: $0 CI_Project_Path [DB_Name [DB_User [DB_Passwd [DB_host]]]]"
    exit;
fi

ci_path="$1"
check=`echo "$ci_path" | cut -c 1`

if [ "$check" != "/" ]; then
    cwd=`pwd`
    ci_path="$cwd/$1"
fi

cd `dirname $0`

# install CIUnit
cd ..

if [ ! -d application ]; then
    echo "application folder not found!"
    exit;
fi
if [ ! -d tests ]; then
    echo "tests folder not found!"
    exit;
fi
if [ ! -d "$ci_path" ]; then
    echo "$ci_path folder not found!"
    exit;
fi

cp -R application "$ci_path"
cp -R tests "$ci_path"

# create testing database.php
cd "$ci_path"

if [ ! -f application/config/database.php ]; then
    echo "application/config/database.php is not found!"
    exit;
fi

mkdir -p application/config/testing
cp application/config/database.php application/config/testing/
cd application/config/testing

if [ $# -ge 2 ]; then
    db_name="$2"
else
    db_name="ciunit_test"
fi

sed -e "s/^\$db\['default'\]\['database'\] = '';/\$db['default']['database'] = '$db_name';/" database.php > database.php.$$
mv database.php.$$ database.php

if [ $# -ge 3 ]; then
    db_user="$3"
    sed -e "s/^\$db\['default'\]\['username'\] = '';/\$db['default']['username'] = '$db_user';/" database.php > database.php.$$
    mv database.php.$$ database.php
fi

if [ $# -ge 4 ]; then
    db_passwd="$4"
    sed -e "s/^\$db\['default'\]\['password'\] = '';/\$db['default']['password'] = '$db_passwd';/" database.php > database.php.$$
    mv database.php.$$ database.php
fi

if [ $# -ge 5 ]; then
    db_host="$5"
    sed -e "s/^\$db\['default'\]\['hostname'\] = 'localhost';/\$db['default']['hostname'] = '$db_host';/" database.php > database.php.$$
    mv database.php.$$ database.php
fi

cwd=`pwd`
echo "$cwd/database.php created"

