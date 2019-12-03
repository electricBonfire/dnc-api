# DNC API

## Starting From Scratch

Remove the following files and folders

* vendor/
* composer.json
* composer.lock
* index.php

## The Symfony Skeleton / Installer

 * run the symfony installer inside docker `docker exec dnc-api symfony new dnc`
 * > Ignore the git error we are using our own git repo and do not need to create a new one.
 * open `./dnc/.gitignore` and add the contents into our `./.gitignore` file.
 * delete the `./dnc/.gitignore` file
 * Move all of the files out of the dnc folder and into our project directory
 * Delete the `./dnc` folder

### Updating our Docker Container

#### create a new file: `./docker/vhost.conf`

```apacheconfig
<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/html/public

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

#### Update our Dockerfile
```dockerfile
#...
COPY ./docker/vhost.conf /etc/apache2/sites-available/000-default.conf
```

#### Rebuild our container `docker-compose up --build`

#### Load The App: `http://localhost`

`git checkout step5`
