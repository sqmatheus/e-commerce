FROM php:8.5-cli

RUN pecl install mongodb && docker-php-ext-enable mongodb

RUN docker-php-ext-install sockets