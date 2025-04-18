#!/bin/bash
set -e # Exit immediately if any command fails

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install && npm run build

# Generate app key
php artisan key:generate --force

# Run migrations FIRST
php artisan migrate --force

# Then run seeds (with retry logic)
max_retries=3
count=0
until php artisan db:seed --force; do
    count=$((count+1))
    if [ $count -ge $max_retries ]; then
        echo "Seeding failed after $max_retries attempts"
        exit 1
    fi
    sleep 2
    echo "Retrying seeding ($count/$max_retries)..."
done

# Create storage link
php artisan storage:link

echo "Seeding completed successfully"