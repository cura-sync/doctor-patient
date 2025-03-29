#!/bin/bash

# Stop script execution if any command fails
set -e

echo "Starting Laravel project setup..."

# Navigate to the src directory
cd src

# Step 1: Remove existing `vendor` and `node_modules` folders if they exist
if [ -d "vendor" ]; then
    echo "Removing existing vendor folder..."
    rm -rf vendor
fi

if [ -d "node_modules" ]; then
    echo "Removing existing node_modules folder..."
    rm -rf node_modules
fi

# Step 2: Clear cached files
echo "Clearing Laravel caches..."
php artisan cache:clear || echo "Cache already clear"
php artisan config:clear || echo "Config already clear"
php artisan route:clear || echo "Routes already clear"
php artisan view:clear || echo "Views already clear"

# Step 3: Install composer dependencies
echo "Installing composer dependencies..."
composer install --prefer-dist --no-interaction

# Step 4: Install Node.js dependencies
echo "Installing Node.js dependencies..."
npm install

# Step 5: Run database migrations and seeders
echo "Running migrations..."
php artisan migrate --force

echo "Running database seeders..."
php artisan db:seed --force

# Step 6: Generate application key
echo "Generating application key..."
php artisan key:generate --force

# Step 7: Build frontend assets
echo "Building frontend assets..."
npm run build

# Step 8: Set correct permissions for storage and cache
echo "Setting permissions for storage and cache..."
chmod -R 775 storage bootstrap/cache

# Step 9: Final setup message
echo "Laravel project setup completed successfully!"