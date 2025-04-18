#!/bin/bash
set -e # Exit immediately if any command fails

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install && npm run build

# Generate app key (if missing)
[ -f .env ] || cp .env.example .env
grep -q '^APP_KEY=' .env || php artisan key:generate --force

# Fresh migrate + seed with retry logic
max_retries=3
count=0

until php artisan migrate:fresh --seed --force; do
    count=$((count+1))
    if [ $count -ge $max_retries ]; then
        echo "Migration and seeding failed after $max_retries attempts"
        exit 1
    fi
    sleep 5
    echo "Retrying migrate:fresh --seed ($count/$max_retries)..."
done

# Create storage link
php artisan storage:link

echo "Database refreshed and seeded successfully"