FROM php:5.6-fpm

COPY ./www/ /workdir
RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data
RUN mkdir -p /workdir/uploads && chmod 777 /workdir/uploads
RUN docker-php-ext-install mysqli

WORKDIR /workdir