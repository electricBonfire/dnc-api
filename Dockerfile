FROM php:apache

RUN apt-get update -y && apt-get upgrade -y
RUN apt install -y git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://get.symfony.com/cli/installer | bash