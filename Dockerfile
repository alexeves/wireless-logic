FROM php:8.1.15-fpm-alpine

COPY . /app
WORKDIR /app

RUN apk --update upgrade \
	&& apk add --no-cache \
		bash

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions \
        xdebug

COPY docker/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN mv /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
