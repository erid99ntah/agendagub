<?php defined('BASEPATH') OR exit('No direct script access allowed');

$this->ci =& get_instance();
$this->ci->load->model(array('signin/model_auth_signin'));
$this->username 	= addslashes(html_escape(trim($this->ci->session->userdata('account_name'))));
$this->ip_address = addslashes($this->ci->input->ip_address());
$this->user_agent = addslashes($this->ci->input->user_agent());

$statuslog	= $this->ci->model_auth_signin->cekSessionLog($this->username, $this->ip_address, $this->user_agent, session_id());
if(empty($this->username) && $statuslog == 0){
	$this->ci->load->view('errors/html/show_404_a');
}else{
	echo "Alamat url salah";
}
