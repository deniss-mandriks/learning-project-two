<?php

namespace App\Services;

use App\Dto\Prices\CalculateGoodsProductDto;
use App\Dto\Prices\CalculateServiceProductDto;
use App\Dto\Prices\CalculateSubscriptionProductDto;
use Carbon\Carbon;

class PriceService
{

    public function calculateQuotePrice(array $quote): float
    {
        switch ($quote['product_type_id']) {
            case SUBSCRIPTION_PRODUCT_TYPE_ID:
                $price = $this->calculateSubscriptionProduct(new CalculateSubscriptionProductDto(
                    $quote['start_date'],
                    $quote['end_date'],
                    $quote['price_per_day']
                ));
                break;
            case SERVICES_PRODUCT_TYPE_ID:
                $price = $this->calculateServiceProduct(new CalculateServiceProductDto(
                    $quote['start_time'],
                    $quote['end_time'],
                    $quote['day_of_week'],
                    $quote['week_count'],
                    $quote['price_per_hour']
                ));
                break;
            case GOODS_PRODUCT_TYPE_ID:
                $price = $this->calculateGoodsProduct(new CalculateGoodsProductDto(
                    $quote['quantity'],
                    $quote['price_per_item']
                ));
                break;
            default:
                throw new \Exception("Product type {$quote['product_type_id']} not found.");
        }

        return $price;
    }

    private function calculateSubscriptionProduct(CalculateSubscriptionProductDto $calculateSubscriptionProductDto): float
    {
        $workingDays = $this->getWorkingDaysAmountBetween(
            $calculateSubscriptionProductDto->getStartDate(),
            $calculateSubscriptionProductDto->getEndDate()
        );

        return $workingDays * $calculateSubscriptionProductDto->getPricePerDay();
    }

    private function calculateServiceProduct(CalculateServiceProductDto $calculateServiceProductDto): float
    {
        $hoursPerDay = $this->getHoursBetween(
            $calculateServiceProductDto->getStartTime(),
            $calculateServiceProductDto->getEndTime()
        );

        $price = $hoursPerDay
            * $calculateServiceProductDto->getWeekCount()
            * $calculateServiceProductDto->getPricePerHour();

        return $price;
    }

    private function calculateGoodsProduct(CalculateGoodsProductDto $calculateGoodsProductDto): float
    {
        return $calculateGoodsProductDto->getQuantity() * $calculateGoodsProductDto->getPricePerItem();
    }

    private function getWorkingDaysAmountBetween(string $from, string $to): int
    {
        $carbonFrom = Carbon::createFromFormat('Y-m-d', $from, TIMEZONE)->startOfDay();
        $carbonTo = Carbon::createFromFormat('Y-m-d', $to, TIMEZONE)->endOfDay();

        $result = $carbonFrom->diffInDaysFiltered(function(Carbon $date) {
            return !$date->isWeekend();
        }, $carbonTo);

        return $result;
    }

    private function getHoursBetween(string $from, string $to): int
    {
        $carbonFrom = Carbon::createFromTime($from,0,0, TIMEZONE);
        $carbonTo = Carbon::createFromTime($to,0,0, TIMEZONE);

        $result = $carbonFrom->diffInHours($carbonTo);

        return $result;
    }
}