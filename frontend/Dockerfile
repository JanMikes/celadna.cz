# NGINX Unit is discontinued and the official unit:*-php images are no longer rebuilt,
# so they stopped receiving PHP security releases. Build Unit on top of the official
# PHP image instead (based on https://github.com/nginx/unit/blob/1.34.2/pkg/docker/Dockerfile.php8.3,
# without njs/otel/debug builds) - every image rebuild picks up the latest PHP 8.3 patch release.
FROM php:8.3-cli-bookworm AS unit

ARG UNIT_VERSION=1.34.2

RUN set -ex \
    && savedAptMark="$(apt-mark showmanual)" \
    && apt-get update \
    && apt-get install --no-install-recommends --no-install-suggests -y \
         ca-certificates curl build-essential libssl-dev libpcre2-dev \
    && mkdir -p /usr/lib/unit/modules /usr/src/unit \
    && curl -fsSL "https://github.com/nginx/unit/archive/refs/tags/${UNIT_VERSION}.tar.gz" | tar -xz -C /usr/src/unit --strip-components=1 \
    && cd /usr/src/unit \
    && NCPU="$(getconf _NPROCESSORS_ONLN)" \
    && DEB_HOST_MULTIARCH="$(dpkg-architecture -q DEB_HOST_MULTIARCH)" \
    && CC_OPT="$(DEB_BUILD_MAINT_OPTIONS="hardening=+all,-pie" DEB_CFLAGS_MAINT_APPEND="-Wp,-D_FORTIFY_SOURCE=2 -fPIC" dpkg-buildflags --get CFLAGS)" \
    && LD_OPT="$(DEB_BUILD_MAINT_OPTIONS="hardening=+all,-pie" DEB_LDFLAGS_MAINT_APPEND="-Wl,--as-needed -pie" dpkg-buildflags --get LDFLAGS)" \
    && CONFIGURE_ARGS="--prefix=/usr \
                --statedir=/var/lib/unit \
                --control=unix:/var/run/control.unit.sock \
                --runstatedir=/var/run \
                --pid=/var/run/unit.pid \
                --logdir=/var/log \
                --log=/var/log/unit.log \
                --tmpdir=/var/tmp \
                --user=unit \
                --group=unit \
                --openssl \
                --libdir=/usr/lib/$DEB_HOST_MULTIARCH \
                --modulesdir=/usr/lib/unit/modules" \
    && ./configure $CONFIGURE_ARGS --cc-opt="$CC_OPT" --ld-opt="$LD_OPT" \
    && make -j $NCPU unitd \
    && install -pm755 build/sbin/unitd /usr/sbin/unitd \
    && make clean \
    && ./configure $CONFIGURE_ARGS --cc-opt="$CC_OPT" \
    && ./configure php \
    && make -j $NCPU php-install \
    && cd / \
    && rm -rf /usr/src/unit \
    && for f in /usr/sbin/unitd /usr/lib/unit/modules/*.unit.so; do \
        ldd $f | awk '/=>/{print $(NF-1)}' | while read n; do dpkg-query -S $n; done | sed 's/^\([^:]\+\):.*$/\1/' | sort | uniq >> /requirements.apt; \
       done \
    && apt-mark showmanual | xargs apt-mark auto > /dev/null \
    && { [ -z "$savedAptMark" ] || apt-mark manual $savedAptMark; } \
    && ldconfig \
    && mkdir -p /var/lib/unit/ /docker-entrypoint.d/ \
    && groupadd --gid 999 unit \
    && useradd --uid 999 --gid unit --no-create-home --home /nonexistent --comment "unit user" --shell /bin/false unit \
    && apt-get install --no-install-recommends --no-install-suggests -y curl $(cat /requirements.apt) \
    && apt-get purge -y --auto-remove build-essential \
    && rm -rf /var/lib/apt/lists/* /requirements.apt \
    && ln -sf /dev/stderr /var/log/unit.log

COPY .docker/docker-entrypoint.sh /usr/local/bin/

STOPSIGNAL SIGTERM

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["unitd", "--no-daemon", "--control", "unix:/var/run/control.unit.sock"]


FROM unit AS dev

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
