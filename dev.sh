#!/bin/bash
#Development Setup
php artisan config:clear
composer install
npm install
npm run dev
composer dump-autoload
php artisan migrate:fresh --seed
php artisan key:generate
php artisan passport:install