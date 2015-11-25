#!/bin/bash

p=`pwd`

docker run --rm -v "$p":/usr/src/app stenote/bower install

docker run --rm -v "$p":/usr/src/app stenote/composer install --no-dev
