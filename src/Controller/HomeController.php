<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Product;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $pdf;

    public function __construct(DefaultController $pdf)
    {
        $this->pdf = $pdf;
    }

    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'current_menu' => 'home',
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     * @return Response
     */
    public function contact(Request $request, ContactNotification $mailer)
    {

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
           //$pdf = $this->pdf->index();
           $mailer->notify($contact);  //$mailer->notify($contact, $pdf);
           $this->addFlash('success', "Email envoyé avec succès");
           $this->redirectToRoute('contact', [
               'current_menu' => 'contact'
           ]);
        }

        return $this->render('home/contact.html.twig', [
            'current_menu' => 'contact',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/langue/{lang}", name="langue")
     *
     */
    public function langue(Request $request, string $lang)
    {
        $request->getSession()->set('_locale', $lang);

        return $this->redirectToRoute('home');
    }
}
