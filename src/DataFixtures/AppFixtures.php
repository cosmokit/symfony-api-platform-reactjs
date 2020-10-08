<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->loadUsers($manager);
        $this->loadBlogPosts($manager);
        $this->loadComments($manager);
    }

    public function loadBlogPosts(ObjectManager $manager){



        $blogPost = new BlogPost();
        $user = $this->getReference('single_user');

        $blogPost->setAuthor($user);
        $blogPost->setContent('Tekst w zasadzie o niczym Random');
        $blogPost->setPublished(new \DateTime());
        $blogPost->setTitle('Historia kotka');
        $blogPost->setSlug('historie-kotka');

        $manager->persist($blogPost);

        $blogPost = new BlogPost();
        $blogPost->setAuthor($user);
        $blogPost->setContent('Kiedy Byłem małym chłopcem chej');
        $blogPost->setPublished(new \DateTime());
        $blogPost->setTitle('Co za czasy');
        $blogPost->setSlug('co-za-czasy');

        $manager->persist($blogPost);
        $manager->flush();
    }

    public function loadComments(ObjectManager $manager){

        $comments = new Comment();
        $user = $this->getReference('single_user');

        $comments->setContent('Komentarz testowy do komentarza');
        $comments->setAuthor($user);
        $comments->setPublished(new \DateTime());

        $manager->persist($comments);
        $manager->flush();

    }

    public function loadUsers(ObjectManager $manager){
        $user = new User();
        $user->setEmail('admin@myadmin.pl');
        $user->setPassword('qaz');
        $user->setRoles(['USER_ROLE']);

        $this->addReference('single_user', $user);

        $manager->persist($user);
        $manager->flush();
    }

}
