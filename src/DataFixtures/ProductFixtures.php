<?php

namespace App\DataFixtures;


use Faker\Factory;
use App\Entity\User;
use App\Entity\Orders;
use App\Entity\Product;
use App\Entity\OrderProduct;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class ProductFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $users = [];
        $products = [];

        $user = new User();
        $user->setUsername('demo')
            ->setPassword($this->encoder->encodePassword($user, 'demo'))
            ->setRoles(["ROLE_ADMIN"]);

        $manager->persist($user);

        /* USERS */
        for ($k=0; $k <= 5; $k++)
        {
            $user = new User();
            $user->setUsername($faker->firstName)
                ->setPassword($this->encoder->encodePassword($user, 'password'))
                ->setRoles(["ROLE_USER"]);

            $users[] = $user;
            $manager->persist($user);
        }

        /* PRODUCT */
        for ($l=0; $l <= 20; $l++)
        {
            $product = new Product();
            $product
                ->setName($faker->name)
                ->setTitle($faker->jobTitle)
                ->setDescription($faker->text(150))
                ->setPrice($faker->randomFloat(2,2,5))
                ->setQuantity($faker->randomDigitNotNull)
                ->setStyle($faker->word)
                ->setColor($faker->randomElement(Product::COLOR))
                ->setDegrees($faker->randomFloat(1, 6,8))
                ->setNew($faker->boolean)
                ->setPromo(null);

            $products[] = $product;
            $manager->persist($product);
        }


        /* ORDER - ORDER PRODUCT */
        for ($i = 0; $i <= 5; $i++) {
            $order = new Orders();
            $order->setUser($faker->randomElement($users));

            $manager->persist($order);

            for ($j = 0; $j <= mt_rand(5, 10); $j++) {
                $orderProduct = new OrderProduct();
                $orderProduct->setProduct($faker->randomElement($products))
                    ->setQuantity(mt_rand(10, 20))
                    ->setOrders($order);
                $manager->persist($orderProduct);
            }
        }

        $manager->flush();
    }
}
