<?php
require '../vendor/autoload.php';
require_once(DIRNAME(__FILE__) . '/class.callController.php');
require_once(DIRNAME(__FILE__) . '/../traits/trait.debug.php');

use \Curl\Curl;
use PHPOnCouch\Couch, 
    PHPOnCouch\CouchAdmin, 
    PHPOnCouch\CouchClient,
    PHPOnCouch\CouchDocument; 

class couchDBController {

    protected $database = null;
    protected $curlObject = null;
    
    function __construct() {
    	try {
    		// Set a new connector to the CouchDB server
			$this->database = new CouchClient('http://192.168.99.100:32769', 'metrodb_cache');	
    	} catch (Exception $e) {
    		return json_encode($e);
    	}
    	
    }

    public function getDatabaseList() {
    	$databases = $this->database->listDatabases();
    	
    	return $databases;
    }

    public function createNewCacheDocument($id, $data) {
    	//using couch_document class :
		try {
			$doc = new CouchDocument($this->database);
			$doc->set(array('_id' => $id, 'data' => $data)); //create a document and store it in the database

		} catch (Exception $e) {
			return json_encode($e);
		}

		return 'Document succesfully cached';
    }

}