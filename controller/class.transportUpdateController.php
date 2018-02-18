<?php
require '../vendor/autoload.php';
require_once(DIRNAME(__FILE__) . '/class.callController.php');
require_once(DIRNAME(__FILE__) . '/../traits/trait.debug.php');

use Medoo\Medoo;

class transportUpdatesController {

	use debug;

	protected $callController = null;
	protected $database = null;

	function __construct() {
		$this->callController = new callController();
		// Initialize
		// will call the username and password from
		// a config file that will be saved/locally
		
		try {
			$this->database = new mysqli('127.0.0.1', 'root', 'root', 'transport_metrorail');
		} catch (Exception $e) {
			return json_encode($e);
		}
			
	}

	/**
	 * [insertTransportData inserts data into
	 * the transport data]
	 * @param  [type] $data [data set being inserted]
	 * @return [type]       [whether the insert went
	 * or not json]
	 */
	public function insertTransportData($data) {

		try {

			$sql = "INSERT INTO metrorail_updates
				(date_created, train_id, line_id, update_text, status, sessionid, date_updated, arrival_time, station)
				VALUES(CURRENT_TIMESTAMP, '0175', 0, 'a random update', 0, 'session789456FGFDGDF', null, null, 0)";
			
			$update = $this->database->query($sql);

			$this->database->close();

			return json_encode($update);

			//will need to check medoo to see what we can get back after the insert
			//like the ID of the inserted record and then return a message to say the insert was
			//successful

			// return 'Your input is appreciated';

		} catch (Exception $e) {
			return json_encode($e);
		}

	}

	/**
	 * [retrieveAllTransportData returns all data
	 * from the transport_update,
	 * based on a sepcfic date]
	 * @return [type] [description]
	 */
	public function retrieveAllTransportData() {

		$time = strtotime('-30 minutes');
		$date = date('Y-m-d H:i:s', $time);

		try {

			$sql = "SELECT id, date_created, train_id, line_id, update_text, status, sessionid, date_updated, arrival_time, station
				FROM metrorail_updates WHERE date_created > '" . $date . "'";
			
			$data = $this->database->query($sql);

			$result = array();

			if(mysqli_num_rows($data) > 0) {
				while($row = $data->fetch_array()) {
					$result[] = $row;
				}
			}

			$this->database->close();

			return json_encode($result);

		} catch (Exception $e) {
			return json_encode($e);
		}
	}

	public function retrieveTransportDataForLocation($locatonName, $transportType) {

	}
	
}