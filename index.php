<?php
    session_start();

    // Including classes
    include_once '.\vendor\autoload.php';
    include_once 'Constants.php';
    include_once 'app\Controllers\FormController.php';
    include_once 'app\Services\FormValidationService.php';
    include_once 'app\Services\ProductService.php';
    include_once 'app\Services\SessionService.php';
    include_once 'app\Services\FormService.php';
    include_once 'app\Services\PriceService.php';
    include_once 'app\Dto\AddUserDto.php';
    include_once 'app\Dto\AddQuoteAttributesDto.php';
    include_once 'app\Dto\AddQuote.php';
    include_once 'app\Dto\Prices\CalculateServiceProductDto.php';
    include_once 'app\Dto\Prices\CalculateSubscriptionProductDto.php';
    include_once 'app\Dto\Prices\CalculateGoodsProductDto.php';
    include_once 'app\Objects\QuoteSummary.php';
    include_once 'app\Objects\Product.php';
    include_once 'app\Objects\ProductType.php';

    // In case one is using PHP 5.4's built-in server
    $filename = __DIR__ . preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
    if (php_sapi_name() === 'cli-server' && is_file($filename)) {
        return false;
    }

    require_once __DIR__ . '\vendor\bramus\router\src\Bramus\Router\Router.php';

    // Create a Router
    $router = new \Bramus\Router\Router();

    // Custom 404 Handler
    $router->set404(function () {
        header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
        echo '404, route not found!';
    });

    // Static route: / (homepage)
    $router->get('/', 'App\Controllers\FormController@index');
    $router->post('/submit', 'App\Controllers\FormController@submit');

    $router->run();