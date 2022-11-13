#!/bin/bash

__file_exists() {
    test -f "$1"
}

_wait-for-site-to-be-ready() {
    echo "To prevent the docker filesystem from bottle-necking the site locally, we sync content from the mount directory to the web root. This might take some time: ~10m"
    echo "The start time is: $(date +%H:%M:%S)"
    i=0
    until curl -s http://localhost | grep "Detroit Axle" || curl -sI http://localhost | grep "wp-admin/install.php"
    do
        i=$(($i+1))
        if [ $(($i)) == 1 ]; then
            echo -en '\r';
            echo -en '\r\033[KWaiting for site to be ready.'
        fi
        if [ $(($i)) == 2 ]; then
            echo -en '\r\033[KWaiting for site to be ready..'
        fi
        if [ $(($i)) == 3 ]; then
            echo -en '\r\033[KWaiting for site to be ready...'
            i=0
        fi
        sleep 10
    done
}

if __file_exists "./.env"; then
    export UID
    docker-compose pull || exit 1
    docker-compose build --parallel || exit 1
    # docker-compose run --rm node bash -c "cd wp-content/themes/detroit-axle && npm install --production=false" || exit 1
    docker-compose run --rm composer install -o || exit 1
    docker-compose up -d || { docker-compose down; exit 1; }
    _wait-for-site-to-be-ready || { docker-compose down; exit 1; }
    docker-compose logs -f || { docker-compose down; exit 1; }
else 
    echo "Please create the .env file before starting containers. See the README for more help"
    exit 1
fi
