#!/bin/bash
IP=$(ifconfig eth0 2>/dev/null|awk '/inet / {print $2}')


composer install --prefer-dist
php artisan db:create
php artisan migrate
php artisan module:migrate
php artisan db:seed
php artisan db:seed --class=AdminSeeder
php artisan key:generate 

