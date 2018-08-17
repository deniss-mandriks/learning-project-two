<?php

namespace App\Dto\Prices;

class CalculateSubscriptionProductDto
{

    private $startDate;
    private $endDate;
    private $pricePerDay;

    public function __construct(string $startDate, string $endDate, float $pricePerDay)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->pricePerDay = $pricePerDay;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function getEndDate(): string
    {
        return $this->endDate;
    }

    public function getPricePerDay(): float
    {
        return $this->pricePerDay;
    }
}