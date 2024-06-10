<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product();
        $product->setName('Sample Product 1');
        $product->setPrice(10.99);
        $product->setCreatedAt(new \DateTime());
        $product->setUpdatedAt(new \DateTime());

        $manager->persist($product);

        $product = new Product();
        $product->setName('Sample Product 2');
        $product->setPrice(14.99);
        $product->setCreatedAt(new \DateTime());
        $product->setUpdatedAt(new \DateTime());

        $manager->persist($product);


        $manager->flush();

        $product = new Product();
        $product->setName('Sample Product 3');
        $product->setPrice(9.99);
        $product->setCreatedAt(new \DateTime());
        $product->setUpdatedAt(new \DateTime());

        $manager->persist($product);


        $manager->flush();
    }
}