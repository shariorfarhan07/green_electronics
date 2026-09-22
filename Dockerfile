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
#
# revalidate_freq matters just as much: with the default of 2s, OPcache re-stats every cached
# file on the first request after each 2s window. Stat-ing this project's ~8,600 vendor files
# costs ~7s on the Windows bind mount (~0.8ms per stat vs ~0.001ms native), which showed up as
# random 2-4s request spikes. Raising it to 60s keeps code changes picked up automatically while
# cutting the measured average request from ~2.1s to ~0.26s.
RUN printf "opcache.enable_cli=1\nopcache.revalidate_freq=60\n" > /usr/local/etc/php/conf.d/opcache-cli.ini

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

EXPOSE 8000
