#!/bin/sh
composer install -d /var/www/html --no-plugins --no-scripts --no-dev --optimize-autoloader
exec apache2-foreground