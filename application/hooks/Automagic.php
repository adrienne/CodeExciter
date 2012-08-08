<?php

class Automagic {
	
	private $ci;
	private $config;
	
	public function __construct() {
		// get CI super object
		$this->ci =& get_instance();
	}

	public function display_override() {
		// load Automagic config file
		$this->ci->config->load('automagic', true);
		$this->config = $this->ci->config->item('automagic');
		
		// are we using custom layouts or views
		// defualt layout is defined in automagic config, use it if contoller::layout is not defined
		$layout = $this->config['layout_folder'].'/'.(isset($this->ci->layout) ? $this->ci->layout : $this->config['default_layout']);
		
		// if controller::view is not defined, get it from the standard 'controller/method'
		if(isset($this->ci->view)) {
			$view = $this->ci->view;
		}
		
		else {
			// Whats the controller and method names
			$view = $this->ci->router->fetch_directory().$this->ci->router->fetch_class().'/'.$this->ci->router->fetch_method();
		}
		
		// if the view was set to false then we don't load a view
		if($view) {
			$view_content = $this->ci->load->view($view, $this->ci->view_data, true);
			
			// add the layout content to the view data
			$this->ci->view_data['layout_content'] = $view_content;
			
			// now load the layout
			$layout_content = $this->ci->load->view($layout, $this->ci->view_data, true);
			
			$this->ci->output->set_output($layout_content);
		}
		
		echo $this->ci->output->get_output();
	}
}