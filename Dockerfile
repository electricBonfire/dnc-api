FROM php:apache

RUN apt-get update -y && apt-get upgrade -y

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
