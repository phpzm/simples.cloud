#!/bin/bash

__APP_HOME__='/var/html/www'

__APP_REPO__=$__APP_HOME__"/repo.git"

__APP_ROOT__=$__APP_HOME__"/staging"

if ! [ -t 0 ]; then
  read -a ref
fi

IFS='/' read -ra REF <<< "${ref[2]}"
branch="${REF[2]}"

if [ "master" == "$branch" ]; then
  echo 'master was pushed'
  __APP_ROOT__=$__APP_HOME__"/production"
fi

if [ "develop" == "$branch" ]; then
  echo 'develop was pushed'
fi

export GIT_DIR=$__APP_REPO__
export GIT_WORK_TREE=$__APP_ROOT__

cd $__APP_ROOT__

/usr/bin/git checkout -f $branch
/usr/local/bin/composer install
/usr/bin/php cli.php -uri=/migration

echo "done"