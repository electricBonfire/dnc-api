FROM php:apache

RUN apt-get update -y && apt-get upgrade -y && apt install -y \
        git \
        zip \
        unzip \
        zlib1g-dev \
        libicu-dev \
        g++ \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

COPY ./docker/vhost.conf /etc/apache2/sites-available/000-default.conf
