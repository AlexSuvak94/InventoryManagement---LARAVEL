# 1. Bazna PHP slika sa potrebnim ekstenzijama
FROM php:8.2-cli

# 2. Instaliraj sistemske pakete
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libsqlite3-dev \
    unzip \
    git \
    curl \
    sqlite3 \
    && docker-php-ext-install zip pdo pdo_sqlite

# 3. Instaliraj Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Kreiraj radni direktorijum
WORKDIR /app

# 5. Kopiraj fajlove
COPY . .

# 6. Napravi .env fajl
RUN cp .env.example .env

# 7. Instaliraj Laravel dependencije
RUN composer install --no-interaction --optimize-autoloader

# 8. Generiši aplikacijski ključ
RUN php artisan key:generate

# 9. Migracije (opciono, ako koristiš bazu)
# RUN php artisan migrate --force

# 10. Laravel mora da sluša na 0.0.0.0:8080 na Renderu
EXPOSE 8080

# 11. Startuj aplikaciju
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]