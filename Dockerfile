FROM php:8.3-cli

RUN apt-get update && apt-get install -y --no-install-recommends \
        libzip-dev \
        libonig-dev \
    && docker-php-ext-install pdo_mysql bcmath zip mbstring \
    && rm -rf /var/lib/apt/lists/*

# `php artisan serve` runs the built-in dev server under the CLI SAPI, which has OPcache disabled
# by default (opcache.enable only covers non-CLI SAPIs). Without this, every request recompiles
# the whole framework from source on this project's slow Docker-bind-mounted filesystem — multiple
# seconds per request instead of milliseconds.
RUN echo "opcache.enable_cli=1" > /usr/local/etc/php/conf.d/opcache-cli.ini

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

EXPOSE 8000
