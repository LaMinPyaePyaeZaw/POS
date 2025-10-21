# Use the official PHP image with required extensions
FROM php:8.2-apache

# Enable necessary extensions for Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Copy project files
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Install composer
RUN apt-get update && apt-get install -y zip unzip git \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependencies
RUN composer install --optimize-autoloader --no-dev

# Expose port
EXPOSE 80

# Run Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
