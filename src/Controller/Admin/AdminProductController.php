<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminProductController extends AbstractController
{

    private $repository;

    private $em;

    /**
     * AdminProductController constructor.
     * @param ProductRepository $repository
     * @param ObjectManager $em
     */
    public function __construct(ProductRepository $repository, ObjectManager $em)
    {
            $this->repository = $repository;
            $this->em = $em;
    }

    /**
     * @Route("/admin/product", name="admin.product.index")
     */
    public function index(): Response
    {
        $products = $this->repository->findAll();

        return $this->render('admin/product/index.html.twig',[
            'products' => $products
        ]);
    }

    /**
     * @Route("/admin/product/create", name="admin.product.create")
     */
    public function create(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($product);
            $this->em->flush();
            $this->addFlash('success', 'Votre produit a bien été enregistré');
            return $this->redirectToRoute('admin.product.index');
        }

        return $this->render('admin/product/create.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/product/{id}", name="admin.product.edit", methods="GET|POST")
     * @param Product $product
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(Product $product, Request $request)
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $product->setUpdatedAt(new \DateTime('now'));
            $this->em->flush();
            $this->addFlash('success', 'Bien modifié avec succès');
            return $this->redirectToRoute('admin.product.index');
        }

        return $this->render('admin/product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/admin/product/{id}", name="admin.product.delete", methods="DELETE")
     * @param Product $product
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Product $product, Request $request)
    {

        $this->em->remove($product);
        $this->em->flush();
        $this->addFlash('success', 'Le produit a bien été supprimer');

        return $this->redirectToRoute('admin.product.index');
    }

}