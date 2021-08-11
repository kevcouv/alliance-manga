<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Manga;
use App\Entity\Product;
use App\Entity\ProductSearch;
use App\Form\CommentType;
use App\Form\ProductSearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product-{id}", name="product")
     */

    public function detail($id, Request $request): Response
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        $comment = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id)
            ->getComments();

        //Ajout de commentaire

        $addComment = new Comment();

        $form = $this->createForm(CommentType::class, $addComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $product->addComment($addComment);
            $addComment->setUser($this->getUser());
            $addComment->setCreatedAt(new \DateTime('now'));
            $addComment->setisPublished(1);
            $em->persist($addComment);
            $em->flush();

            return $this->redirectToRoute('product', ['id' => $id]);
        }

        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findBy(
                [],
                ['category' => 'ASC'], 4, rand(1, 57)
            );

        return $this->render('product/index.html.twig', [
            'product' => $product,
            'products' => $products,
            'comment' => $comment,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/figurines", name="figurines")
     */

    public function allFigurine(PaginatorInterface $paginator, Request $request): Response
    {
        $donneesProduct = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        $products = $paginator->paginate(
            $donneesProduct,
            $request->query->getInt('page', 1), 19
        );

        $latestProducts = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findBy(
                [],
                ['created_at' => 'DESC'], 2
            );

        return $this->render('product/all_figurine.html.twig', [
            'products' => $products,
            'latestProducts' => $latestProducts
        ]);
    }

    /**
     * @Route("/derived", name="derived")
     */

    public function derivedProduct(PaginatorInterface $paginator, Request $request): Response
    {
        $donneesProduct = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        $products = $paginator->paginate(
            $donneesProduct,
            $request->query->getInt('page', 1), 61
        );

        $latestProducts = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findBy(
                [],
                ['created_at' => 'DESC'], 2
            );


        return $this->render('product/derived_product.html.twig', [
            'products' => $products,
            'latestProducts' => $latestProducts
        ]);
    }
}
