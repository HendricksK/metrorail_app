<?php

trait debug {
	
	public function displayDebugData($data) {
		
		if(count($data) > 0) {
			echo '<pre>';
			print_r($data);
			echo '</pre>';
			
			return true;	
		}

		echo '<pre>';
		echo $data;
		echo '</pre>';
		
		return true;
	}
}