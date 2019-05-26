<?php

namespace App\DataFixtures;

use Faker;
use App\Service\Slugify;
use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * ArticleFixtures constructor.
     * @param Slugify $slugify
     */
    public function __construct(Slugify $slugify)
    {
        $this->slug = $slugify;
    }


    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('en_US');
        for ($i=0; $i<50 ; $i++) {
            $article = new Article();
            $article->setTitle(mb_strtolower($faker->catchPhrase));
            $article->setSlug($this->slug->generate($article->getTitle()));
            $article->setCategory($this->getReference('categorie_' . $faker->numberBetween(0, 5)));
            $article->setContent($faker->realText($maxNbChars = 200, $indexSize = 2));
            $manager->persist($article);
        }
        $manager->flush();
    }
}
