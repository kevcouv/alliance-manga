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

    protected function getCart():array
    {
        return $this->session->get('panier', []);
    }

    protected function saveCart($panier)
    {
        return $this->session->set('panier', $panier);
    }



    public function empty()
    {
        $this->saveCart([]);
    }


    //  AJOUTER UNE ARTICLE DANS LE PANIER

    public function add(int $id)
    {
        $panier = $this->getCart();

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }
        $this->saveCart($panier);
    }

    //  RETIRER UN ARTICLE DANS LE PANIER

    public function removeOne(int $id)
    {
        $panier = $this->getCart();

        if (!empty($panier[$id])) {
            if ($panier[$id] > 1) {
                $panier[$id]--;
            } else {
                unset($panier[$id]);
            }
        }
        $this->saveCart($panier);
    }

    // SSUPPRIMER TOUT L'ELEMENT DANS LE PANIER

    public function remove(int $id)
    {
        $panier = $this->getCart();

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $this->saveCart($panier);
    }

    // RECUP L'ID DES ARTICLES*/

    /**
     * @return CartItem[]
     */

    public function getFullCart(): array
    {
        $panier = $this->getCart();

        $detailedCart = [];

        foreach ($panier as $id => $quantity) {

            $product = $this->productRepository->find($id);

            $detailedCart[] = new CartItem($product, $quantity);
        }

        return $detailedCart;
    }

    // TOTAL DU PRIX DES ARTICLES

    public function getTotal(): float
    {

        $total = 0;

        foreach ($this->getCart() as $id => $quantity) {
            $product = $this->productRepository->find($id);

            $total += $product->getPrice() * $quantity;
        }

        return $total;
    }

    public function getTotalTTC(): float
    {

        $totalTVA = 0;
        $total = 0;
        $tva = 1.21;

        foreach ($this->getCart() as $id => $quantity) {
            $product = $this->productRepository->find($id);

            $total += $product->getPrice() * $quantity;
            $totalTVA = $total * $tva;
        }

        return $totalTVA;
    }

    // TOTAL QUANTITE

    public function getTotalQuantity(): float
    {
        $total = 0;

        foreach ($this->getCart() as $id => $quantity) {
            $total += $quantity;
        }

        return $total;
    }
}