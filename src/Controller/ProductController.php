<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product-{id}", name="product")
     */

    public function detail($id): Response
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findBy(
                [],
                ['category' => 'ASC'], 4, rand(1,57)
            );

        return $this->render('product/index.html.twig', [
            'product' =>  $product,
            'products' => $products
        ]);
    }

    /**
     * @Route("/figurines", name="figurines")
     */

    public function allFigurine(): Response
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        return $this->render('product/all_figurine.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/derived", name="derived")
     */

    public function derivedProduct(): Response
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        return $this->render('product/derived_product.html.twig', [
            'products' => $products
        ]);
    }
}
