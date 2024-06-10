<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $order = new Order();
        $order->setCreatedAt(new \DateTime());
        $order->setUpdatedAt(new \DateTime());

        $amount = 0;
        $product = $manager->getRepository(Product::class)->findOneBy(['name' => 'Sample Product 1']);
        if ($product) {
            $order->addProduct($product);
            $amount += $product->getPrice();
        }
        $product2 = $manager->getRepository(Product::class)->findOneBy(['name' => 'Sample Product 2']);
        if ($product2) {
            $order->addProduct($product2);
            $amount += $product2->getPrice();
        }

        $order->setAmount($amount);
        $manager->persist($order);

        $manager->flush();

        $order = new Order();
        $order->setCreatedAt(new \DateTime());
        $order->setUpdatedAt(new \DateTime());

        $amount = 0;
        $product = $manager->getRepository(Product::class)->findOneBy(['name' => 'Sample Product 2']);
        if ($product) {
            $order->addProduct($product);
            $amount += $product->getPrice();
        }
        $product2 = $manager->getRepository(Product::class)->findOneBy(['name' => 'Sample Product 3']);
        if ($product2) {
            $order->addProduct($product2);
            $amount += $product2->getPrice();
        }

        $order->setAmount($amount);
        $manager->persist($order);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProductFixtures::class,
        ];
    }
}