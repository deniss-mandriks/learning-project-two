<?php

namespace App\Dto;

class AddQuoteAttributesDto
{

    private $startDate;
    private $endDate;
    private $startTime;
    private $endTime;
    private $dayOfWeek;
    private $weekCount;
    private $quantity;

    public function __construct(
        string $startDate = null,
        string $endDate = null,
        string $startTime = null,
        string $endTime = null,
        string $dayOfWeek = null,
        int $weekCount = null,
        int $quantity = null
    ) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->dayOfWeek = $dayOfWeek;
        $this->weekCount = $weekCount;
        $this->quantity = $quantity;
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function getStartTime(): ?string
    {
        return $this->startTime;
    }

    public function getEndTime(): ?string
    {
        return $this->endTime;
    }

    public function getDayOfWeek(): ?string
    {
        return $this->dayOfWeek;
    }

    public function getWeekCount(): ?int
    {
        return $this->weekCount;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }
}