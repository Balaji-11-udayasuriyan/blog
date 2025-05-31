# Use PHP base image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install PHP extensions and system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    unzip \
    git \
    curl \
    zip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application code
COPY . .

# Install PHP dependencies
# RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# # Install Filament Admin Panel
# RUN composer require filament/filament"^3.3"

# Optional: publish Filament assets (skip if using SPA only)
# RUN php artisan filament:install

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

EXPOSE 9000
CMD ["php-fpm"]
