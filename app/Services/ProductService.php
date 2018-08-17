<?php

namespace App\Services;

use App\Objects\ProductType;
use App\Objects\Product;

class ProductService
{

    private $db;

    function __construct()
    {
        $this->db = new \SQLite3(DB_FILE_NAME, SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
    }

    public function getAll(): array
    {
        $statement = $this->db->prepare('SELECT p.id as product_id, p.name as product_name,
            pt.id as product_type_id, pt.name as product_type_name, 
            pt.price_per_day as price_per_day, 
            pt.price_per_hour as price_per_hour,
            pt.price_per_item as price_per_item
            FROM products as p 
            JOIN product_types as pt ON p.product_types_id = pt.id');
        $queryResult = $statement->execute();
        $result = [];

        while ($row = $queryResult->fetchArray(SQLITE3_ASSOC)) {
            array_push($result, $this->generateProductObject($row));
        }

        return $result;
    }

    public function get(int $productId): Product
    {
        $statement = $this->db->prepare('SELECT p.id as product_id, p.name as product_name,
              pt.id as product_type_id, pt.name as product_type_name, 
              pt.price_per_day as price_per_day, 
              pt.price_per_hour as price_per_hour,
              pt.price_per_item as price_per_item 
            FROM products as p 
            JOIN product_types as pt ON p.product_types_id = pt.id
            WHERE p.id = :product_id');
        $statement->bindValue(':product_id', $productId);

        return $this->generateProductObject($statement->execute()->fetchArray(SQLITE3_ASSOC));
    }

    private function generateProductObject(array $queryRow): Product
    {
        return new Product(
            $queryRow['product_id'],
            $queryRow['product_name'],
            new ProductType(
                $queryRow['product_type_id'],
                $queryRow['product_type_id'],
                $queryRow['price_per_day'],
                $queryRow['price_per_hour'],
                $queryRow['price_per_item']
            )
        );
    }
}