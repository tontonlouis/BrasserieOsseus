<?php

namespace App\Controller;

use App\Entity\Product;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Faker\Factory;
use Twig\Environment;

class DefaultController extends AbstractController
{

    private $renderer;

    public function __construct(Environment $render)
    {
        $this->renderer = $render;
    }

    public function index()
    {

        $faker = Factory::create('fr_FR');
        $paniers = [];

        for ($i = 0; $i <= 5; $i++)
        {
            $product = new Product();
            $product->setTitle($faker->word)
                ->setName($faker->name)
                ->setQuatity($faker->numberBetween(1,10))
                ->setDegrees($faker->numberBetween(3,7))
                ->setPrice($faker->numberBetween(3,6))
                ->setPromo(0)
                ->setNew($faker->boolean)
                ->setStyle($faker->word)
                ->setColor($faker->colorName)
                ->setDescription($faker->text(100));

            $paniers[] = $product;
        }

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderer->render('pdf/defaultPDF.html.twig', [
            'title' => "Commande n° 50",
            'paniers' => $paniers
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'paysage'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Store PDF Binary Data
        $output = $dompdf->output();

        // In this case, we want to write the file in the public directory
        $publicDirectory = $this->getParameter('kernel.project_dir'). '/public/factures';
        // e.g /var/www/project/public/mypdf.pdf
        $pdfFilepath =  $publicDirectory . '/commande'. 50 .'pdf';

        // Write file to the desired path
        file_put_contents($pdfFilepath, $output);

        // Send some text response
        return $pdfFilepath;
    }

}