FROM php:8.5-cli

RUN apt-get update && apt-get install -y libssl-dev pkg-config && pecl install mongodb && docker-php-ext-enable mongodb

RUN docker-php-ext-install sockets