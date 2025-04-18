#!/bin/bash
composer install --no-dev --optimize-autoloader
npm install && npm run prod  # Compile Tailwind
php artisan key:generate --force
php artisan migrate --force
php artisan db:seed --force  # Insert seed data
php artisan storage:link