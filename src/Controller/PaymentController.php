<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
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
     * @Route("/checkout", name="checkout")
     */
    public function checkout(Request $request): Response
    {

        \Stripe\Stripe::setApiKey('sk_test_51JQd5JC9AE7tivzxKcYFk08uXLpLd1e8vJ7W1HfeBVwxRqBqPIflGFZiXsIoGGIHbWL1mwGEoH158SodM8L3XodF00WR384uE3');

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'product_data',
                    ],
                    'unit_amount' => 2000,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL ),
            'cancel_url' => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL ),
        ]);

        return $this->redirect($session->url,303);
    }

    /**
     * @Route("/success-url", name="success_url")
     */
    public function successUrl(): Response
    {
        return $this->render('payment/success.html.twig', []);
    }

    /**
     * @Route("/cancel-url", name="cancel_url")
     */
    public function cancelUrl(): Response
    {
        return $this->render('payment/cancel.html.twig', []);
    }

    /**
     * @Route("/payment", name="payment")
     */
    public function payment(): Response
    {
        return $this->render('payment/index.html.twig', []);
    }

}
