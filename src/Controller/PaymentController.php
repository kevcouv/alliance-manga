<?php

namespace App\Controller;

use App\Entity\Purchase;
use App\Event\PurchaseSuccessEvent;
use App\Form\CartConfirmationType;
use App\Repository\PurchaseRepository;
use App\Service\Cart\CartService;
use App\Service\Purchase\PurchasePersister;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class PaymentController extends AbstractController
{

    protected $em;

    protected $persister;

    public function __construct(EntityManagerInterface $em, PurchasePersister $persister)
    {
        $this->em = $em;
        $this->persister = $persister;
    }

    /**
     * @Route("/addressForm", name="addressForm")
     * @Security("is_granted('ROLE_USER') or is_granted('ROLE_ADMIN')")
     */
    public function addressForm(Request $request, CartService $cartService): Response
    {

        //Récupérer le formulaire de l'adresse de livraison
        $form = $this->createForm(CartConfirmationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Validation des données de la commande
            /**
             * @var Purchase
             */
            $purchase = $form->getData();

            $this->persister->storePurchase($purchase);

            // Redirection vers l'insfrastructure de paiement STRIPE
            return $this->redirectToRoute('checkout', [
                'id' => $purchase->getId()
            ]);
        }
        return $this->render('payment/index.html.twig', [
            'form' => $form->createView(),
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal(),
            'totalQuantity' => $cartService->getTotalQuantity(),
        ]);
    }


    /**
     * @Route("/checkout-{id}", name="checkout")
     */
    public function checkout($id, PurchaseRepository $purchaseRepository): Response
    {
        $purchase = $purchaseRepository->find($id);

        if (!$purchase) {
            return $this->redirectToRoute('panier');
        }

        \Stripe\Stripe::setApiKey('sk_test_51JQd5JC9AE7tivzxKcYFk08uXLpLd1e8vJ7W1HfeBVwxRqBqPIflGFZiXsIoGGIHbWL1mwGEoH158SodM8L3XodF00WR384uE3');

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'test',
                    ],
                    'unit_amount' => $purchase->getTotal(),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('success_url', ['id' => $id], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $this->redirect($session->url, 303);

    }

    /**
     * @Route("/success-url-{id}", name="success_url")
     */
    public function successUrl($id, CartService $cartService, PurchaseRepository $purchaseRepository, EventDispatcherInterface $dispatcher): Response
    {
        $purchase = $purchaseRepository->find($id);


        //Statut du paiement en "PAYEE" (PAID)
        $purchase->setStatus(Purchase::STATUS_PAID);
        $this->em->persist($purchase);
        $this->em->flush();

        // je vide le panier
        $cartService->empty();

        // Lancer un évènement qui permette aux autres développeurs de réagir à la prise d'une commande
        $purchaseEvent = new PurchaseSuccessEvent($purchase);
        $dispatcher->dispatch($purchaseEvent, 'purchase.success');

        // Je redirige avec un flash du succès du paiement
        $this->addFlash('success', "Votre commande a bien été payée! Un mail de confirmation de la commande vous a été envoyé.");
        return $this->redirectToRoute("account");
    }

    /**
     * @Route("/cancel-url", name="cancel_url")
     */
    public function cancelUrl(): Response
    {

        $this->addFlash('warning', "Paiement invalide!");
        return $this->redirectToRoute("panier");
    }


}
