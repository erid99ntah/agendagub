<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of hook Security Check class
 *
 * @author  Yogi Kaputra
 * @since   1.0
 *
 *
 */

// ------------------------------------------------------------------------

class Security_check
{
	public function __construct()
  {
    $this->ci =& get_instance();
		$this->ci->load->model(array('signin/model_auth_signin'));

		$this->username 	= addslashes($this->ci->session->userdata('account_name'));
		$this->session_id = $this->ci->session->userdata('EAgendaApp@2021Session');
		$this->ip_address = addslashes($this->ci->input->ip_address());
    $this->user_agent = addslashes($this->ci->input->user_agent());
  }

  function uri_check()
  {
    $module_access  = $this->ci->router->fetch_module();
    $class_access 	= $this->ci->router->fetch_class();
    $method_access  = $this->ci->router->fetch_method();

		$cekWhiteList = $this->ci->model_auth_signin->getDataWhiteList($module_access, $class_access, $method_access);
    if($cekWhiteList == FALSE){
      $statuslog	= $this->ci->model_auth_signin->cekSessionLog($this->username, $this->ip_address, $this->user_agent, $this->session_id);
      if(empty($this->username) OR $statuslog == FALSE){
        $this->ci->session->sess_destroy();
        redirect('signin/login');
        exit();
      }	else{
				$group = $this->ci->session->userdata('group_active');
        $user_rules = $this->ci->model_auth_signin->getDataUserRulesModule($this->username, $group);
        $uri_access = $module_access.'/'.$class_access.'/'.$method_access;
        if(!in_array($uri_access, $user_rules)){
          show_401();
					exit();
        }
			}
    }
  }
}


/* End of file Security_check.php */
/* Location: ./application/hook/Security_check.php */
