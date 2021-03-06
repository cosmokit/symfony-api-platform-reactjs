<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;
    /**
     * @var \Faker\Factory
     */
    private $faker;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;

        // Pakiet z poza. Wstrzykujemy inaczej.
        $this->faker = \Faker\Factory::create();
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

        for ($i = 0; $i < 20; $i++){

            $blogPost = new BlogPost();
            $blogPost->setAuthor($this->getReference("single_user_$i"));
            $blogPost->setContent($this->faker->realText(60));
            $blogPost->setPublished($this->faker->dateTimeThisYear);
            $blogPost->setTitle($this->faker->realText(30));
            $blogPost->setSlug( $this->faker->slug);

            $this->setReference("Blog_post_$i", $blogPost);

            $manager->persist($blogPost);
        }

        $manager->flush();
    }

    public function loadComments(ObjectManager $manager){

        for ($i = 0; $i < 20; $i++) {
            for ($j = 0; $j < rand(1,20); $j++){
                $comments = new Comment();

                $comments->setContent($this->faker->realText());
                $comments->setAuthor($this->getReference("single_user_$i"));
                $comments->setBlogPost($this->getReference("Blog_post_$i"));
                $comments->setPublished($this->faker->dateTimeThisYear);

                $manager->persist($comments);
            }
        }
        $manager->flush();

    }

    public function loadUsers(ObjectManager $manager){
        $user = new User();
        $user->setEmail('admin@myadmin.pl');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'qaz'));
        $user->setRoles(['ADMIN_ROLE']);
        $manager->persist($user);


        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setEmail($this->faker->email);
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'xsw'));
            $user->setRoles(['USER_ROLE']);

            $this->addReference("single_user_$i", $user);
            $manager->persist($user);
        }
        $manager->flush();



        $manager->flush();
    }

}
