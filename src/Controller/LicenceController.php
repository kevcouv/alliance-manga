<?php

namespace App\Controller;

use App\Entity\Manga;
use App\Repository\MangaRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LicenceController extends AbstractController
{
   // Afficher la liste des manga dans la navbar

    public function renderMenuList(): Response
    {
        $licences = $this->getDoctrine()
            ->getRepository(Manga::class)
            ->findAll();

        return $this->render('licence/_menu.html.twig', [
            'licences' => $licences,
        ]);
    }


    /**
     * @Route("/licences", name="licences")
     */
    public function licences(): Response
    {
        $licences = $this->getDoctrine()
            ->getRepository(Manga::class)
            ->findAll();
        return $this->render('licence/index.html.twig', [
            'licences' => $licences,
        ]);
    }

    /**
     * @Route("/licence-{id}", name="licence")
     */

    public function licence($id, Request $request, PaginatorInterface $paginator): Response
    {

        $licence = $this->getDoctrine()
            ->getRepository(Manga::class)
            ->find($id);

        $products = $this->getDoctrine()
            ->getRepository(Manga::class)
            ->find($id)
            ->getProducts();

        $products = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1), 9
        );

        return $this->render('licence/products.html.twig', [
            'licence' => $licence,
            'products' => $products
        ]);
    }
}
