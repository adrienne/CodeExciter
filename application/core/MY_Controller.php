<?php

class MY_Controller extends CI_Controller
{
	public $layout = null;
	public $view = null;
	public $view_data = array();
	
	public function __construct() {
		parent::__construct();
		
		$this->view_data['scripts'] = array();
		$this->view_data['styles'] = array();
	}
	
	/**
	 * Wrapper to show error 404
	 */
	public function error_404() {
		$this->http_error(404);
	}
	
	/**
	 * Wrapper to show a error 403
	 */
	public function error_403() {
		$this->http_error(403);
	}
	
	/**
	 * Show an error
	 */
	public function http_error($code=500) {
		$this->output->set_status_header($code);
		
		$this->view = sprintf('errors/%d', $code);
	}
}