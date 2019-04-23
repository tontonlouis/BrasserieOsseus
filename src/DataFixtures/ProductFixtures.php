<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for ($i=0; $i <= 10; $i++)
        {
            $product = new Product();
            $product->setName("Biére os $i")
                ->setDescription("Description de la bière n°$i")
                ->setPrice($i*0.75)
                ->setQuatity($i * 3)
                ->setTitle("La bière os $i a son carractère");

            $manager->persist($product);
        }

        $manager->flush();
    }
}
