<?php

namespace App\Services;

use App\Dto\AddQuote;
use App\Dto\AddQuoteAttributesDto;
use App\Dto\AddUserDto;
use App\Objects\QuoteSummary;

class FormService
{

    private $db;
    private $priceService;

    public function __construct()
    {
        $this->db = new \SQLite3(DB_FILE_NAME, SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
        $this->priceService = new PriceService();
    }

    public function saveAndGetSummary(array $quote): QuoteSummary
    {
        $quoteId = $this->saveAndGetId($quote);
        $quoteDetails = $this->getQuote($quoteId);

        $totalPrice = $this->priceService->calculateQuotePrice($quoteDetails);

        $quoteSummary = new QuoteSummary(
            $quoteId,
            $quoteDetails['user_name'],
            $quoteDetails['user_password'],
            $quoteDetails['phone_number'],
            $quoteDetails['product_name'],
            $quoteDetails['product_type_id'],
            $quoteDetails['product_type'],
            $quoteDetails['price_per_day'],
            $quoteDetails['price_per_hour'],
            $quoteDetails['price_per_item'],
            $quoteDetails['start_date'],
            $quoteDetails['end_date'],
            $quoteDetails['start_time'],
            $quoteDetails['end_time'],
            $quoteDetails['day_of_week'],
            $quoteDetails['week_count'],
            $quoteDetails['quantity'],
            $totalPrice
        );

        return $quoteSummary;
    }

    public function saveAndGetId(array $quote): int
    {
        $this->db->exec('BEGIN');

        $userId = $this->addUserReturnId(new AddUserDto($quote['name'], $quote['password']));
        $quoteAttributesId = $this->addQuoteAttributesReturnId(new AddQuoteAttributesDto(
            $this->array_get($quote, 'startDate'),
            $this->array_get($quote, 'endDate'),
            $this->array_get($quote, 'startTime'),
            $this->array_get($quote, 'endTime'),
            $this->array_get($quote, 'dayOfWeek'),
            $this->array_get($quote, 'weekCount'),
            $this->array_get($quote, 'quantity')
        ));
        $this->addQuote(new AddQuote(
            $this->array_get($quote, 'productId'),
            $quoteAttributesId,
            $userId,
            $this->array_get($quote, 'phoneNumber')
        ));

        $this->db->exec('COMMIT');

        return $this->getLastInsertedId();
    }

    private function getQuote(int $id): array
    {
        $statement = $this->db->prepare('SELECT q.id, q.phone_number,
              u.name as user_name, u.password as user_password,
              qa.start_date, qa.end_date, qa.start_time, qa.end_time, qa.day_of_week, qa.week_count, qa.quantity,
              p.name as product_name,
              pt.id as product_type_id, pt.name as product_type, pt.price_per_day, pt.price_per_hour, pt.price_per_item
            FROM quotes as q
            JOIN products as p ON q.product_id = p.id
            JOIN product_types as pt ON p.product_types_id = pt.id
            JOIN quote_attributes as qa ON q.quote_attributes_id = qa.id
            JOIN users as u ON q.user_id = u.id
            WHERE q.id = :id');
        $statement->bindValue(':id', $id);

        return $statement->execute()->fetchArray(SQLITE3_ASSOC);
    }

    private function addUserReturnId(AddUserDto $addUserDto): int
    {
        $statement = $this->db->prepare('INSERT INTO users (name, password) 
            VALUES (:name, :password)');
        $statement->bindValue(':name', $addUserDto->getName());
        $statement->bindValue(':password', $addUserDto->getEncryptedPassword());
        $statement->execute();

        return $this->getLastInsertedId();
    }

    private function addQuoteAttributesReturnId(AddQuoteAttributesDto $addQuoteAttributesDto): int
    {
        $statement = $this->db->prepare('INSERT INTO quote_attributes (start_date, end_date, start_time, end_time, day_of_week, week_count, quantity) 
            VALUES (:start_date, :end_date, :start_time, :end_time, :day_of_week, :week_count, :quantity)');
        $statement->bindValue(':start_date', $addQuoteAttributesDto->getStartDate());
        $statement->bindValue(':end_date', $addQuoteAttributesDto->getEndDate());
        $statement->bindValue(':start_time', $addQuoteAttributesDto->getStartTime());
        $statement->bindValue(':end_time', $addQuoteAttributesDto->getEndTime());
        $statement->bindValue(':day_of_week', $addQuoteAttributesDto->getDayOfWeek());
        $statement->bindValue(':week_count', $addQuoteAttributesDto->getWeekCount());
        $statement->bindValue(':quantity', $addQuoteAttributesDto->getQuantity());
        $statement->execute();

        return $this->getLastInsertedId();
    }

    private function addQuote(AddQuote $addQuote): void
    {
        $statement = $this->db->prepare('INSERT INTO quotes (product_id, quote_attributes_id, user_id, phone_number) 
            VALUES (:product_id, :quote_attributes_id, :user_id, :phone_number)');
        $statement->bindValue(':product_id', $addQuote->getProductId());
        $statement->bindValue(':quote_attributes_id', $addQuote->getQuoteAttributesId());
        $statement->bindValue(':user_id', $addQuote->getUserId());
        $statement->bindValue(':phone_number', $addQuote->getPhoneNumber());
        $statement->execute();
    }

    private function getLastInsertedId(): int
    {
        return $this->db->lastInsertRowID();
    }

    private  function array_get(array $array, string $key, $default = null)
    {
        return isset($array[$key])? $array[$key] : $default;
    }
}