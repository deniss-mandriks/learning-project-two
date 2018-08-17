<?php

namespace App\Services;

use Carbon\Carbon;

class FormValidationService
{

    private $allowedDaysOfWeek;
    private $sessionService;
    private $productService;

    public function __construct()
    {
        $this->allowedDaysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $this->sessionService = new SessionService();
        $this->productService = new ProductService();
    }

    public function validateStage($stage): bool
    {
        if (is_numeric($stage) && $stage > 0 && $stage <= 3) {
            return true;
        }

        return false;
    }

    public function getAllowedDaysOfWeekForServiceTypeOfProduct(): array
    {
        return $this->allowedDaysOfWeek;
    }

    public function isValidatedStageOne(array $input): bool
    {
        if(
            !$this->validateName($input['name'])
            || !$this->validatePassword($input['password'])
            || !$this->validateEmail($input['email'])
            || !$this->validatePhoneNumber($input['phoneNumber'])
        ) {
            return false;
        }

        return true;
    }

    public function isValidatedStageTwo(array $input): bool
    {
        return $this->validateNumeric($input['productId']);
    }

    public function isValidatedStageThree(array $input): bool
    {
        $product = $this->productService->get($this->sessionService->get('productId'));

        switch ($product->getProductType()->getId()) {
            case SUBSCRIPTION_PRODUCT_TYPE_ID:
                return $this->validateSubscriptionProductType($input);
            case SERVICES_PRODUCT_TYPE_ID:
                return $this->validateServicesProductType($input);
            case GOODS_PRODUCT_TYPE_ID:
                return $this->validateGoodsProductType($input);
            default:
            return false;
        }

    }

    private function validateSubscriptionProductType(array $input): bool
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $input['startDate'], TIMEZONE)->startOfDay();
        $endDate = Carbon::createFromFormat('Y-m-d', $input['endDate'], TIMEZONE)->startOfDay();

        return $endDate->greaterThan($startDate);
    }

    private function validateServicesProductType(array $input): bool
    {
        $earliestTimeAllowed = Carbon::createFromTime(9, 0, 0, TIMEZONE);
        $latestTimeAllowed = Carbon::createFromTime(19, 0, 0, TIMEZONE);

        $startTime = Carbon::createFromTime($input['startTime'],0,0, TIMEZONE);
        $endTime = Carbon::createFromTime($input['endTime'],0,0, TIMEZONE);

        if (
            !in_array($input['dayOfWeek'], $this->getAllowedDaysOfWeekForServiceTypeOfProduct())
            || $startTime->greaterThan($endTime)
            || !$startTime->between($earliestTimeAllowed, $latestTimeAllowed->addHour())
            || !$endTime->between($earliestTimeAllowed->addHour(), $latestTimeAllowed)
            || !$this->validateNumeric($input['weekCount'])
        ) {
            return false;
        }

        return true;
    }

    private function validateGoodsProductType($input): bool
    {
        return $this->validateNumeric($input['quantity']);
    }

    private function validateName(string $string): bool
    {
        return preg_match('/^[a-zA-Z ]+$/', $string);
    }

    private function validatePassword(string $password): bool
    {
        return preg_match('/^[\w\W\s\d]+$/', $password);
    }

    private function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function validatePhoneNumber(string $phoneNumber): bool
    {
        return preg_match('/^0[1-278]{1}[\d]{8,15}$/', $phoneNumber);
    }

    private function validateNumeric(int $number): bool
    {
        return is_numeric($number);
    }
}