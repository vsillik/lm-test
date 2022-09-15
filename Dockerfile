FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
        libzip-dev \
        libpq-dev \
        zip \
  && docker-php-ext-install zip \
        pdo \
        pdo_pgsql \
        pgsql

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer