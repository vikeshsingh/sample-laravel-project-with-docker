FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libjpeg-dev libfreetype6-dev zip unzip \
    libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mbstring pdo pdo_mysql zip exif pcntl bcmath

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# (optional for production only – for dev we use volumes)
# COPY . /var/www/html

# Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html


# CMD ["php-fpm"]
# Copy entrypoint.sh from context root into container
COPY /docker/entrypoint.sh /usr/local/bin/entrypoint.sh

# Make it executable
RUN chmod +x /usr/local/bin/entrypoint.sh

# Set as entrypoint
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

EXPOSE 9000