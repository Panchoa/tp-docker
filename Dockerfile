FROM php:5-apache

COPY ./www/ /workdir
RUN mkdir -p /workdir/uploads && chmod 777 /workdir/uploads
RUN docker-php-ext-install mysqli

EXPOSE 80

WORKDIR /workdir