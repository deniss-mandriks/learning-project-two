<?php

namespace App\Objects;

use App\Objects\ProductType;

class Product
{

    private $id;
    private $name;
    private $productType;

    public function __construct(
        int $id,
        string $name,
        ProductType $productType = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->productType = $productType;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProductType(): ?ProductType
    {
        return $this->productType;
    }
}