#!/bin/bash

export UID
docker-compose run --rm --entrypoint= wordpress wp --path="/app/wordpress/" $@
