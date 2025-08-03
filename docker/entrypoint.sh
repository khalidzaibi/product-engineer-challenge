#!/bin/bash

# Wait for MySQL to be ready
until nc -z -v -w30 db 3306
do
  echo "Waiting for MySQL..."
  sleep 5
done

# Install PHP dependencies
if [ ! -d "vendor" ]; then
  echo "Running composer install..."
  composer install --no-interaction --prefer-dist
fi

# Install JS dependencies
if [ -f "package.json" ] && [ ! -d "node_modules" ]; then
  echo "Running npm install..."
  npm install
fi

# Run Laravel migrations
php artisan migrate --force

# Seed the database
if [ -f "database/seeders/DatabaseSeeder.php" ]; then
  echo "Running database seeder..."
  php artisan migrate:fresh --seed --force
fi

# Run PHP-FPM
exec php-fpm
