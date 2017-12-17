<?php
require '../vendor/autoload.php';
require_once(DIRNAME(__FILE__) . '/class.callController.php');
require_once(DIRNAME(__FILE__) . '/../traits/trait.debug.php');

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException; 

class multiModalRoutingController {

	use debug;

	protected $callController = null;
	protected $baseUrl = null;
	protected $metroClient = null;

	function __construct() {
		$this->callController = new callController();
		$config = fopen('../config/config.json', 'r');
		$config = fread($config, filesize('../config/config.json'));
		$config = json_decode($config, true);
		$this->baseUrl = $config['config']['api']['metro-api']['url'];
		$this->metroClient = new GuzzleHttp\Client(['base_uri' => $this->baseUrl]);
	}

	/*
	test function to ensure that the API 
	is returning data, just here for now
	need to think of a way to come up with 
	a test model of some sort 
	 */
	function testGetMultiModalRoute($params) {
		$url = 'api/v1/accessibility/-33.903490/18.420468/150';
		$response = '';
		$error = '';
		$responseArray = array();

		try {
			$response = $this->metroClient->request('GET', $url);
			$responseArray['data'] = json_decode($response->getBody(), true);
			$responseArray['error'] = '0';
			$responseArray['errorMessage'] = 'null';
			$responseArray['callBack'] = '/metro/multi-modal';
			$responseArray['type'] = 'GET';
		} catch (RequestException $e) {
			$responseArray['data'] = 'null';
			$responseArray['error'] = '1';
			$responseArray['errorMessage'] = $e->getMessage();
			$responseArray['callBack'] = '/metro/multi-modal';
			$responseArray['type'] = 'GET';
		}
		
		return json_encode($responseArray);
	}

	function getMultiModalRoute($params) {

	}
}