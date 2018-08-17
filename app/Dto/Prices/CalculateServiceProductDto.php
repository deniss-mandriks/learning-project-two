<?php

namespace App\Dto\Prices;

class CalculateServiceProductDto
{

    private $startTime;
    private $endTime;
    private $dayOfWeek;
    private $weekCount;
    private $pricePerHour;

    public function __construct(
        string $startTime,
        string $endTime,
        string $dayOfWeek,
        int $weekCount,
        float $pricePerHour
    ) {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->dayOfWeek = $dayOfWeek;
        $this->weekCount = $weekCount;
        $this->pricePerHour = $pricePerHour;
    }

    public function getStartTime(): string
    {
        return $this->startTime;
    }

    public function getEndTime(): string
    {
        return $this->endTime;
    }

    public function getDayOfWeek(): int
    {
        return $this->dayOfWeek;
    }

    public function getWeekCount(): int
    {
        return $this->weekCount;
    }

    public function getPricePerHour(): float
    {
        return $this->pricePerHour;
    }
}