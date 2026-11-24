FROM php:8.4-apache
WORKDIR /var/www/html

# Dependencias del sistema y extensiones de PHP (GD para DomPDF, ZIP para Composer)
RUN apt-get update && apt-get install -y --no-install-recommends \
        git unzip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

# Apache sirve solo la carpeta public/ (receta de la imagen oficial)
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Endurecimiento de Apache (debe ir DESPUÉS del bloque anterior)
COPY docker/apache-seguridad.conf /etc/apache2/conf-available/seguridad.conf
RUN a2enconf seguridad

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist

COPY . .

RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache database \
    && composer dump-autoload --optimize \
    && chown -R www-data:www-data storage bootstrap/cache database \
    && chmod +x start.sh

# Endurecimiento de PHP: no revelar la versión ni mostrar errores en pantalla
RUN { echo "expose_php=Off"; echo "display_errors=Off"; echo "log_errors=On"; } > /usr/local/etc/php/conf.d/zz-seguridad.ini

EXPOSE 10000
CMD ["sh", "start.sh"]