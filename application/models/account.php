<?php

/**
 * Authenticated accounts
 */
class Account extends DataMapper
{
	public $validation = array(
		'username'=>array(
			'label'=>'Username',
			'rules'=>array('required', 'unique')
		),
		'email'=>array(
			'label'=>'Email Address',
			'rules'=>array('required', 'valid_email', 'unique')
		),
		'password'=>array(
			'label'=>'Password',
			'rules'=>array('required')
		),
	);
	
	public function get_by_username_or_email($username_email) {
		$this->where('username', $username_email)
			 ->or_where('email', $username_email)
			 ->get();
	}
}