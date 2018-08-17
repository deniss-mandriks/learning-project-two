<?php

namespace App\Dto;

class AddQuote
{

    private $productId;
    private $quoteAttributesId;
    private $userId;
    private $phoneNumber;

    public function __construct(int $productId, int $quoteAttributesId, int $userId, string $phoneNumber)
    {
        $this->productId = $productId;
        $this->quoteAttributesId = $quoteAttributesId;
        $this->userId = $userId;
        $this->phoneNumber = $phoneNumber;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuoteAttributesId(): int
    {
        return $this->quoteAttributesId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }
}