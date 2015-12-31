#!/bin/bash

p=`pwd`

# install php dependency
docker run --rm -v "$p":/usr/src/app stenote/composer install
