# DNC API

## Apache Rewrite | Frontend Controller

We need to enable rewrite on apache so that all of our requests are sent to our application entrypoint `./public/index.php`

### Install the .htaccess file 

`docker exec -it dnc-api_app_1 composer req symfony/apache-pack`

### Edit `Dockerfile`

```dockerfile
#...
RUN a2enmod rewrite
#...
```

### Update `./docker/vhost.conf`
```apacheconfig
    <VirtualHost *:80>
        #...
        <Directory /var/www/html/public >
            AllowOverride All
        </Directory>
    </VirtualHost>    
```

## Routes / Controllers / MVC

### Create `./src/Controller/DNCController.php`

```php
<?php
// ./src/Controller/DNCController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DNCController extends AbstractController
{

    /**
     * @Route("/hello")
     */
    public function hello(Request $request)
    {
        $name = $request->query->get('name', 'Drink And Code');

        return new Response("hello ".$name);
    }

    /**
     * @Route("hey")
     */
    public function hey(Request $request)
    {
        $name = $request->query->get('name', 'Drink And Code');

        return new Response($this->renderView('hey.html.twig', ['name' => $name]));
    }

    /**
     * @Route("/howdy/{name}")
     */
    public function howdy(string $name)
    {
        return new Response($this->renderView('hey.html.twig', ['name' => $name]));
    }
}
```

### Create `./templates/hey.html.twig`
```twig
{% extends 'base.html.twig' %}

{% block body %}
    Hey {{ name }}
{% endblock %}
```

## Doctrine (ORM)

### First lets install the "maker bundle" 

`docker exec dnc-api_app_1 composer require symfony/maker-bundle migrations --dev`

### Lets create an "Entity"

`docker exec dnc-api_app_1 ./bin/console make:entity`

It doesn't work! Lets add some flags to docker exec:

`docker exec -it dnc-api_app_1 ./bin/console make:entity`

Go through the prompts and review the generated files in `/src/Entity` and `/src/Repository`

* Class Name: `Event`
* New Property Name: `name`
    * Field Type: `string`
    * Field Length `255`
    * nullable `no`
* New Property Name: `startsAt`
    * Field Type: `datetime`
    * nullable `yes`

### Updating the DB

First we need to generate code to update our db:

`docker exec dnc-api_app_1 ./bin/console make:migration`

Check out the new Migration file in `/src/Migrations`

`git checkout step7`


## CRUD

Create Read Update Delete (CRUD)

### Performing Opertaions on Our Entity

## Create `./src/Controller/EventController.php`
```php
<?php

namespace App\Controller;

use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{

    /**
     * @Route("/events", methods={"POST"})
     */
    public function createEvent()
    {
        $em = $this->getDoctrine()->getManager();

        $event = new Event();
        $event->setName('Drink And Code');
        $event->setStartsAt(new \DateTime());

        $em->persist($event);
        $em->flush();
        
        return new Response('', 201);
    }

    /**
     * @Route("/events")
     */
    public function getEvents()
    {
        $em     = $this->getDoctrine()->getManager();
        $events = $em->getRepository(Event::class)->findAll();

        return new Response($this->renderView('events.html.twig', ['events' => $events]));
    }
}
```

## Create `./templates/events.html.twig`

```twig
{%  extends 'base.html.twig' %}

{% block body %}
    <ul>
    {% for event in events %}
        <li>{{ event.name }} - {{ event.startsAt|date }}</li>
    {% endfor %}
    </ul>
{% endblock %}
```
