<?php

namespace App\Service\Purchase;

use App\Entity\Purchase;
use App\Entity\PurchaseItem;
use App\Service\Cart\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class PurchasePersister
{

    protected $security;

    protected $cartService;

    protected $em;

    public function __construct(Security $security, CartService $cartService, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->cartService = $cartService;
        $this->em = $em;
    }

    public function storePurchase(Purchase $purchase)
    {
        $purchase->setUser($this->security->getUser());
        $purchase->setTotal($this->cartService->getTotal());

        $this->em->persist($purchase);

        foreach ($this->cartService->getFullCart() as $cartItem) {
            $purchaseItem = new PurchaseItem();
            $purchaseItem->setPurchase($purchase)
                ->setProduct($cartItem->product)
                ->setProductName($cartItem->product->getTitle())
                ->setQuantity($cartItem->quantity)
                ->setTotal($cartItem->getTotal())
                ->setProductPrice($cartItem->product->getPrice());

            $this->em->persist($purchaseItem);
        }

        $this->em->flush();
    }
}