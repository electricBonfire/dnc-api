# DNC API

## Apache Rewrite | Frontend Controller

We need to enable rewrite on apache so that all of our requests are sent to our application entrypoint `./public/index.php`

### Install the .htaccess file 

`docker exec dnc-api_app_1 composer req symfony/apache-pack`

### Edit `Dockerfile`

```dockerfile
#...
RUN a2enmod rewrite
#...
```

## Doctrine (ORM)

> Object-Relational Mapping (ORM) is a technique that lets you query and manipulate data from a database using an object-oriented paradigm. When talking about ORM, most people are referring to a library that implements the Object-Relational Mapping technique, hence the phrase "an ORM".

### First lets install the "maker bundle" 

`docker exec dnc-api_app_1 composer require symfony/maker-bundle migrations --dev`

### Lets create an "Entity"

`docker exec dnc-api_app_1 ./bin/console make:entity`

It doesn't work! Lets add some flags to docker exec:

`docker exec -it dnc-api_app_1 ./bin/console make:entity`

Go through the prompts and review the generated files in `/src/Entity` and `/src/Repository`

### Updating the DB

First we need to generate code to update our db:

`docker exec dnc-api_app_1 ./bin/console make:migration`

Check out the new Migration file in `/src/Migrations`

### Update `./docker/vhost.conf`
```apacheconfig
    <VirtualHost *:80>
        #...
        <Directory /var/www/html/public >
            AllowOverride All
        </Directory>
    </VirtualHost>    
```

`git checkout step7`
