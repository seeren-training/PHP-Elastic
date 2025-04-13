# syntax=docker/dockerfile:1

FROM php:8.3-apache as final

RUN apt-get update -y
RUN apt-get install zip unzip zip
RUN docker-php-ext-install pdo pdo_mysql
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN a2enmod rewrite
RUN chown -R www-data:www-data /var/www/
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN --mount=type=bind,source=composer.json,target=composer.json \
--mount=type=bind,source=composer.lock,target=composer.lock \
--mount=type=cache,target=/tmp/cache \
composer install --no-dev --no-interaction

COPY ./.docker/vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

USER www-data
