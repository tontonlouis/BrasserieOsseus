<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{

    /**
     * @Route("profil", name="profil")
     */
    public function profil()
    {

        return $this->render('profil/index.html.twig', [
            'user' => $this->getUser()
        ]);

    }
}
