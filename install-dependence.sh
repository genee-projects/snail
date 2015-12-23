#!/bin/bash

p=`pwd`

# install 3rd stylesheet fiels and  scripts
#docker run --rm -v "$p":/usr/src/app stenote/bower install

# build ace
#docker run --rm -v "$p":/usr/src/app node:latest bash -c "cd /usr/src/app/public/asserts/3rd/ace/ && npm install"

# make something
#docker run --rm -v "$p":/usr/src/app node:latest node /usr/src/app/public/asserts/3rd/ace/Makefile.dryice.js

# install php dependency
docker run --rm -v "$p":/usr/src/app stenote/composer install --no-dev
