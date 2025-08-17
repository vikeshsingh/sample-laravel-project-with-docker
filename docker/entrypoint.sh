#!/bin/sh
sleep 60
echo "Database is up - executing command"
# Run pending migrations before starting PHP-FPM
php artisan migrate --force

# Run PHP-FPM
exec php-fpm


