<?

class Blah extends MY_Controller {
	
	public function index() {
		$this->load->library('unit_test');
		$this->unit->run_all($this);
	}
	
	public function test_thing() {
		$this->load->library('unit_test');
		$this->unit->run('hello', 'is_string', 'Make sure hash "hello" is string');
	}
}
