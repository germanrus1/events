ARG BUILD_ENV=prod

FROM php:8.1.4-fpm-alpine3.14 as build_common
RUN set -ex \
    && apk add --no-cache --update \
        autoconf \
        zip \
        git \
        libpq \
        procps \
        libpng-dev \
        zlib-dev \
        libzip-dev \
        gmp-dev \
        wget \
        curl \
        curl-dev \
        postgresql-libs \
        postgresql-dev \
        g++ \
        make \
        bash \
        openssh-client \
        libwebp-dev \
        libjpeg-turbo-dev \
        freetype-dev \
    && rm -rf /var/cache/apk/* \
    && docker-php-ext-configure gd --with-freetype --with-webp --with-jpeg \
    && docker-php-ext-configure zip \
    && docker-php-ext-install \
      opcache \
      pgsql \
      pdo_pgsql \
      gd \
      zip \
      sockets \
      bcmath \
      gmp \
    && COMPOSER_ALLOW_SUPERUSER=1 \
    curl -sS https://getcomposer.org/installer | php -- \
           --filename=composer \
           --install-dir=/usr/local/bin

ENV MUSL_LOCALE_DEPS cmake make musl-dev gcc gettext-dev libintl
ENV MUSL_LOCPATH /usr/share/i18n/locales/musl

RUN apk add --no-cache \
    $MUSL_LOCALE_DEPS \
    && wget https://gitlab.com/rilian-la-te/musl-locales/-/archive/master/musl-locales-master.zip \
    && unzip musl-locales-master.zip \
      && cd musl-locales-master \
      && cmake -DLOCALE_PROFILE=OFF -D CMAKE_INSTALL_PREFIX:PATH=/usr . && make && make install \
      && cd .. && rm -r musl-locales-master

RUN docker-php-ext-install exif

FROM build_common as build_prod
ONBUILD RUN echo "Build for prod"
ONBUILD COPY . /app
ONBUILD WORKDIR /app
ONBUILD COPY ./deployment/app/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
ONBUILD COPY ./deployment/app/php.ini /usr/local/etc/php/conf.d/php.ini
ONBUILD RUN composer install --no-dev

FROM build_common as build_develop
ONBUILD RUN echo "Build for develop"
ONBUILD COPY deployment/app/develop-docker-php-entrypoint.sh /usr/local/bin/docker-php-entrypoint
ONBUILD RUN chmod +x /usr/local/bin/docker-php-entrypoint

FROM build_${BUILD_ENV}
WORKDIR /app
