<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{

    /**
     * @var DefaultController
     */
    private $pdf;

    public function __construct(DefaultController $pdf)
    {

        $this->pdf = $pdf;
    }

    /**
     * @Route("profil", name="profil")
     */
    public function profil()
    {

        return $this->render('profil/index.html.twig', [
            'user' => $this->getUser()
        ]);

    }

    /**
     * @Route("/reservation", name="profil.reserve")
     */
    public function index(Request $request)
    {
        $user = $this->getUser();
        $orders = $user->getOrders();
        dump($request->getContent());

        return $this->render('order/show.html.twig', [
            'orders' => $orders
        ]);

    }

    /**
     * @Route("/commande/{id}", name="profil.reserve.show")
     */
    public function show(Orders $orders)
    {
        dump($orders->getInvoice()); die();

    }
}
