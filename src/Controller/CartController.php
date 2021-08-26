<?php

namespace App\Controller;

use App\Entity\Purchase;
use App\Entity\PurchaseItem;
use App\Form\CartConfirmationType;
use App\Service\Purchase\PurchasePersister;
use App\Service\Cart\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class CartController extends AbstractController
{
    protected $em;

    protected $persister;

    public function __construct( EntityManagerInterface $em, PurchasePersister $persister)
    {
        $this->em = $em;
        $this->persister = $persister;
    }
    //PAGE PANIER

    /**
     * @Route("/panier", name="panier")
     */

    public function cart(Request $request, CartService $cartService)
    {

        $form = $this->createForm(CartConfirmationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /**
             * @var Purchase
             */
            $purchase = $form->getData();

            $this->persister->storePurchase($purchase);

            return $this->redirectToRoute('checkout', [
                'id' => $purchase->getId()
            ]);
        }

        return $this->render('cart/index.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal(),
            'totalQuantity' => $cartService->getTotalQuantity(),
            'form' => $form->createView()
        ]);
    }

    // AJOUTER UN ARTICLE DANS LE PANIER
    /**
     * @Route("/add-{id}", name="panier_add")
     */
    public function addPanier($id, CartService $cartService ){

        $cartService->add($id);

        return $this->redirectToRoute("panier");
    }

    // SUPPRIMER TOUT L'ELEMENT DANS LE PANIER

    /**
     * @Route("/remove-{id}", name="panier_remove"))
     */

    public function remove($id, CartService $cartService){

        $cartService->remove($id);

        return $this->redirectToRoute("panier");
    }

    // SUPPRIMER UN ARTICLE DANS LE PANIER

    /**
     * @Route("/removeOne-{id}", name="panier_removeOne")
     */

    public function removeOne($id, CartService $cartService){

        $cartService->removeOne($id);

        return $this->redirectToRoute("panier");
    }
}
