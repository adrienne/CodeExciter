<?php

class MY_Unit_test extends CI_Unit_test {
	
	/**
	 * Run all the tests and display out put
	 * 
	 * @param object $test_case
	 */
	public function run_all(&$test_case) {
		
		// get list of all the calling classes methods
		$tests = get_class_methods($test_case);
		
		// make sure there are some
		if(!count($tests)) { 
			show_error(sprintf('No methods found in class "%s"', $test_case));
		}
		
		// do we have a set_up and tear_down
		$set_up = in_array('set_up', $tests);
		$tear_down = in_array('tear_down', $tests);
		
		// find methods that start with 'test' and run them
		foreach($tests as &$test) {
			if(substr($test, 0, 4) == 'test') {
				// do we have a setUp
				if($set_up) {
					$test_case->set_up();
				}
				
				// run the test
				$test_case->$test();
				
				// do we have a tearDown
				if($set_up) {
					$test_case->tear_down();
				}
			}
		}
		
		// generate report and set it as output
		$this->report();
	}
	
	/**
	 * Show the report
	 */
	public function report() {
		$report = parent::report();
		
		$ci = &get_instance();
		$ci->view = false;
		$ci->output->set_output($report);
	}
}