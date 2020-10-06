<?php


namespace App\Controller;


use App\Entity\BlogPost;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class BlogController
 * @package App\Controller
 * @Route("/blog")
 */
class BlogController extends AbstractController
{


    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    private const POSTS = [
        [
            'id' => 1,
            'slug' => 'hellow-world',
            'title' => 'Hello world!',
        ],
        [
            'id' => 2,
            'slug' => 'another-post',
            'title' => 'This is another post!',
        ],
        [
            'id' => 3,
            'slug' => 'last-example',
            'title' => 'This is the last example!',
        ]
    ];


    /**
     * @param int $page
     * @param Request $request
     * @return JsonResponse
     */
    public function list($page = 1, Request $request){

        $limit = $request->get('limit', 10);

        return new JsonResponse(
            [
                'page' => $page,
                'limit' => $limit,
                'data' => array_map(function ($item){
                    return $this->generateUrl('blog_by_slug', ['slug' => $item['slug']]);
                }, self::POSTS )
            ]
        );
    }

    public function post($id){
        return new JsonResponse(
            self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
        );
    }

    public function postBySlug($slug){
        return new JsonResponse(
            self::POSTS[array_search($slug, array_column(self::POSTS, 'slug'))]
        );
    }


    public function add(Request $request ){
        $serializer = $this->get('serializer');

        $blogPost = $serializer->deserialize($request->getContent(), BlogPost::class, 'json');

        $this->em->persist($blogPost);
        $this->em->flush();

        return $this->json($blogPost);

    }

    public function addTest(){
        $blogPost = new BlogPost();

        $blogPost->setAuthor('Grzesiek');
        $blogPost->setContent('Tekst w zasadzie o niczym');
        $blogPost->setPublished(new \DateTime());
        $blogPost->setTitle('Historia kotka');

        $this->em->persist($blogPost);
        $this->em->flush();

        return new JsonResponse(
            'Poszło'
        );

    }
}