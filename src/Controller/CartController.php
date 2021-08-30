<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CartController extends AbstractController
{

    //PAGE PANIER
    /**
     * @Route("/panier", name="panier")
     */

    public function cart(CartService $cartService)
    {
        return $this->render('cart/index.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal(),
            'totalQuantity' => $cartService->getTotalQuantity(),
        ]);
    }


    // AJOUTER UN ARTICLE DANS LE PANIER

    /**
     * @Route("/add-{id}", name="panier_add")
     */
    public function addPanier($id, CartService $cartService)
    {
        $cartService->add($id);
        return $this->redirectToRoute("panier");
    }


    // SUPPRIMER TOUT L'ELEMENT DANS LE PANIER

    /**
     * @Route("/remove-{id}", name="panier_remove"))
     */

    public function remove($id, CartService $cartService)
    {
        $cartService->remove($id);
        return $this->redirectToRoute("panier");
    }


    // SUPPRIMER UN ELEMENT DANS LE PANIER

    /**
     * @Route("/removeOne-{id}", name="panier_removeOne")
     */

    public function removeOne($id, CartService $cartService)
    {
        $cartService->removeOne($id);
        return $this->redirectToRoute("panier");
    }
}
