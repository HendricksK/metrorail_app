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

$app->get('/sample', function (Request $request, Response $response) {
    
    $metroRailController = new metroRailController();
    $response->getBody()->write('Metro Rail Routes' . '<br>' . $metroRailController->getSampleData());

    return $response;
});

$app->get('/routes', function (Request $request, Response $response) {
    
    $metroRailController = new metroRailController();
    $response->getBody()->write($metroRailController->getAllRoutes());

    return $response;
});

$app->get('/stops/{id}', function (Request $request, Response $response) {
    $lineId = $request->getAttribute('id');
    $metroRailController = new metroRailController();
    $response->getBody()->write($metroRailController->getStopsByRoute($lineId));

    return $response;
});

$app->get('/stop/{id}', function (Request $request, Response $response) {
    $stopId = $request->getAttribute('id');
    $metroRailController = new metroRailController();
    $response->getBody()->write($metroRailController->getStopDetails($stopId));

    return $response;
});

$app->get('/all-updates/{id}', function (Request $request, Response $response) {
    $lineId = $request->getAttribute('id');
    $metroRailController = new metroRailController();
    $response->getBody()->write($metroRailController->getAllDetailsForRoute($lineId));

    return $response;
});

$app->run();