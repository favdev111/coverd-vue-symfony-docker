#!/usr/bin/env bash

rm .env.local
rm .env.local.php
cp .env .env.local

# Replace db line with dockerized db
DB_URL="DATABASE_URL=postgres://postgres:coverd@db/coverd?charset=UTF-8"
if [[ "$OSTYPE" == "darwin"* ]]; then
    # MacOS `sed` needs a zero-length extension
    sed -i '' -e "s~^DATABASE_URL=.*~$DB_URL~g" .env.local
else
    sed -i -e "s~^DATABASE_URL=.*~$DB_URL~g" .env.local
fi

# Ensure fresh install of docker containers
./docker/down.sh -v --rmi all --remove-orphans
./docker/up.sh --detach

./docker/app ./bin/php_install.sh
./docker/app ./bin/js_install.sh

docker-compose -f docker-compose.yml -f docker-compose.unison.yml stop
