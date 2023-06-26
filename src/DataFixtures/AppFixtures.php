<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Zenstruck\Foundry\Factory;
use App\Entity\Product;
use App\Factory\ProductFactory;
use \App\Factory\integer;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $g = [
                'grupa' => 0,
                'grupa' => 1,
                'grupa' => 3,
            ];


        //$produkt = new ProductFactory();
        /* działająca ręcznie zenstruck
         * $factory = new Factory(Product::class);
        $produkt = $factory->create(
            [
                'name' => 'nazwa',
                'content' => "zawartosc",
                'grupa' => rand(1, 100)
            ],
        );
         */
        $factory = new ProductFactory();

        for ($i = 0; $i < 50; $i++) {

            $produkt = $factory->create('name', 'content', rand(0, 100));

            //$faker = $produkt->create("name", "content", $grupa);
            //var_
            $manager->persist($produkt);

            /*$product = new Product();
            $product->setName($faker->name);
            $product->setContent($faker->content);
            $product->setGrupa($faker->grupa);
            $manager->persist($product); */
        }
        $manager->flush();
    }

}
