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

# 7. Copy and set entrypoint script
COPY entrypoint.sh /app/entrypoint.sh

# (Optional) Make sure entrypoint script is executable (mostly for Linux hosts)
RUN chmod +x /app/entrypoint.sh

# 8. Expose port 8080 (required for Render)
EXPOSE 8080

# 9. Use entrypoint script to run migrations and then start server
ENTRYPOINT ["sh", "/app/entrypoint.sh"]