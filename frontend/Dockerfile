FROM unit:1.32.1-php8.3 AS dev

ENV COMPOSER_MEMORY_LIMIT=-1
ENV COMPOSER_ALLOW_SUPERUSER=1

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


FROM dev AS prod-composer

ENV APP_ENV="prod"
ENV APP_DEBUG=0

# Unload xdebug extension by deleting config
RUN rm /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN mkdir -p /www/var/cache && chmod -R 777 /www/var

# Intentionally split into multiple steps to leverage docker layer caching
COPY composer.json composer.lock symfony.lock ./

RUN composer install --no-interaction --no-scripts


FROM node:14 AS js-builder

WORKDIR /build

# We need /vendor here
COPY --from=prod-composer /www .

# Install npm packages
COPY package.json yarn.lock webpack.config.js ./
RUN yarn install

# Production yarn build
COPY ./assets ./assets

RUN yarn run build


FROM prod-composer AS prod

# Copy js build
COPY --from=js-builder /build .

# Copy application source code
COPY . .

# Need to run again to trigger scripts with application code present
RUN composer install --no-interaction
