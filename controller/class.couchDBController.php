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

    /**
     * [getDatabaseList retrievs list of current database]
     * @return [type] [reutnrs list of databases
     * json format from couchdb]
     */
    public function getDatabaseList() {
    	$databases = $this->database->listDatabases();
    	
    	return $databases;
    }

    /**
     * [createNewCacheDocument creates a new cache
     * for the specified id]
     * @param  [type] $id   [document id]
     * @param  [type] $data [document data]
     * @return [type]       [returns either success or
     * failure]
     */
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

    /**
     * [updateCacheDocument update cache for specified
     * ID]
     * @param  [type] $id   [cache ID]
     * @param  [type] $data [the data set being pushed
     * into the database]
     * @return [type]       [success of failure of the update
     * in json format]
     */
    public function updateCacheDocument($id, $data) {
    	// get the document
		try {
		    $doc = $this->database->getDoc($id);
		} catch (Exception $e) {
		    return json_encode("ERROR: ".$e->getMessage()." (".$e->getCode().")<br>\n");
		}

		// make changes
		$doc->data = 'nothing to see here';

		// update the document on CouchDB server
		try {
		    $response = $this->database->storeDoc($doc);
		} catch (Exception $e) {
		    return json_encode("ERROR: ".$e->getMessage()." (".$e->getCode().")<br>\n");
		}

		return json_encode($response->ok);
    }

    /**
     * [checkIfCacheExists will return a 
     * whether a document exists or not]
     * @param  [type] $id [id of the document]
     * @return [type]     [json]
     */
    public function checkIfCacheExists($id) {
    	// get the document
		try {
		    $doc = $this->database->getDoc($id);
		    if(!empty($doc)) {
		    	return $doc;
		    }
		} catch (Exception $e) {
		     if($e->getCode() === 404) {
		     	return json_encode(false);
		    } else {
		    	return json_encode("ERROR: " . $e->getMessage() . " " . $e->getCode());
		    }
		}

    }

}