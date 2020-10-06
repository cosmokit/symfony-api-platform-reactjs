<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $blogPost = new BlogPost();

        $blogPost->setAuthor('Grzesiek Random');
        $blogPost->setContent('Tekst w zasadzie o niczym Random');
        $blogPost->setPublished(new \DateTime());
        $blogPost->setTitle('Historia kotka');
        $blogPost->setSlug('historie-kotka');

        $manager->persist($blogPost);

        $blogPost = new BlogPost();
        $blogPost->setAuthor('Marek Siarek');
        $blogPost->setContent('Kiedy Byłem małym chłopcem chej');
        $blogPost->setPublished(new \DateTime());
        $blogPost->setTitle('Co za czasy');
        $blogPost->setSlug('co-za-czasy');

        $manager->persist($blogPost);

        $manager->flush();
    }
}
