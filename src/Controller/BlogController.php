<?php


namespace App\Controller;


use App\Entity\BlogPost;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


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

    /**
     * @param int $page
     * @param Request $request
     * @return JsonResponse
     */
    public function list($page = 1, Request $request){

        $limit = $request->get('limit', 10);
        $blogList = $this->em->getRepository(BlogPost::class);
        $items = $blogList->findAll();


        return $this->json(
            [
                'page' => $page,
                'limit' => $limit,
                'data' =>  $items
            ]
        );
    }

    /**
     * @ParamConverter("post", class="App:BlogPost")
     * @param BlogPost $post
     * @return JsonResponse
     */
    public function post($post){
        // It's the same as doing find($id) on repository
        return  $this->json($post);
    }

    /**
     * @ParamConverter("post", options={"mapping": {"slug": "slug"}} ,class="App:BlogPost")
     * @param BlogPost $post
     * @return JsonResponse
     */
    public function postBySlug($post){
//        return $this->json(
//            $this->em->getRepository(BlogPost::class)->findBy(['slug' => $slug])
//        );
        // Same as doing findOneBy(['slug => $slug])
        return $this->json($post);
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

    /**
     * @ParamConverter("post", class="App:BlogPost")
     * @param BlogPost $post
     * @return JsonResponse
     */
    public function delete($post){
        $this->em->remove($post);
        $this->em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}