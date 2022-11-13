FROM nginx:1.21.4

# The default www-data user id in this image is 82
ARG UID=82

ENV NGINX_VERSION=1.21.4

ENV PHP_FPM_HOST=php-fpm
ENV PHP_FPM_PORT=9000
ENV PORT=80

USER root

RUN apt-get update && apt-get install -y --no-install-recommends \
    wget \
    build-essential \
    libpcre3 \
    libpcre3-dev \
    zlib1g \
    zlib1g-dev && \
    apt-get clean

RUN find / -ignore_readdir_race -group www-data -exec chgrp -vh $UID {} \; && \
    find / -ignore_readdir_race -user www-data -exec chown -h $UID {} \; && \
    usermod -u $UID www-data && \
    groupmod -g $UID www-data

RUN cd /tmp && wget http://nginx.org/download/nginx-$NGINX_VERSION.tar.gz && \
    tar -zxvf nginx-$NGINX_VERSION.tar.gz && mv nginx-$NGINX_VERSION nginx && rm nginx-$NGINX_VERSION.tar.gz

RUN cd /tmp/nginx && ./configure \
    --sbin-path=/usr/local/sbin \
    --conf-path=/etc/nginx/nginx.conf \
    --error-log-path=/var/log/nginx/error.log \
    --http-log-path=/var/log/nginx/access.log \
    --user=www-data \
    --group=www-data \
    --with-http_gzip_static_module \
    --with-http_realip_module \
    --without-mail_pop3_module \
    --without-mail_imap_module \
    --without-mail_smtp_module && \
    make && make install && \
    rm -r /tmp/nginx

RUN apt-get autoremove

RUN mkdir -p /etc/nginx/conf.d && \
    chown -R www-data:www-data /etc/nginx/conf.d && \
    chmod -R 775 /etc/nginx/conf.d && \
    rm /etc/nginx/conf.d/*

RUN touch /run/nginx.pid /var/log/nginx/error.log /var/log/nginx/access.log && \
    chown www-data:www-data /run/nginx.pid /var/log/nginx/error.log /var/log/nginx/access.log

RUN mkdir -p /app && chown -R www-data:www-data /app

COPY --chown=www-data:www-data docker/nginx/ /etc/nginx/

USER www-data
