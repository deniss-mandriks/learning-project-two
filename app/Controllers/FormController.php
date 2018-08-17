<?php

namespace App\Controllers;

use App\Services\FormService;
use App\Services\FormValidationService;
use App\Services\ProductService;
use App\Services\SessionService;
use Jenssegers\Blade\Blade;

class FormController
{

    const LAST_STAGE_INDEX = 3;

    private $blade;
    private $sessionService;
    private $formService;
    private $formValidationService;
    private $productService;
    private $stage;

    function __construct()
    {
        $this->blade = new Blade(['.\resources\views'], '.\resources\cache');
        $this->sessionService = new SessionService();
        $this->formService = new FormService();
        $this->formValidationService = new FormValidationService();
        $this->productService = new ProductService();
        $this->stage = 1;
    }

    public function index()
    {
        $viewData = [
            'stage' => $this->stage
        ];

        switch ($this->getStage()) {
            case 1:
                $this->sessionService->flush();
                break;
            case 2:
                $viewData['products'] = $this->productService->getAll();
                break;
            case 3:
                $selectedProduct = $this->productService->get($this->sessionService->get('productId'));
                $viewData['selectedProductTypeId'] = $selectedProduct->getProductType()->getId();

                if ($selectedProduct->getProductType()->getId() === SERVICES_PRODUCT_TYPE_ID) {
                    $viewData['allowedDaysOfWeek'] = $this->formValidationService
                        ->getAllowedDaysOfWeekForServiceTypeOfProduct();
                }

                break;
        }

        echo $this->blade->make('form', $viewData);
    }

    public function submit()
    {
        $input = $this->getInput();

        if (!$this->formValidationService->validateStage($input['stage'])) {
            throw new \Exception('Wrong stage');
        }

        switch ($input['stage']) {
            case 1:
                $validation = $this->formValidationService->isValidatedStageOne($input);
                break;
            case 2:
                $validation = $this->formValidationService->isValidatedStageTwo($input);
                break;
            case 3:
                $validation = $this->formValidationService->isValidatedStageThree($input);
                break;
            default:
                $validation = false;
                break;
        }

        if (!$validation) {
            throw new \Exception("Validation of stage '{$input['stage']}' failed");
        }

        $this->sessionService->setArray($input);
        $this->setStage(++$input['stage']);

        if ($this->isLastStage()) {
            return $this->complete();
        }

        return $this->index();
    }


    private function complete()
    {
        $quoteSummary = $this->formService->saveAndGetSummary($this->sessionService->all());

        $this->sessionService->flush();

        echo $this->blade->make('form-complete', [
            'quoteSummary' => $quoteSummary
        ]);
    }

    private function isLastStage(): bool
    {
        return $this->getStage() > self::LAST_STAGE_INDEX;
    }

    private function getStage(): int
    {
        return $this->stage;
    }

    private function setStage(int $stage): void
    {
        $this->stage = $stage;
    }

    private function getInput(): array
    {
        $input = [];

        foreach ($_POST as $key => $value) {
            $input[$key] = $value;
        }

        return $input;
    }
}