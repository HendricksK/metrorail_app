<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require(DIRNAME(__FILE__) . '../../vendor/autoload.php');
require(DIRNAME(__FILE__) . '../../controller/class.metroRailController.php');
require(DIRNAME(__FILE__) . '../../controller/class.myCitiController.php');
require(DIRNAME(__FILE__) . '../../controller/class.goldenArrowController.php');
require(DIRNAME(__FILE__) . '../../controller/class.transportUpdateController.php');

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$c = new \Slim\Container($configuration);

$app = new \Slim\App($c);

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

/**
 * All of the Golden Arrow api calls
 */

$app->get('/goldenarrow/routes', function (Request $request, Response $response) {
    
    $goldenArrowController = new goldenArrowController();
    $response->getBody()->write($goldenArrowController->getAllRoutes());

    return $response;
});

$app->get('/goldenarrow/stops/{id}', function (Request $request, Response $response) {
    $lineId = $request->getAttribute('id');
    $goldenArrowController = new goldenArrowController();
    $response->getBody()->write($goldenArrowController->getStopsByRoute($lineId));

    return $response;
});

$app->get('/goldenarrow/stop/{id}', function (Request $request, Response $response) {
    $lineId = $request->getAttribute('id');
    $goldenArrowController = new goldenArrowController();
    $response->getBody()->write($goldenArrowController->getStopDetails($lineId));

    return $response;
});

$app->get('/goldenarrow/all-updates/{id}', function (Request $request, Response $response) {
    $lineId = $request->getAttribute('id');
    $goldenArrowController = new goldenArrowController();
    $response->getBody()->write($goldenArrowController->getAllDetailsForRoute($lineId));

    return $response;
});

$app->post('/metrorail/insert', function (Request $request, Response $response) {

    $queryParams = $request->getParsedBody();

    $transportId = $queryParams['transport_id'];
    $transportDetails = $queryParams['transport_details'];

    $transportUpdatesController = new transportUpdatesController();

    $data = array(
        'transport_id' => $transportId,
        'transport_details' => $transportDetails
    );

    $response->getBody()->write($transportUpdatesController->insertTransportData($data));

    return $response;
});

$app->run();