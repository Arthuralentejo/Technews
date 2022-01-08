FROM php:7.4-apache

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

COPY composer.json ./
COPY composer.lock ./
COPY entrypoint.sh ./

RUN a2enmod rewrite && service apache2 restart
RUN chmod +x entrypoint.sh

EXPOSE 80

ENTRYPOINT [ "bash", "entrypoint.sh" ]
