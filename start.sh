#!/bin/sh
set -e
cd /var/www/html

PORT="${PORT:-10000}"

# Apache escucha en el puerto que asigna Render
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Base SQLite efímera: se crea, migra y siembra en cada arranque
touch database/database.sqlite
php artisan config:clear
php artisan migrate --force --seed

# Apache corre como www-data: debe poder escribir en la base, las sesiones y los logs
chown -R www-data:www-data storage bootstrap/cache database

exec apache2-foreground
