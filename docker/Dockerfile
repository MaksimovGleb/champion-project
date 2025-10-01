# --- Этап 1: Composer ---
FROM php:8.2-cli AS composer_build
WORKDIR /app

# Устанавливаем зависимости для composer и расширений PHP
RUN apt-get update && apt-get install -y \
    unzip git curl libzip-dev libonig-dev libpng-dev libjpeg-dev libfreetype6-dev zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip mbstring pdo pdo_mysql exif

# Ставим composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# Ставим PHP-зависимости
COPY ../composer.json ./
COPY composer.lock* ./

RUN if [ -f composer.lock ]; then \
      composer install --no-dev --no-scripts --no-interaction --prefer-dist; \
    else \
      composer update --no-dev --no-scripts --no-interaction --prefer-dist; \
    fi

COPY .. .
RUN composer dump-autoload --optimize


# --- Этап 2: Node.js (сборка фронта) ---
FROM node:20 AS node_build
WORKDIR /app
COPY ../package.json package-lock.json webpack.mix.js ./
RUN npm ci
COPY .. .
RUN npm run prod
RUN ls -la


# --- Этап 3: финальный образ ---
FROM php:8.2-fpm AS app
WORKDIR /var/www/html

# Устанавливаем необходимые расширения PHP
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libonig-dev libzip-dev libpng-dev libjpeg-dev libfreetype6-dev zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mbstring zip exif

# Копируем Laravel (с уже установленными зависимостями и собранным фронтом)
COPY --from=composer_build / /var/www/html
COPY --from=node_build /app/public /var/www/html/public


# Даем права на storage и cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
