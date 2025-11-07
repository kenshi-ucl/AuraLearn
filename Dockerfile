# syntax=docker/dockerfile:1.6

## Composer dependencies stage
FROM composer:2 AS vendor
WORKDIR /app

# Only copy files needed for dependency resolution first
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

# Copy full application code (respecting .dockerignore) and install with scripts
COPY . .
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

## Frontend build stage (Vite)
FROM node:20-alpine AS frontend
WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build

## Production stage
FROM php:8.2-fpm-bullseye AS production

ENV PORT=8080 \
    APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stack

WORKDIR /var/www/html

# Install system packages, PHP extensions, nginx and supervisor
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        git \
        unzip \
        nginx \
        supervisor \
        libpq-dev \
        libzip-dev \
        libonig-dev \
        libicu-dev \
        libssl-dev \
        pkg-config \
        gettext-base \
        autoconf \
        make \
        g++ && \
    docker-php-ext-install \
        pdo_pgsql \
        pgsql \
        zip && \
    yes "" | pecl install redis && \
    docker-php-ext-enable redis && \
    rm -rf /var/lib/apt/lists/*

# Remove default nginx configs and prepare template directory
RUN rm -f /etc/nginx/sites-enabled/default /etc/nginx/conf.d/default.conf && \
    mkdir -p /etc/nginx/templates /run/php

# Copy application source with production dependencies
COPY --from=vendor /app /var/www/html

# Recreate runtime directories excluded from build context
RUN mkdir -p \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
    && touch storage/logs/laravel.log

# Copy compiled frontend assets
COPY --from=frontend /app/public/build ./public/build

# Copy runtime configuration files
COPY docker/nginx/default.conf /etc/nginx/templates/default.conf.template
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

# Ensure entrypoint is executable and fix permissions
RUN chmod +x /usr/local/bin/entrypoint.sh && \
    chown -R www-data:www-data storage bootstrap/cache

VOLUME ["/var/www/html/storage", "/var/www/html/bootstrap/cache"]

EXPOSE 8080

ENTRYPOINT ["entrypoint.sh"]
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

