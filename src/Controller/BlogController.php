<?php


namespace App\Controller;


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
     * @Route("/{page}", name="blog_list", defaults={"page": 5 })
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

    /**
     * @Route("/{id}", name="blog_by_id", requirements={"id"="\d+"})
     */
    public function post($id){
        return new JsonResponse(
            self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
        );
    }

    /**
     * @Route("/{slug}", name="blog_by_slug")
     */
    public function postBySlug($slug){
        return new JsonResponse(
            self::POSTS[array_search($slug, array_column(self::POSTS, 'slug'))]
        );
    }
}