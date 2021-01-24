<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home(): Response
    {
        /*$user = $this->getUser();
        dd($user->getRoles());*/
        return $this->render('home.html.twig', [
           'controller' => 'HomeController'
        ]);
    }
}