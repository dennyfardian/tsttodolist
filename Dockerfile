FROM php:7.1.33-cli

RUN apt-get update && apt-get install -y

RUN docker-php-ext-install mysqli pdo_mysql

RUN mkdir /app \
 && mkdir /app/to-do-list \
 && mkdir /app/to-do-list/www

COPY . /app/to-do-list/www/

RUN cp -r /app/to-do-list/www/* /var/www/html/.