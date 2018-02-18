<?php

require_once(DIRNAME(__FILE__) . '/class.callController.php');
require_once(DIRNAME(__FILE__) . '/../traits/trait.debug.php');

class metroRailController {

	use debug;

	protected $callController = null;

	function __construct() {
		$this->callController = new callController();
	}

	/**
	 * [getSampleData basic function created to test API
	 * can be used for test classes as well, will be implemented
	 * at a later stage]
	 * @return [json] [returns response from metrorail API]
	 */
	public function getSampleData() {
		// https://proserver.gometro.co.za/api/v1/rail/routes
		$response = $this->callController->getData('https://proserver.gometro.co.za/api/v1/rail/routes');

		if(empty($response)) {
			return false;
		}

		return $response;
	}

	/**
	 * [getAllRoutes returns all the routes from the metrorail API]
	 * @return [json] [returns all routes from metrorail API]
	 */
	public function getAllRoutes() {
		// https://proserver.gometro.co.za/api/v1/rail/routes
		$response = $this->callController->getData('https://proserver.gometro.co.za/api/v1/rail/routes');

		if(empty($response)) {
			return false;
		}

		return $response;
	}

	/**
	 * [getStopsByRoute returns the stops for a 
	 * specified route id]
	 * @param  [string] $routeId [ID for the route, 
	 * we want stops from]
	 * @return [json]        [returns all the stops
	 * for the specified route]
	 */
	public function getStopsByRoute($routeId) {
		// http://proserver.gometro.co.za/api/v1/rail/routes/13:90000160/stops
		// http://proserver.gometro.co.za/api/v1/rail/routes/<routeid>/stops
		$response = $this->callController->getData('https://proserver.gometro.co.za/api/v1/rail/routes/' . $routeId . '/stops');

		if(empty($response)) {
			return false;
		}

		return $response;
	}

	/**
	 * [getStopDetails return the details for the stop specified]
	 * @param  [string] $routeId [the route id]
	 * @return [json]          [returns the stop details for the 
	 * specified stop]
	 */
	public function getStopDetails($stopId) {
		// http://proserver.gometro.co.za/api/v1/rail/stop/13:f12
		// http://proserver.gometro.co.za/api/v1/rail/stop/<id>
		$response = $this->callController->getData('https://proserver.gometro.co.za/api/v1/rail/stop/' . $stopId);

		if(empty($response)) {
			return false;
		}

		return $response;
	}

	/**
	 * [getLineUpdates return line updates: NB not working correctly at the moment]
	 * @param  [type] $routeId []
	 * @return [type]          [description]
	 */
	public function getLineUpdates($stopId) {
		// http://proserver.gometro.co.za/api/v1/rail/lineupdates
		// http://proserver.gometro.co.za/api/v1/rail/lineupdates/<id>
		$response = $this->callController->getData('https://proserver.gometro.co.za/api/v1/rail/lineupdates');

		if(empty($response)) {
			return false;
		}

		var_dump(json_decode($response));

		return $response;
	}

	/**
	 * NB this needs to run as cron and rather pull data from a database,
	 * request takes way too long
	 * [getAllDetailsForRoute returns route, as well as all stops on the route]
	 * @param  [type] $routeId [description]
	 * @return [type]          [description]
	 */
	public function getAllDetailsForRoute($routeId) {

		$stops = null;
		$response = new stdClass();
		$response->route = json_decode($this->getStopsByRoute($routeId));
		$response->stops = array();

		if(empty($response)) {
			return false;
		}

		$stops = $response->route;
		$counter = 0;

		foreach($stops as $stop) {
			$response->stops[$counter++] = json_decode($this->getStopDetails($stop->id));
		}
		
		return json_encode($response);
	}
}