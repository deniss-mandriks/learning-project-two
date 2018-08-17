<?php

namespace App\Objects;

class ProductType
{

    private $id;
    private $name;
    private $pricePerDay;
    private $pricePerHour;
    private $pricePerItem;

    public function __construct(
        int $id,
        string $name,
        float $pricePerDay = null,
        float $pricePerHour = null,
        float $pricePerItem = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->pricePerDay = $pricePerDay;
        $this->pricePerHour = $pricePerHour;
        $this->pricePerItem = $pricePerItem;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPricePerDay(): ?float
    {
        return $this->pricePerDay;
    }

    public function getPricePerHour(): ?float
    {
        return $this->pricePerHour;
    }

    public function getPricePerItem(): ?float
    {
        return $this->pricePerItem;
    }
}