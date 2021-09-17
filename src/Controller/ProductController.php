<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Product;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    // Afficher l'évaluation des étoiles sur toutes les cartes produits

    public function renderRatingStar($id): Response
    {
        $comment = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id)
            ->getComments();

        return $this->render('home/_ratingStar.html.twig', [
            'comment' => $comment,
        ]);
    }

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
                ['title' => 'DESC'], 4
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

        // Récupérer la catégorie Figurine

        $catFigurine = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findBy(['title' => 'Figurine'], []);

        // Récupérer les produits de catégorie Figurine
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findBy(['category' => $catFigurine], []);

        $products = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1), 9
        );




        $latestProducts = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findBy(
                ['category' => $catFigurine],
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
        $catDerived = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findBy(['title' => 'Mug'], []);


        $derivedProduct = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findBy(['category' => $catDerived], []);

        $derivedProduct = $paginator->paginate(
            $derivedProduct,
            $request->query->getInt('page', 1),9
        );

        $latestProducts = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findBy(
                ['category' => $catDerived],
                ['created_at' => 'DESC'], 2
            );


        return $this->render('product/derived_product.html.twig', [
            'products' => $derivedProduct,
            'latestProducts' => $latestProducts
        ]);
    }


    /**
     * @Route("/newProduct", name="newProduct")
     */

    public function newProduct(PaginatorInterface $paginator, Request $request): Response
    {

        $latestProducts = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findBy(
                [],
                ['created_at' => 'DESC'], 10
            );

        $latestProducts = $paginator->paginate(
            $latestProducts,
            $request->query->getInt('page', 1), 9
        );

        return $this->render('product/latest_products.html.twig', [
            'latestProducts' => $latestProducts,
        ]);
    }

}
