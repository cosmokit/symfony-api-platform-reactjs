<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class ProductController extends AbstractController
{


    /**
     * @Route("/product/{id}", name="product_show")
     */
    public function show($id, ProductRepository $productRepository)
    {
//        $product = $this->getDoctrine()
//            ->getRepository(Product::class)
//            ->find($id);

        $product = $productRepository
            ->find($id);

        $categoryNeme = $product->getCategory()->getName();

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response('Check out this great product: '.$product->getName()
        . ' category name is ' . $categoryNeme . ' Id Category: ' . $product->getCategory()->getId()
        );

    }

    /**
     * @Route("/product/category/id/{id}", name="product_show_selected_category")
     * Show all products from the selected category
     */
    public function showProductsInCategory($id)
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);

        $products = $category->getProducts();



        return $this->json($products, 200, [], [ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function($object){
            return $object->getName();
        }] );
    }

    /**
     * @Route("/product/find/price", name="product_find_price")
     */
    public function findProductSearchingPrice(){
        $minPrice = 1000;

        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAllGreaterThanPrice($minPrice);


        return $this->json($products);
    }


    /**
     * @Route("/product", name="create_product")
     */
    public function createProduct(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $category = new Category();
        $category->setName('Computer Peripherals');



        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(1999);
        $product->setDescription('Ergonomic and stylish!');

        $product->setCategory($category);


        $entityManager->persist($category);
        $entityManager->persist($product);

        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId()
            .' and new category with id: '.$category->getId()
        );
    }


    /**
     * @Route("/product/edit/{id}")
     */
    public function update($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $product->setName('New product name!');
        $entityManager->flush();

        return $this->redirectToRoute('product_show', [
            'id' => $product->getId()
        ]);
    }


}
