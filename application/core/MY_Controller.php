<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH . "third_party/MX/Controller.php";

/**
 * Description of my_controller class
 *
 * @author Yogi "solop" Kaputra
 */

class MY_Controller extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (version_compare(CI_VERSION, '2.1.0', '<')) {
            $this->load->library('security');
        }
	}
}