<?php

namespace App\Controller;

use App\Entity\Manga;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LicenceController extends AbstractController
{
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

    public function licence($id): Response
    {
        $licence = $this->getDoctrine()
            ->getRepository(Manga::class)
            ->find($id);

        $products = $this->getDoctrine()
            ->getRepository(Manga::class)
            ->find($id)
            ->getProducts();



        return $this->render('licence/products.html.twig', [
            'licence' => $licence,
            'products' => $products
        ]);
    }
}
