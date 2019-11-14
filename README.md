# DNC API

## Composer - The php package manager

### What is a package manager?

A package manager or package-management system is a collection of software tools that automates the process of installing, upgrading, configuring, and removing computer programs for a computer's operating system in a consistent manner.

#### Package Managers for other languages

* npm
* pip
* gems
* apt
* yum

## Initialize Composer

* run `composer init`

## Update `.gitignore`

```
...
/vendor/
...
```

## Installing Symfony Components

### Why Symfony

* Don't reinvent the wheel
* Great Community Support
* Components are used By Many other popular Frameworks

> ### Running Commands Inside Docker Containers
> * View running containers `docker ps`
> * To Execute a command inside a container run `docker exec  <container_name> <command> <parameters>`


To Install the http-foundation component run: `docker exec dnc-api_app_1  composer require symfony/http-foundation`

### update Dockerfile to add required dependencies

```dockerfile
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
```

### Rebuild Docker 
* `docker-compose up --build`

`git checkout step4`
