#!/bin/bash
set -euo pipefail

: "${PORT:=8080}"

# Render templates with current PORT
if [ -f /etc/nginx/templates/default.conf.template ]; then
    envsubst '${PORT}' < /etc/nginx/templates/default.conf.template > /etc/nginx/conf.d/default.conf
fi

# Ensure writable directories for Laravel
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Optionally run database migrations when requested
if [[ "${RUN_MIGRATIONS:-false}" =~ ^(1|true|TRUE|yes|YES)$ ]]; then
    php artisan migrate --force --no-ansi || true
fi

exec "$@"

