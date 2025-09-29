# docker/Dockerfile
FROM php:8.2-fpm-alpine AS base

# System deps
RUN apk add --no-cache bash git zip unzip icu-dev oniguruma-dev libpng-dev libjpeg-turbo-dev freetype-dev libzip-dev

# PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) pdo_mysql gd bcmath exif zip intl pcntl

# Redis PHP ext (requires build tools)
RUN set -eux; \
    apk add --no-cache --virtual .build-deps $PHPIZE_DEPS; \
    pecl install redis; \
    docker-php-ext-enable redis; \
    apk del .build-deps

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 1) install PHP deps
FROM base AS vendor
COPY composer.json composer.lock ./
ENV COMPOSER_ALLOW_SUPERUSER=1 COMPOSER_MEMORY_LIMIT=-1
RUN composer install --no-dev --no-scripts --prefer-dist --no-interaction --no-progress --optimize-autoloader || \
    composer install --no-dev --no-scripts --prefer-dist --no-interaction --no-progress --optimize-autoloader

# 2) build frontend
FROM node:18-alpine AS frontend
WORKDIR /app
COPY package.json package-lock.json* yarn.lock* .npmrc* ./
RUN if [ -f package-lock.json ]; then npm ci; else npm install; fi
COPY webpack.mix.js ./webpack.mix.js
COPY resources ./resources
RUN npm run production || npm run prod

# 3) final
FROM base AS app
ENV APP_ENV=production
WORKDIR /var/www/html

# Код и конфиги
COPY . ./
# PHP vendor
COPY --from=vendor /var/www/html/vendor ./vendor
# Собранные ассеты (Laravel Mix кладет в public/*)
COPY --from=frontend /app/public ./public

# Права
RUN addgroup -g 1000 www && adduser -G www -D -g "" -u 1000 www \
 && chown -R www:www storage bootstrap/cache public || true
USER www

CMD ["php-fpm"]