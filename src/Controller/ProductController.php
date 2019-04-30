<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Product;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\ProductRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @var ProductRepository
     */
    private $repoProduct;
    /**
     * @var CommentRepository
     */
    private $repoComment;
    /**
     * @var ObjectManager
     */
    private $em;


    public function __construct(ProductRepository $repoProduct, CommentRepository $repoComment, ObjectManager $em)
    {
        $this->repoProduct = $repoProduct;
        $this->repoComment = $repoComment;
        $this->em = $em;
    }

    /**
     * @Route("/presentation" , name="product.index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {

        $paginator = $paginator->paginate($this->repoProduct->findAllQuery(),  $request->query->getInt('page', 1),6);

        return $this->render('product/index.html.twig',[
            'current_menu' => 'presentation',
            'products' => $paginator
        ]);
    }

    /**
     * @Route("/produits/{id}", name="product.show")
     * @return Response
     */
    public function show(Product $product, Request $request, PaginatorInterface $paginator)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $product = $this->repoProduct->find($product->getId());
        $paginator = $paginator->paginate($this->repoComment->findAllQuery($product), $request->query->getInt('page', 1 ), 5);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $comment->setProduct($product);
            $this->em->persist($comment);
            $this->em->flush();
            $this->addFlash('success', 'Votre commentaire a bien été pris en compte');
            $this->redirectToRoute('product.show' , [
                'id' => $product->getId()
            ]);
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'comments' => $paginator,
            'form_comment' => $form->createView()
        ]);
    }


}