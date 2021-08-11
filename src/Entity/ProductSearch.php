<?php
namespace App\Entity;

class ProductSearch
{

    /**
     * @var int|null
     */
    private $maxPrice;


    /**
     * @var boolean|null
     */
    private $promo;

    /**
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * @param int|null $maxPrice
     * @return ProductSearch
     */
    public function setMaxPrice(int $maxPrice): ProductSearch
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getPromo(): ?bool
    {
        return $this->promo;
    }

    /**
     * @param bool|null $promo
     * @return ProductSearch
     */
    public function setPromo(bool $promo): ProductSearch
    {
        $this->promo = $promo;
        return $this;
    }

}