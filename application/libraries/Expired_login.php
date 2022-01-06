<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of expired login class
 *
 * @author  Yogi Kaputra
 * @since   1.0
 *
 *
 */

class Expired_login {

  public function __construct()
  {
    $this->ci =& get_instance();
  }

  public function login_time() {
		$timeout = 60 * 3600; //dalam detik
    $session['expires_by'] =  time() + $timeout;
    $this->ci->session->set_userdata($session);
	}

	public function login_check() {
		$exp_time = $this->ci->session->userdata('expires_by');
		if (time() < $exp_time) {
			$this->login_time();
			return true;
		} else {
			$this->ci->session->unset_userdata('expires_by');
			return false;
		}
	}
}

// This is the end of WRC_AdminCont class
