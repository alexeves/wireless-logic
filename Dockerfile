FROM php:8.1.15-fpm-alpine

COPY . /app
WORKDIR /app

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
