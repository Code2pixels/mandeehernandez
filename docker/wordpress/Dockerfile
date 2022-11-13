FROM wordpress:5.8-php7.4-fpm

# The default www-data user id in this image is 82
ARG UID=82
ARG PHP_INI="zz-custom.ini"
ARG PHP_FPM_CONF="zz-local.conf"
ARG SUPERVISOR_CONF="supervisor.conf"

ENV PATH="/app/vendor/bin:${PATH}"
# https://github.com/wp-cli/wp-cli/issues/3840#issuecomment-318067057
ENV PAGER="more"
ENV ENVIRONMENT="local"
ENV OPCACHE_ENABLED=1

USER root

RUN rm -r /usr/src/wordpress/*
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN apt-get update && apt-get install -y --no-install-recommends \
    gettext \
    supervisor \
    mariadb-client \
    lsyncd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

RUN find / -ignore_readdir_race -group www-data -exec chgrp -vh $UID {} \; && \
    find / -ignore_readdir_race -user www-data -exec chown -h $UID {} \; && \
    usermod -u $UID www-data && \
    groupmod -g $UID www-data

RUN mkdir -p /etc/supervisor/conf.d /var/log/php-fpm && \
    chown -R www-data:www-data /etc/supervisor/conf.d /var/log/php-fpm && \
    chmod -R 775 /etc/supervisor/conf.d /var/log/php-fpm 

RUN touch /run/supervisord.pid /var/log/php-fpm/error.log /var/log/php-fpm/slow.log && \
    chown www-data:www-data /run/supervisord.pid /var/log/php-fpm/error.log /var/log/php-fpm/slow.log /usr/local/php/php/fpm/status.html

RUN mkdir -p /home/www-data/app /app/wordpress /home/www-data/app/wordpress/wp-content /home/www-data/app/wp-content/logs && \
    chown -R www-data:www-data /home/www-data/app /app

USER www-data

COPY /docker/bin/start.sh /usr/sbin

COPY --chown=www-data:www-data docker/wordpress/supervisor/${SUPERVISOR_CONF} /etc/supervisor/conf.d/supervisor.conf
COPY --chown=www-data:www-data docker/wordpress/php/conf.d/${PHP_INI} /usr/local/etc/php/conf.d/zz-custom.ini
COPY --chown=www-data:www-data docker/wordpress/php-fpm.d/${PHP_FPM_CONF} /usr/local/etc/php-fpm.d/zzz-custom.conf

WORKDIR /home/www-data/app

ENTRYPOINT /usr/sbin/start.sh
