FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libsqlite3-dev \
    nodejs npm \
    && docker-php-ext-install pdo_sqlite mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm install && npm run build

RUN chmod -R 775 storage bootstrap/cache

EXPOSE 10000

# Endurecimiento de PHP: no revelar la versión (X-Powered-By) ni mostrar errores en pantalla
RUN { echo "expose_php=Off"; echo "display_errors=Off"; echo "log_errors=On"; echo "error_log=/dev/stderr"; } > /usr/local/etc/php/conf.d/zz-seguridad.ini

CMD ["./start.sh"]
