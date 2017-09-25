<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require(DIRNAME(__FILE__) . '../../vendor/autoload.php');
require(DIRNAME(__FILE__) . '../../controller/class.metroRailController.php');
require(DIRNAME(__FILE__) . '../../controller/class.myCitiController.php');

$app = new \Slim\App;

/**
 * All of the metrorail train API calls as well 
 * as some sample API calls
 */
$app->get('/', function (Request $request, Response $response) {
    
    $response->getBody()->write('Give me your location');

    return $response;
});

$app->get('/sample', function (Request $request, Response $response) {
    
    $metroRailController = new metroRailController();
    $response->getBody()->write('Metro Rail Routes' . '<br>' . $metroRailController->getSampleData());

    return $response;
});

$app->get('/metrorail/routes', function (Request $request, Response $response) {
    
    $metroRailController = new metroRailController();
    $response->getBody()->write($metroRailController->getAllRoutes());

    return $response;
});

$app->get('/metrorail/stops/{id}', function (Request $request, Response $response) {
    $lineId = $request->getAttribute('id');
    $metroRailController = new metroRailController();
    $response->getBody()->write($metroRailController->getStopsByRoute($lineId));

    return $response;
});

$app->get('/metrorail/stop/{id}', function (Request $request, Response $response) {
    $stopId = $request->getAttribute('id');
    $metroRailController = new metroRailController();
    $response->getBody()->write($metroRailController->getStopDetails($stopId));

    return $response;
});

$app->get('/metrorail/all-updates/{id}', function (Request $request, Response $response) {
    $lineId = $request->getAttribute('id');
    $metroRailController = new metroRailController();
    $response->getBody()->write($metroRailController->getAllDetailsForRoute($lineId));

    return $response;
});

/**
 * All of the MyCiti api calls
 */

$app->get('/myciti/routes', function (Request $request, Response $response) {
    
    $myCitiController = new myCitiController();
    $response->getBody()->write($myCitiController->getAllRoutes());

    return $response;
});

$app->get('/myciti/stops/{id}', function (Request $request, Response $response) {
    $lineId = $request->getAttribute('id');
    $myCitiController = new myCitiController();
    $response->getBody()->write($myCitiController->getStopsByRoute($lineId));

    return $response;
});

$app->get('/myciti/stop/{id}', function (Request $request, Response $response) {
    $lineId = $request->getAttribute('id');
    $myCitiController = new myCitiController();
    $response->getBody()->write($myCitiController->getStopDetails($lineId));

    return $response;
});

$app->get('/myciti/all-updates/{id}', function (Request $request, Response $response) {
    $lineId = $request->getAttribute('id');
    $myCitiController = new myCitiController();
    $response->getBody()->write($myCitiController->getAllDetailsForRoute($lineId));

    return $response;
});

$app->run();