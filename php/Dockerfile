FROM composer:lts as composer

FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql zip

RUN a2enmod rewrite

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html