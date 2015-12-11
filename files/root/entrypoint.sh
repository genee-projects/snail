#!/bin/bash

set -e

chown -R www-data:www-data /var/www /var/log/php5
chown -R mysql:mysql /var/lib/mysql

/etc/init.d/postfix start

exec /usr/bin/supervisord --nodaemon -c /etc/supervisor/supervisord.conf
