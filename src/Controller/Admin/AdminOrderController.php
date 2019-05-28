<?php

namespace App\Controller\Admin;

use App\Controller\DefaultController;
use App\Entity\OrderProduct;
use App\Entity\Orders;
use App\Repository\OrderProductRepository;
use App\Repository\OrderRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminOrderController
 * @package App\Controller\Admin
 * @Route("admin/orders")
 */
class AdminOrderController extends AbstractController
{

    /**
     * @var ObjectManager
     */
    private $em;
    /**
     * @var OrderProductRepository
     */
    private $orderProductRepository;
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    private $pdf;

    public function __construct(DefaultController $pdf,ObjectManager $em, OrderProductRepository $orderProductRepository, OrderRepository $orderRepository)
    {
        $this->em = $em;
        $this->orderProductRepository = $orderProductRepository;
        $this->orderRepository = $orderRepository;
        $this->pdf = $pdf;
    }

    /**
     * @Route("/", name="admin.order.index")
     */
    public function index()
    {
        $orders = $this->orderRepository->findAll();

        return $this->render('admin/orders/index.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/{id}", name="admin.order.show")
     */
    public function show(Orders $order)
    {
        $orderProd = $order->getOrderProducts();

        return $this->render('admin/orders/show.html.twig', [
            'order' => $order,
            'products' => $orderProd
        ]);
    }

    /**
     * @Route("/facture/{id}", name="admin.order.bill")
     */
    public function bill(Orders $order)
    {
        $orderProd = $order->getOrderProducts();

       return $this->pdf->bill($order, $orderProd);

    }

}
