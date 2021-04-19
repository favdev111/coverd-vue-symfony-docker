#!/usr/bin/env bash

# php
composer install
bin/console cache:pool:clear cache.global_clearer
bin/console doctrine:schema:update --force

# js
yarn install
