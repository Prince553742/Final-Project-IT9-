FROM php:8.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev nodejs npm \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies and build assets
RUN npm install && npm run build

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

# Expose port
EXPOSE 10000

# Start Laravel
CMD php artisan config:cache && \
    php artisan route:cache && \
    php artisan migrate --force && \
    php -S 0.0.0.0:10000 -t public