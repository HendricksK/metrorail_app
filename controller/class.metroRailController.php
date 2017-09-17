<?php

require_once(DIRNAME(__FILE__) . '/class.callController.php');

class metroRailController {
	
	protected $callController = null;

	function __construct() {
		$this->callController = new callController();
	}

	public function getSampleData() {
		// https://proserver.gometro.co.za/api/v1/rail/routes
		$response = $this->callController->getData('https://proserver.gometro.co.za/api/v1/rail/routes');

		if(empty($response->response)) {
			return false;
		}

		return $response;
	}

}