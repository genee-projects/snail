#!/bin/bash

p=`pwd`

# install php dependency
docker run --rm -v "$p":/usr/src/app stenote/composer install

rm composer.lock
docker run --rm -v "$p":/usr/src/app --entrypoint="/usr/bin/php" -t stenote/composer artisan optimize
