FROM php:8.5-cli

RUN apt-get update && apt-get install -y libssl-dev unzip pkg-config && pecl install mongodb && docker-php-ext-enable mongodb

RUN docker-php-ext-install sockets

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer