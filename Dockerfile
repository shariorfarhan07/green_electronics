FROM php:7.4-cli

RUN apt-get update && apt-get install -y --no-install-recommends \
        libzip-dev \
        libonig-dev \
    && docker-php-ext-install pdo_mysql bcmath zip mbstring \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

EXPOSE 8000
