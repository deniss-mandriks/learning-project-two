<?php

namespace App\Objects;

use Carbon\Carbon;

class QuoteSummary
{

    private $id;
    private $userName;
    private $password;
    private $phoneNumber;
    private $productName;
    private $productTypeId;
    private $productType;
    private $pricePerDay;
    private $pricePerHour;
    private $pricePerItem;
    private $startDate;
    private $endDate;
    private $startTime;
    private $endTime;
    private $dayOfWeek;
    private $weekCount;
    private $quantity;
    private $totalPrice;

    public function __construct(
        int $id,
        string $userName,
        string $password,
        string $phoneNumber,
        string $productName,
        int $productTypeId,
        string $productType,
        float $pricePerDay = null,
        float $pricePerHour = null,
        float $pricePerItem = null,
        string $startDate = null,
        string $endDate = null,
        int $startTime = null,
        int $endTime = null,
        string $dayOfWeek = null,
        int $weekCount = null,
        int $quantity = null,
        float $totalPrice
    ){
        $this->id = $id;
        $this->userName = $userName;
        $this->password = $password;
        $this->phoneNumber = $phoneNumber;
        $this->productName = $productName;
        $this->productTypeId = $productTypeId;
        $this->productType = $productType;
        $this->pricePerDay = $pricePerDay;
        $this->pricePerHour = $pricePerHour;
        $this->pricePerItem = $pricePerItem;
        $this->totalPrice = $totalPrice;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->dayOfWeek = $dayOfWeek;
        $this->weekCount = $weekCount;
        $this->quantity = $quantity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getProductTypeId(): int
    {
        return $this->productTypeId;
    }

    public function getProductType(): string
    {
        return $this->productType;
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

    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

    public function getStartDate(): ?Carbon
    {
        return !is_null($this->startDate) ? Carbon::createFromFormat('Y-m-d', $this->startDate, TIMEZONE)->startOfDay() : null;
    }

    public function getEndDate(): ?Carbon
    {
        return !is_null($this->endDate) ? Carbon::createFromFormat('Y-m-d', $this->endDate, TIMEZONE)->startOfDay() : null;
    }

    public function getStartTime(): ?Carbon
    {
        return !is_null($this->startTime) ? Carbon::createFromTime($this->startTime,0,0, TIMEZONE) : null;
    }

    public function getEndTime(): ?Carbon
    {
        return !is_null($this->endTime) ? Carbon::createFromTime($this->endTime,0,0, TIMEZONE) : null;
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