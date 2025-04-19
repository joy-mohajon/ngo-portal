#!/bin/bash

# =============================================
# 1. INSTALL DEPENDENCIES
# =============================================
echo "➔ Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "➔ Installing Node.js dependencies..."
npm ci --no-audit --prefer-offline
npm run build

# =============================================
# 2. DATABASE SETUP
# =============================================

# Wait for MySQL to be truly ready (up to 2 mins)

# Generate fresh .env if missing
if [ ! -f .env ]; then
    echo "➔ Creating .env file..."
    cp .env.example .env
fi

# Generate app key if missing
if ! grep -q '^APP_KEY=' .env; then
    echo "➔ Generating application key..."
    php artisan key:generate --force
fi

# =============================================
# 3. OPTIMIZED MIGRATION & SEEDING
# =============================================

# Run migrations (without fresh to prevent data loss)
echo "➔ Running migrations..."
php artisan migrate --force
php artisan db:seed --class=UserSeeder --force

# Seed in phases with progress tracking


# Seed larger tables with individual error handling
# seed_tables ProjectsTableSeeder || true  # Continue even if fails
# seed_tables TrainingsTableSeeder || true

# =============================================
# 4. FINAL OPTIMIZATION
# =============================================
echo "➔ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "➔ Creating storage symlink..."
php artisan storage:link

echo "✅ Deployment completed successfully"
