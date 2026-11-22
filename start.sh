#!/usr/bin/env bash
set -e

mkdir -p database
touch database/database.sqlite

php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan migrate --force
php artisan db:seed --force

php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
