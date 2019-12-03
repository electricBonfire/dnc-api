# DNC API

## The Symfony Console
lets checkout the symfony console run `docker exec dnc-api ./bin/console` 

## Environments (DOTENV)

Open `.env` and take a look at the configuration

Create a new file called `.env.local`

## Installing Additional Symfony Components (Flex)

Lets install the api platform

`docker exec dnc-api composer req api`

Now lets checkout our `.env` file again

Copy `DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7` and add it to `.env.local`

Update the database credentials to match our `docker-compose` environment vars (`.env.local`)

`DATABASE_URL=mysql://root:D&CR0ckz!@db:3306/dnc?serverVersion=5.7`

## Lets Create our Database

`docker exec dnc-api ./bin/console doctrine:database:create`

OH NO!

Lets update our `Dockerfile`

```dockerfile
RUN apt-get update -y && apt-get upgrade -y && apt install -y \
        git \
        zip \
        unzip \
        zlib1g-dev \
        libicu-dev \
        g++ \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install pdo_mysql        ### <---ADDING THIS LINE
```

And lets rebuild `docker-compose up --build`

Ok lets try that again

`docker exec dnc-api ./bin/console doctrine:database:create`


`git checkout step6`
