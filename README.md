# DNC API

##Working with Docker
###Prerequisites
* Knowledge of Linux
* System Admin / DevOPs Tasks

## Building our `LAMP` Stack

### Files needed

#### docker folder
`./docker`

#### .gitignore

```
...
docker/db
...
```


#### docker-compose.yml
```
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

#### index.php

```
// ./index.php

<?php

$name = $_GET['name'];

printf('Hello %s', $name);
```
* run `docker-compose up`
* connect to your database
* check the app: `http://localhost`

`git checkout step3`