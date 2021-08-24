<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PurchasesController extends AbstractController
{
    /**
     * @Route("/purchases-{id}", name="purchases")
     * @IsGranted("ROLE_USER")
     */
    public function index($id): Response
    {
        $purchases = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id)
            ->getPurchases();

        return $this->render('purchases/index.html.twig', [

            'purchases' => $purchases,
        ]);
    }
}
