<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\OrderProduct;
use App\Entity\Product;
use App\Form\CommentType;
use App\Repository\ProductRepository;
use App\Repository\CommentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use function mysql_xdevapi\getSession;

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
     * @Route("/produits/{slug}-{id}", name="product.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Product $product, string $slug, Request $request, PaginatorInterface $paginator)
    {

        if ($slug !== $product->getSlug())
        {
            return $this->redirectToRoute('product.show', [
                'id' => $product->getId(),
                'slug' => $product->getSlug()
            ],301);
        }
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
            //$paginator = $paginator->paginate($this->repoComment->findAllQuery($product), $request->query->getInt('page', 1 ), 5);

            $this->redirectToRoute('product.show' , [
                'id' => $product->getId(),
                'slug' => $product->getSlug(),
                'comments' => $paginator
            ]);
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'comments' => $paginator,
            'form_comment' => $form->createView()
        ]);

    }

    /**
     * @Route("/produits/reserver/{id}", name="product.add", methods={"POST|GET"})
     * @param Product $product
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Product $product, Request $request)
    {
        // $data = json_decode($request->getContent(), true);

        $session  = $request->getSession();

        if(empty($session->getName('caddy'))){
            $session->set('caddy', []);
        }

        $caddy = $session->get('caddy');
        $caddy[] = $product;
        $session->set('caddy', $caddy);

        return new JsonResponse(['success' => count($caddy) ]);


    }


}