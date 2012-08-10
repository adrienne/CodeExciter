<?php

class MY_Output extends CI_Output {
	
	/** 
	 * Output JSON data - useful for APIs
	 */ 
	public function json($data) {
		// set the view to false as we're outputting raw data
		$ci = &get_instance();
		$ci->view = false;
		
		header('Content-type: application/x-javascript');
		
		$this->set_output(json_encode($data));
	}
}
