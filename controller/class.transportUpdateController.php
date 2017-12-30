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
			$this->database = new Medoo([
				'database_type' => 'mysql',
				'database_name' => 'metrodb_updates',
				'server' => '127.0.0.1',
				'username' => 'root',
				'password' => 'root'
			]);	
		} catch (Exception $e) {
			return json_encode($e);
		}
			
	}

	/**
	 * `id` bigint(10) not null AUTO_INCREMENT,
	`insert_date` timestamp not null default current_timestamp,
	`transport_id` VARCHAR(20)not null default '0',
	`transport_time` timestamp not null default current_timestamp,
	`transport_details` VARCHAR(255) default null,
	`user_id` VARCHAR(255) default null,
	`transport_type`
	`transport_location`
	 */
	/**
	 * [insertTransportData inserts data into
	 * the transport data]
	 * @param  [type] $data [data set being inserted]
	 * @return [type]       [whether the insert went
	 * or not json]
	 */
	public function insertTransportData($data) {

		try {

			$this->database->insert('transport_updates', [
			    'insert_date' => date('Y-m-d H:i:s'),
			    'transport_id' => $data['transport_id'],
			    'transport_time' => date('Y-m-d H:i:s'),
			    'transport_details' => $data['transport_details'],
			    'user_id' => 0,
			    'transport_type' => $data['transport_type'],
			    'transport_location' => '1:12345'
			]);

			//will need to check medoo to see what we can get back after the insert
			//like the ID of the inserted record and then return a message to say the insert was
			//successful

			return 'Your input is appreciated';

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
	public function retrieveAllTransportData($date) {
		try {

			$data = $this->database->select('transport_updates', '*', 
				[
					'insert_date[>]' => $date
				]
			);
			return json_encode($data);

		} catch (Exception $e) {
			return json_encode($e);
		}
	}

	public function retrieveTransportDataForLocation($locatonName, $transportType) {

	}
	
}