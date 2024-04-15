<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use app\Entity\Article;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for($i=1;$i<=10;$i++)
        {
        $article=new Article();
        $article->setTitle("Titre de l'article n° $i")
        ->setContent("<p>Le contenu de l'article n° $i</p>")
        ->setImage("https://upload.wikimedia.org/wikipedia/commons/e/e3/Tunisia_logo.svg")
         ->setCreatedata(new \DateTimeImmutable());
        $manager->persist($article);
        }
        $manager->flush();
    }
}
