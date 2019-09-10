<?php

namespace App\Controller;

use App\Entity\OrderProduct;
use App\Entity\Orders;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/order", name="order")
     */
    public function index(Request $request)
    {
        $request->getSession()->clear();
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/panier" , name="order.caddy")
     */
    public function caddy(Request $request)
    {
        $caddy = $request->getSession()->get('caddy');
        dump($caddy);
        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
            'caddy' => $caddy
        ]);

    }

    /**
     * @Route("/reserver" , name="order.reserve")
     */
    public function reserve(Request $request)
    {
        $order = new Orders();
        $order->setUser($this->getUser());
        $this->em->persist($order);

        $caddies = $request->getSession()->get('caddy');

        foreach ($caddies as $value) {
            $orderProduct = new OrderProduct();
            $orderProduct->setProduct($value)
                ->setQuantity(2)
                ->setOrders($order);
            $this->em->persist($orderProduct);
        }

        $this->em->flush();

        $request->getSession()->clear();

        return $this->render('order/reserve.html.twig', [
            'orders' => $order
        ]);
    }

    /**
     * @Route("/reservation", name="order.reserve.show")
     */
    public function show(Request $request)
    {
        $user = $this->getUser();
        $orders = $user->getOrders();

        return $this->render('order/show.html.twig', [
            'orders' => $orders
        ]);

    }
}
