<?php

namespace App\Controller;

use App\Entity\Event;
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
        $name = $request->query->get('name');

        return new Response("hello ".$name);
    }

    /**
     * @Route("hey")
     */
    public function hey(Request $request)
    {
        $name = $request->query->get('name');

        return new Response($this->renderView('hey.html.twig', ['name' => $name]));
    }

    /**
     * @Route("/howdy/{name}")
     */
    public function howdy(string $name)
    {
        return new Response($this->renderView('hey.html.twig', ['name' => $name]));
    }

    /**
     * @Route("/events", methods={"POST"})
     */
    public function createEvent(){
        $em = $this->getDoctrine()->getManager();

        $event = new Event();
        $event->setName('Drink And Code');
        $event->setStartsAt(new \DateTime());

        $em->persist($event);
        $em->flush();
    }

    /**
     * @Route("/events")
     */
    public function getEvents(){
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository(Event::class)->findAll();

        return new Response($this->renderView('events.html.twig', ['events' => $events]));
    }
}