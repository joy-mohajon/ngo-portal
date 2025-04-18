#!/bin/bash
composer install --no-dev --optimize-autoloader
npm install # Compile Tailwind
php artisan key:generate --force
php artisan migrate --force
php artisan db:seed --force  # Insert seed data
php artisan storage:link