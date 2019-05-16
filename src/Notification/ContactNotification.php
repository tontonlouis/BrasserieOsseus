<?php

namespace App\Notification;

use App\Controller\DefaultController;
use App\Entity\Contact;
use Twig\Environment;

class ContactNotification
{

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $renderer;

    /**
     * @var DefaultController
     */
    private $pdf;
    /**
     * ContactNotification constructor.
     * @param Environment $renderer
     * @param \Swift_Mailer $mailer
     * @param DefaultController $pdf
     */
    public function __construct(Environment $renderer, \Swift_Mailer $mailer, DefaultController $pdf)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
        $this->pdf = $pdf;
    }

    public function notify(Contact $contact)
    {
        $filename = $this->pdf->index();
        $message = (new \Swift_Message('Contact'))
            ->setFrom('contact@brasserie.fr')
            ->setTo('contact@brasserie.fr')
            ->setReplyTo($contact->getEmail())
            ->setBody($this->renderer->render('email/emailContact.html.twig', [
                'contact' => $contact
            ]), 'text/html')
            ->attach(\Swift_Attachment::fromPath($filename)->setFilename('Facture.pdf'));

        $this->mailer->send($message);
    }
}