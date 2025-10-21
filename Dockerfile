# Use the official PHP image with Apache (includes web server)
FROM php:8.2-apache

# Enable required PHP extensions for Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Install system dependencies and Composer
RUN apt-get update && apt-get install -y zip unzip git curl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy project files
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Expose port 80 for Apache
EXPOSE 80

# Run Laravel with built-in PHP server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
