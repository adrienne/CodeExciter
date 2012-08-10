<?php

class Auth
{
	private $ci;
	private $password_driver;
	
	public function __construct() {
		$this->ci = &get_instance();

		// load the password driver
		$driver_name = 'Bcrypt2';
		
		require(sprintf('%s/libraries/%s_driver.php', APPPATH, $driver_name));
		
		$this->password_driver = new $driver_name();
	}
	
	public function check() {
		return $this->ci->session->userdata('user_id');
	}
	
	public function login($username, $password) {
		// find an account with that username/password
		$user = new User();
		$user->get_by_username_email($username);
			 
		if($this->password_driver->check_password($password, $user->password) && $user->result_count())
		{
			// set user to logged in, with group
			$this->ci->session->set_userdata('user_id', $user->id);
			$this->ci->session->set_userdata('user_group', $user->group);
			
			// save ip and log in dates
			$user->last_login = $user->this_login;
			$user->this_login  = date(MYSQL_DATE_FORMAT);
			$user->ip = $this->ci->input->ip_address();
			$user->save();
			
			return true;
		}
		else 
		{
			// clean up by clearing session
			$this->logout();		
			return false;	
		}
	}
	
	public function logout() {
		$this->ci->session->unset_userdata('user_id');		
	}
	
	public function check_password($password, $stored_hash) {
		// check the stored password
		if($this->password_driver->check_password($password, $stored_hash))
		{
			return true;
		}
		
		return false;
	}
	
	public function get_hash($password) {
		return $this->password_driver->hash_password($password);
	}
}