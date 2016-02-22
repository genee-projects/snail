#!/bin/bash

p=`pwd`

# install php dependency
docker run --rm -v "$p":/usr/src/app stenote/composer install

# 删除 composer.lock
rm composer.lock

# 重新 composer install
# laravel 的依赖貌似有个问题, 第一次 composer install 完成后, 会安装上多余的依赖, 删除 composer.lock 后重新 compsoer install 会删除那两个多余的依赖
docker run --rm -v "$p":/usr/src/app stenote/composer install

docker run --rm -v "$p":/usr/src/app --entrypoint="/usr/bin/php" -t stenote/composer artisan optimize
