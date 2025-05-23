#!/bin/sh

# Run Laravel migrations automatically
php artisan migrate --force

# Then start the Laravel built-in server
php artisan serve --host=0.0.0.0 --port=8080