<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require(DIRNAME(__FILE__) . '../../vendor/autoload.php');

require(DIRNAME(__FILE__) . '../../controller/class.metroRailController.php');

$app = new \Slim\App;

$app->get('/', function (Request $request, Response $response) {
    
    $response->getBody()->write('Give me your location');

    return $response;
});

$app->get('/metrorail', function (Request $request, Response $response) {
    
    $metroRailController = new metroRailController();
    $response->getBody()->write('Metro Rail Routes' . '<br>' . $metroRailController->getSampleData());

    return $response;
});

$app->run();