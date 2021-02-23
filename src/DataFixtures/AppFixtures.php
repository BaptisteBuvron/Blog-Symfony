<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');
        $slugify = new Slugify();
        for ($i=0; $i <= 15; $i++) {
            $article = new Article();
            $article->setTitle($faker->text(20))
                    ->setIntroduction($faker->sentence)
                    ->setContent($faker->paragraph());
            $article->setSlug($slugify->slugify($article->getTitle()));
            $manager->persist($article);
        }
        // $manager->persist($product);

        $manager->flush();
    }
}
