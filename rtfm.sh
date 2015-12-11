#!/bin/bash

set -e

sudo npm install apidoc -g

apidoc -i app/Http/Controllers/ -o public/docs/
