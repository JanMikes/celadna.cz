FROM docker.io/nginx/unit:1.26.1-php8.1 as dev

ENV COMPOSER_MEMORY_LIMIT=-1

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Very convenient PHP extensions installer: https://github.com/mlocati/docker-php-extension-installer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN apt-get update && apt-get install -y \
    git \
    zip

RUN install-php-extensions \
    intl \
    zip \
    xdebug

COPY .docker/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY .docker/config.json /docker-entrypoint.d/config.json

WORKDIR /www


FROM dev as prod

ENV APP_ENV="prod"
ENV APP_DEBUG=0

# Unload xdebug extension by deleting config
RUN rm /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY composer.json composer.lock symfony.lock ./

RUN composer install --no-interaction --no-scripts

COPY . .

RUN composer install --no-interaction
