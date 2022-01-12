<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of home class
 *
 * @author Yogi "solop" Kaputra
 */

class Inbox extends SLP_Controller {
	protected $_limit = 0;
	public function __construct()
  {
    parent::__construct();
		$this->load->model(array('model_home' => 'mhome'));
		$this->_limit = 10;
  }

  public function listview()
	{
		if (!$this->input->is_ajax_request()) {
   		exit('No direct script access allowed');
		} else {
			$csrfHash = $this->security->get_csrf_hash();
      $session = $this->app_loader->current_account();
      if(isset($session)){
        $limit  = $this->_limit;
        $page   = escape($this->input->post('page', TRUE));
        $offset = ($page*$limit)-$limit;
        $dataMail = $this->mhome->getDataListNotification($limit, $offset);
				$result = array(
					'records' => (count($dataMail) > 0) ? $dataMail : array(),
					'recordsTotal' => (count($dataMail) > 0) ? $this->mhome->getCountAllNotification() : 0,
					'recordsFiltered'	=> (count($dataMail) > 0) ? ($offset+1).'-'.(($page*$limit > $this->mhome->getCountAllNotification()) ? $this->mhome->getCountAllNotification() : $page*$limit) : '0-0',
					'limit'	=> (int) $limit,
					'csrfHash' => $csrfHash
				);
				//output to json format
	      $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
		}
	}

	public function update()
	{
		if (!$this->input->is_ajax_request()) {
   		exit('No direct script access allowed');
		} else {
			$csrfHash = $this->security->get_csrf_hash();
      $session = $this->app_loader->current_account();
      if(isset($session)){
				$token = escape($this->input->post('token', TRUE));
        $dataMail = !empty($token) ? $this->mhome->updateDataNotificationByToken($token) : $this->mhome->updateDataNotificationAll();
				$result = array(
					'status'	 => ($dataMail==TRUE) ? 1 : 0,
					'message'	 => '',
					'csrfHash' => $csrfHash
				);
				//output to json format
	      $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
		}
	}

	public function delete()
	{
		if (!$this->input->is_ajax_request()) {
   		exit('No direct script access allowed');
		} else {
			$csrfHash = $this->security->get_csrf_hash();
      $session = $this->app_loader->current_account();
      if(isset($session)){
        $dataMail = $this->mhome->deleteDataNotification();
				$totData  = $this->mhome->getCountAllNotification();
				$result = array(
					'status'	 => ($dataMail==TRUE) ? 1 : 0,
					'message'	 => '',
					'totalRow' => (int) ($totData > 0) ? ceil($totData/$this->_limit) : 1,
					'csrfHash' => $csrfHash
				);
				//output to json format
	      $this->output->set_content_type('application/json')->set_output(json_encode($result));
      }
		}
	}

}

// This is the end of home clas
