<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="order")
     */
    public function index()
    {
        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }

    /**
     * @Route("/reserver/{id}" , name="order.reserve")
     */
    public function reserve(Product $product, Request $request)
    {

//      if(!is_array($request->getSession()->get('panier'))){
//          $panier = $request->getSession()->set('panier' , []);
//          $panier[] = $product;
//
//
//      }
//
//      dump($panier);
    }
}
