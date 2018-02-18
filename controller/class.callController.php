<?php
require '../vendor/autoload.php';

use \Curl\Curl;

class callController {

	protected $curlObject = null;

	function __construct() {
		$this->curlObject = new Curl();
	}

	public function getData($url) {
		$response = $this->curlObject->get($url);
		
		if(empty($response->response)) {
			return false;
		}

		return $response->response;
	}

}