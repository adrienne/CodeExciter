<?php

class All extends MY_Controller {
	
	public function index() {
		
		$this->view = false;
		
		// find all the test cases in this directory
		// get the full path of this directory
		$this_path = dirname(__FILE__); 
		
		// find its files, and run any that are tests
		$tests = scandir($this_path);
		
		$this->output->append_output('<h1>Unit Tests</h1>');
		
		foreach($tests as $test) {
			// make sure it ends in php or this file (all_tests.php)
			if(substr($test, -4) == '.php' && $test != 'all.php') {
				// remove PHP from test name
				$test_name = substr($test, 0, -4);
				
				// output a header
				$this->output->append_output(sprintf('<h2>%s</h2>', $test_name));
				
				// remove the php and run it
				$this->output->append_output(file_get_contents(site_url('tests/'.$test_name)));
			}
		}
	}
}