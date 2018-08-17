<?php

namespace App\Dto\Prices;

class CalculateGoodsProductDto
{

    private $quantity;
    private $pricePerItem;

    public function __construct(int $quantity, float $pricePerItem)
    {
        $this->quantity = $quantity;
        $this->pricePerItem = $pricePerItem;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPricePerItem(): float
    {
        return $this->pricePerItem;
    }
}