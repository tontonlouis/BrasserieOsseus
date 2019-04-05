<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")i
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'current_menu' => 'home',
        ]);
    }
}
