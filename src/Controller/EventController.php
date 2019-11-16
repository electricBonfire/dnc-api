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