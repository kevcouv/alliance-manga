<?php

namespace App\Service\Cart;


use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{

    protected $session;
    protected $productRepository;

    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    //  AJOUTER UNE ARTICLE DANS LE PANIER

    public function add(int $id)
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $this->session->set('panier', $panier);
    }

    //  RETIRER UN ARTICLE DANS LE PANIER

    public function removeOne(int $id)
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            if ($panier[$id] > 1) {
                $panier[$id]--;
            } else {
                unset($panier[$id]);
            }
        }
        $this->session->set('panier', $panier);
    }

    // SSUPPRIMER TOUT L'ELEMENT DANS LE PANIER

    public function remove(int $id)
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $this->session->set('panier', $panier);
    }

    // RECUP L'ID DES ARTICLES

    public function getFullCart(): array
    {
        $panier = $this->session->get('panier', []);

        $panierWithData = [];

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $this->productRepository->find($id),
                'quantity' => $quantity
            ];
        }

        return $panierWithData;
    }

    // TOTAL DU PRIX DES ARTICLES

    public function getTotal(): float
    {

        $total = 0;

        foreach ($this->getFullCart() as $item) {
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }

        return $total;
    }

    // TOTAL QUANTITE

    public function getTotalQuantity(): float
    {
        $totalQuantity = 0;

        foreach ($this->getFullCart() as $item) {
            $totalQuant = $item['quantity'];
            $totalQuantity += $totalQuant;
        }

        return $totalQuantity;
    }
}