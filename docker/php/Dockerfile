FROM php:8.3-fpm-alpine

WORKDIR /var/www/api

RUN apk add --no-cache \
    $PHPIZE_DEPS \
    bash \
    postgresql-dev \
    zlib-dev \
    libzip-dev \
    git \
    openssh

RUN docker-php-ext-install pdo pdo_pgsql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN rm -rf /var/cache/apk/*

CMD ["php-fpm"]
