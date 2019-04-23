<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $repo;

    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @Route("/presentation" , name="product.index")
     * @return Response
     */
    public function index()
    {
        $products = $this->repo->findAll();

        return $this->render('product/index.html.twig',[
            'current_menu' => 'presentation',
            'products' => $products
        ]);
    }

    /**
     * @Route("/produits/{id}", name="product.show")
     * @return Response
     */
    public function show(Product $product, Request $request)
    {
        $product = $this->repo->find($product->getId());

        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }


}