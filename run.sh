#!/bin/bash

set -e

docker-compose up -d

sleep 30

docker exec -it backup-monitor mysql -h 127.0.0.1 -e 'create database monitor'

docker exec -it backup-monitor php artisan migrate --force

docker exec -it backup-monitor php artisan db:seed --class=clients --force
