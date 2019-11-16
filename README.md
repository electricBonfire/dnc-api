# DNC API

## Working with Docker
### Prerequisites
* Knowledge of Linux
* System Admin / DevOPs Tasks

## Building our `LAMP` Stack

#### Create a docker folder
`./docker/`

#### Update `.gitignore`

```
...
docker/db
...
```


#### Create `docker-compose.yml`
```yaml
// ./docker-compose.yml

version: '3.4'

services:
  app:
    image: php:apache
    ports:
      - 80:80
    volumes:
      - ./:/var/www/html
  db:
    image: mysql:5.7
    environment:
      MYSQL_ROOT_PASSWORD: D&CR0ckz!
    volumes:
      - ./docker/db:/var/lib/mysql:rw
    ports:
      - 3306:3306
```

#### Create `index.php`

```php
// ./index.php

<?php

$name = $_GET['name'];

printf('Hello %s', $name);
```
* run `docker-compose up`
* connect to your database
* check the app: `http://localhost`


## Building Own Own Docker Image
  
The DockerFile

```dockerfile
# ./Dockerfile

FROM php:apache

RUN apt-get update -y && apt-get upgrade -y

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
```

### Update `docker-compose.yml`

```yaml
...

services:
  app:
    # image: php:apache -- REMOVE THIS LINE
    build: ./ #ADD THIS LINE
    
    ...
```

### Create .dockerignore

```
.git
.gitignore
docker-compose.yml
docker/db
```

## Restart docker-compose

* Shutdown the active docker-compose `ctrl+x`
* Run docker again: `docker-compose up`

## Adding The Symfony cli

edit Dockerfile

```yaml
   ...
   RUN apt install -y git
   RUN curl -sS https://get.symfony.com/cli/installer | bash 
```

## Restart and Rebuild our containers

* Shutdown the active docker-compose ctrl+x
* Run docker-compose with the build flag: `docker-compose up --build`

`git checkout step3`