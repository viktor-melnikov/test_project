#!/usr/bin/env bash

. ./.env

echo "Environment is '$APP_ENV' ..."

if ! [[ $APP_ENV =~ ^(local|development)$ ]]; then
    echo "CRITICAL! Use only with 'local' or 'development' environment."
    exit 1
fi

echo "WARNING! Database will be cleared! I run BasicSeeder"
# for Ctrl+C, if was random run.
sleep 3

rm database/database.sqlite
touch database/database.sqlite
chmod -R 777 database/
php artisan migrate
php artisan db:seed