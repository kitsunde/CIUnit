#!/bin/sh

# CIUnit install script
# 2011/09/05  Kenji Suzuki

if [ $# -eq 0 ]; then
    echo " usage: $0 CI_Project_Path"
    exit;
fi

cwd=`pwd`
ci_path="$cwd/$1"
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
sed -e "s/^\$db\['default'\]\['database'\] = '';/\$db['default']['database'] = 'ciunit_test';/" database.php > database.php.$$
mv database.php.$$ database.php

cwd=`pwd`
echo "$cwd/database.php created"

