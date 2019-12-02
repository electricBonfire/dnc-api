# DNC API

## API Platform

visit `localhost/api/docs`

* use the interface to add some events

## Lets add the profiler

run `docker exec dnc-api_app_1 composer require debug --dev`

## Lets create a User

Run The following commands and go through the prompts

`docker exec -it dnc-api_app_1 ./bin/console make:user`
* Name of class: `User`
* Store data in the database `yes`
* Display name: `username`
* has passwords `yes`

`docker exec -it dnc-api_app_1 ./bin/console make:entity`
* Class Name: `User`
* New Property: `firstName`
    * Type: `string`
    * Length: `255`
    * Nullable: `no`
* New Property: `lastName`
    * Type: `string`
    * Length: `255`
    * Nullable: `no`
* New Property: `email`
    * Type: `string`
    * Length: `255`
    * Nullable: `no`

`docker exec -it dnc-api_app_1 ./bin/console make:migration`

`docker exec -it dnc-api_app_1 ./bin/console doctrine:migrations:migrate`

## Lets create some relations (event speakers)

run `docker exec -it dnc-api_app_1 ./bin/console make:entity`

* Class Name: `Event`
* New Property: `speakers`
    * Field Type: `ManyToMany`
    * Related Class: `User`
    * Add Property to User: `yes`
    * New Field Name: `eventsf`

Update your `Event` add a `ManyToMany` to `User`

Create a migration `docker exec -it dnc-api_app_1 ./bin/console make:migration`

Update the database `docker exec -it dnc-api_app_1 ./bin/console doctrine:migrations:migrate`

## Lets create some Users

Tag `/src/Entity/User` as an ApiResource

```php
 // ./src/Entity/User
 
 ...
 use ApiPlatform\Core\Annotation\ApiResource;
 ...
 
 /**
  * @ApiResource()       // <----- ADD THIS LINE
  * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
  */
 class User implements UserInterface 
 ...
```

* To encrypt a password run `docker exec -it dnc-api_app_1 ./bin/console security:encode-password`
* Use this password to create a user through the api interface


## Update an Event Resource to include speakers

* When relating Resources you must use the `@id` property, aka the `IRI`

## Serialization Groups

### Update `./src/Entity/User.php`

```php
use Symfony\Component\Serializer\Annotation\Groups;
...

/*
 * @ApiResource(
 *     normalizationContext={"groups"={"user:read"}}
 *     denormalizationContext={"groups"={"user:write"}}
 * )
 */
 
 class User
 {
 
     /**
      * @ORM\Column(type="string", length=180, unique=true)
      * @Groups({"user:read, user:write"})
      */
     private $username;
```

### Update `./src/Entity/Event.php`
```php
/**
 * @ApiResource(
 *      normalizationContext={"groups"={"event:read"}},
 *      denormalizationContext={"groups"={"event:write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    ...

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"event:read", "event:write", "user:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"event:read", "event:write", "user:read"})
     */
    private $startsAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="events")
     * @Groups({"event:read", "event:write"})
     */
    private $speakers;
    
    ...
```
## Adding Filters

### Edit `./src/Entity/Event.php`
```php

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;


/**
 * @ApiResource(
 *      normalizationContext={"groups"={"event:read"}},
 *      denormalizationContext={"groups"={"event:write"}}
 * )
 * @ApiFilter(SearchFilter::class, properties={
 *   "name": "partial",
 *   "speakers": "exact",
 *   "speakers.username": "partial"
 * })
 * @ApiFilter(PropertyFilter::class)
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
```
Go to 

* `http://localhost/api/events.json?name=code`
* `http://localhost/api/events.json?properties[]=name`
* `http://localhost/api/events.jsonld?properties[]=name&properties[speakers]=username`
* `http://localhost/api/events.jsonld?speakers[]=/api/users/1`
* `http://localhost/api/events?speakers.username=sha`