FROM php:8.4-rc-cli

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

CMD php -S 0.0.0.0:8000 -t public