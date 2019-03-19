#!/bin/bash
#Development Setup
php artisan config:clear
composer dump-autoload
php artisan migrate:fresh
php artisan db:seed
php artisan key:generate
php artisan passport:install