<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Purchase;
use App\Repository\ProductRepository;
use App\Repository\PurchaseItemRepository;
use App\Repository\PurchaseRepository;
use App\Service\Cart\CartService;
use Stripe\Checkout\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaymentController extends AbstractController
{
    /**
     * @Route("/checkout-{id}", name="checkout")
     */
    public function checkout($id, PurchaseRepository $purchaseRepository, ProductRepository $productRepository, PurchaseItemRepository $purchaseItemRepository, CartService $cartService): Response
    {
        $purchase = $purchaseRepository->find($id);
        $product = $productRepository->find($id);
        $itemPurchase = $purchaseItemRepository->find($id);
        if (!$purchase){
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
            'success_url' =>  $this->generateUrl('success_url' ,['id' => $id], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' =>  $this->generateUrl('cancel_url' ,[], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $this->redirect($session->url, 303);

    }

    /**
     * @Route("/success-url-{id}", name="success_url")
     */
    public function successUrl($id, CartService $cartService, PurchaseRepository $purchaseRepository): Response
    {
        $purchase = $purchaseRepository->find($id);

        $cartService->empty();
        $purchase->setStatus(Purchase::STATUS_PAID);

        return $this->redirectToRoute("account");
    }

    /**
     * @Route("/cancel-url", name="cancel_url")
     */
    public function cancelUrl(): Response
    {
        return $this->render('payment/cancel.html.twig', []);
    }


}
