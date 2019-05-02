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
           $mailer->notify($contact);
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
}
