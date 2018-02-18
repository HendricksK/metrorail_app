<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require(DIRNAME(__FILE__) . '../../vendor/autoload.php');
require(DIRNAME(__FILE__) . '../../controller/class.metroRailController.php');
require(DIRNAME(__FILE__) . '../../controller/class.myCitiController.php');
require(DIRNAME(__FILE__) . '../../controller/class.goldenArrowController.php');
require(DIRNAME(__FILE__) . '../../controller/class.transportUpdateController.php');
require(DIRNAME(__FILE__) . '../../controller/class.couchDBController.php');
require(DIRNAME(__FILE__) . '../../controller/class.multiModalRoutingController.php');

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
    
    $response->
        getBody()->
        write('
            <h1>These are the routes that should work</h1>
            <ul style="list-style-type: none;">
                <li>GET: <a href="/metrorail/routes">/metrorail/routes</a></li>
                <li>GET: <a href="/metrorail/stops/13:90000160">/metrorail/stops/{id}</a></li>
                <li>GET: <a href="/metrorail/stop/13:12">/metrorail/stop/{id}</a></li>
                <li>GET: <a href="/metrorail/all-updates/13:f12">/metrorail/all-updates/{id}</a></li>
                <li>GET: <a href="/metro/multi-modal">/metro/multi-modal</a></li>
                <li>GET: <a href="metrorail/routes">metrorail/routes</a></li>
            <ul>');
        
        return $response;
});

$app->get('/api-map', function (Request $request, Response $response) {
    
    $response->
        getBody()->
        write('
            <h1>These are the routes that should work</h1>
            <ul style="list-style-type: none;">
                <li>GET: <a href="/metrorail/routes">/metrorail/routes</a></li>
                <li>GET: <a href="/metrorail/stops/13:90000160">/metrorail/stops/{id}</a></li>
                <li>GET: <a href="/metrorail/stop/13:12">/metrorail/stop/{id}</a></li>
                <li>GET: <a href="/metrorail/all-updates/13:f12">/metrorail/all-updates/{id}</a></li>
                <li>GET: <a href="/metro/multi-modal">/metro/multi-modal</a></li>
                <li>GET: <a href="metrorail/routes">metrorail/routes</a></li>
            <ul>');
        
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

$app->post('/metrorail/makeupdate', function (Request $request, Response $response) {

    $queryParams = $request->getParsedBody();

    $transportUpdatesController = new transportUpdatesController();

    $data = array(
        'train_id' => 1
    );

    $response->getBody()->write($transportUpdatesController->insertTransportData($data));

    return $response;
});

$app->get('/metrorail/transportdata', function (Request $request, Response $response) {

    $transportUpdatesController = new transportUpdatesController();
    $response->getBody()->write($transportUpdatesController->retrieveAllTransportData());

    return $response;
});

$app->get('/metro/multi-modal', function(Request $request, Response $response) {
    $multiModalRoutingController = new multiModalRoutingController();
    $response = $multiModalRoutingController->testGetMultiModalRoute('random');
    return $response;
});

$app->post('/insert-metro-update', function (Request $request, Response $response) {
    $queryParams = $request->getParsedBody();

    if(!empty($queryParams['transport_id'])) {
        $transportUpdatesController = new transportUpdatesController();
        $response->getBody()->write($transportUpdatesController->insertTransportData($queryParams));
        //call insert controller, insert update into db
        //will need to add transport type.
        return $response;
    } else {
        $responseArray = array();
        $responseArray['data'] = 'null';
        $responseArray['error'] = '1';
        $responseArray['errorMessage'] = 'required data has not been produced';
        $responseArray['callBack'] = '/insert-metro-update';
        $responseArray['type'] = 'POST';
        return $responseArray;
    }
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

$app->get('/couchdb/test', function(Request $request, Response $response) {
    $couchDBController = new CouchDBController();
    $response = $couchDBController->getDatabaseList();

    return json_encode($response);
});

$app->get('/couchdb/cache', function(Request $request, Response $response) {
    $metroRailController = new metroRailController();
    $sampleData = $metroRailController->getSampleData();

    $couchDBController = new CouchDBController();
    $response = $couchDBController->createNewCacheDocument('sampleData2', $sampleData);
    
    return $response;
});

$app->get('/couchdb/update/cache', function(Request $request, Response $response) {
    $metroRailController = new metroRailController();
    $sampleData = $metroRailController->getSampleData();

    $couchDBController = new CouchDBController();
    $response = $couchDBController->updateCacheDocument('sampleData2', $sampleData);
    
    return $response;
});

$app->get('/couchdb/check/cache', function(Request $request, Response $response) {
    $metroRailController = new metroRailController();
    $sampleData = $metroRailController->getSampleData();

    $couchDBController = new CouchDBController();
    $response = $couchDBController->checkIfCacheExists('sampleData45');
    
    return $response;
});

$app->run();