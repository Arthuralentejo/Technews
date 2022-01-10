#!/bin/sh
php-fpm
composer install -d /var/www/html --no-plugins --no-scripts --no-dev --optimize-autoloader