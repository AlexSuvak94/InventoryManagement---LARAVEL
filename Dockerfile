# 1. Base PHP image with required extensions
FROM php:8.2-cli

# 2. Install system packages including PostgreSQL dev libs
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libsqlite3-dev \
    libpq-dev \
    unzip \
    git \
    curl \
    sqlite3 \
    && docker-php-ext-install zip pdo pdo_sqlite pdo_pgsql

# 3. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Set working directory
WORKDIR /app

# 5. Copy project files
COPY . .

# 6. Install Laravel dependencies
RUN composer install --no-interaction --optimize-autoloader

# 7. Expose port 8080 (required for Render)
EXPOSE 8080

# 8. Run Laravel's built-in server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]