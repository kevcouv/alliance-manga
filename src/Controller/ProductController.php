<?php

namespace App\Controller;

use App\Entity\Manga;
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

        return $this->render('product/index.html.twig', [
            'product' =>  $product,
        ]);
    }
}
