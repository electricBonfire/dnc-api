<?php

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