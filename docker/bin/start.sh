#!/bin/sh

while ! mysqladmin ping -h"$DB_HOST" --silent; do
    sleep 1
done

wp --path="/app/wordpress/" dbi migrate --setup
wp --path="/app/wordpress/" dbi migrate
wp --path="/app/wordpress/" rewrite flush

if [ "$ENVIRONMENT" = "local" ]; then
    /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisor.conf
else
    php-fpm
fi
