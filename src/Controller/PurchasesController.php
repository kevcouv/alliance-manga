<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PurchasesController extends AbstractController
{

    //Afficher l'historique des commandes du client sur son compte

    /**
     * @Route("/purchases-{id}", name="purchases")
     */
    public function index($id): Response
    {
        $purchases = $this->getDoctrine()
        ->getRepository(User::class)
        ->find($id)
        ->getPurchases();

        return $this->render('account/purchases/index.html.twig', [

            'purchases' => $purchases,
        ]);
    }
}
