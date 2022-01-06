<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Exceptions extends CI_Exceptions {

	function __construct(){
		parent::__construct();
	}

	/**
	 * 401 Not Authorized
	 *
	 * Called by
	 *
	 */
	function show_401()
	{
		$heading = "401 Not Authorized";
		$message = "You are not authorized to view this page.";
		echo $this->show_error($heading, $message, 'error_401',401);
		exit;
	}
}
