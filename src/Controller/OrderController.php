<?php

namespace App\Controller;

use App\Entity\OrderProduct;
use App\Entity\Orders;
use App\Repository\ProductRepository;
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
    /**
     * @var DefaultController
     */
    private $pdf;
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(ObjectManager $em, DefaultController $pdf, ProductRepository $productRepository)
    {
        $this->em = $em;
        $this->pdf = $pdf;
        $this->productRepository = $productRepository;
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

        $caddies = $request->getSession()->get('caddy');

        foreach ($caddies as $value) {
            $order->addOrderProduct($value);
            $id = $value->getProduct()->getId();
            $product = $this->productRepository->find($id);
            $qte = $product->getQuantity() - $value->getQuantity();
            $product->setQuantity($qte);
        }

        $filepath = $this->pdf->reserve($order);

        $order->setInvoice($filepath);
        $this->em->persist($order);
        $this->em->flush();

        $request->getSession()->clear();

        return $this->render('order/reserve.html.twig', [
            'orders' => $order
        ]);
    }

}
