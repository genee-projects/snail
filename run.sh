#!/bin/bash

set -e

docker-compose up -d

sleep 30

docker exec -it crm mysql -h 127.0.0.1 -e 'create database crm'

docker exec -it crm php artisan migrate --force

docker exec -it crm php artisan db:seed --class=InitProducts --force
docker exec -it crm php artisan db:seed --class=InitProductsModules --force
docker exec -it crm php artisan db:seed --class=InitServerServices --force
