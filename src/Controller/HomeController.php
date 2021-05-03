<?php

namespace App\Controller;

use App\Repository\MangaRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param MangaRepository $repository
     * @param ProductRepository $repositoryProd
     * @return Response
     */
    public function index(MangaRepository $repository, ProductRepository $repositoryProd): Response
    {

        $licenses = $repository->findBy(
            [],
            ['title' => 'DESC'], 6
        );

        $products = $repositoryProd->findBy(
            [],
            ['id' => 'ASC'], 4
        );

        return $this->render('home/index.html.twig', [
            'licenses' => $licenses,
            'products' => $products,
        ]);
    }
}
