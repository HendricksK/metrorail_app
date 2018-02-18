<?php

trait debug {
	
	public function displayDebugData($data) {
		
		if(count($data) > 0) {
			echo '<pre>';
			print_r($data);
			echo '</pre>';
			
			die;
		}

		echo '<pre>';
		echo $data;
		echo '</pre>';
		
		die;
	}
}