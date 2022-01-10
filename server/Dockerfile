FROM php:7.4-fpm-alpine

WORKDIR /var/www
RUN apk update --no-cache \
&& apk add \
vim

RUN apk add libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql
 
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
 
COPY composer.json ./
COPY composer.lock ./
COPY entrypoint.sh ./

RUN chmod +x entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["./entrypoint.sh" ]

