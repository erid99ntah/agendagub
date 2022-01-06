<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of dprd class
 *
 * @author Kominfo
 */

class Dprd extends SLP_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('model_dprd' => 'mdprd'));
	}

	public function index()
	{
		$this->breadcrumb->add('Dashboard', site_url('home'));
		$this->breadcrumb->add('Manajemen', '#');
		$this->breadcrumb->add('Data Anggota DPRD', site_url('manajemen/dprd'));

		$this->session_info['page_name']    = "Data Anggota DPRD";
		$this->session_info['data_level']   = $this->mdprd->getDataLevelAkses();
		$this->session_info['data_group']	= $this->mdprd->getDataListGroup();
		$this->session_info['data_instansi']= $this->mdprd->getDataListInstansi();
		$this->template->build('form_dprd/list', $this->session_info);
	}

	public function listview()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$data = array();
			$session = $this->app_loader->current_account();
			if(isset($session)){
				$param = $this->input->post('param',TRUE);
				$dataUser = $this->mdprd->get_datatables($param);
				$no = $this->input->post('start');
				foreach ($dataUser as $key => $u) {
					$no++;
					$row = array();
					$arrGroup = explode(',', $u['group_user']);
					$nm_group = '<ul style="margin-left:-30px;">';
					foreach ($arrGroup as $g) {
						$nm_group .= '<li>'.$g.'</li>';
					}
					$nm_group .= '</ul>';
					$password = ($this->app_loader->is_admin()) ? '<li><strong>Password :</strong> Cek Akun Aspirasi</li>' : '';
					$row[] = '<input type="checkbox" name="checkid[]" value="'.$u['token'].'" onclick="event.stopPropagation();">';
					$row[] = $no;
					$row[] = '<ul class="list-unstyled" style="margin-bottom:0px;">'.
					'<li><strong>Username :</strong> '.$u['username'].'</li>'.
					$password.
					'</ul>';
					$row[] = $u['fullname'];
					$row[] = $nm_group;
					$row[] = $u['nm_jab_dprd'];
					$row[] = $u['nm_fraksi'].' - '.$u['nm_jab_fraksi'];
					$row[] = $u['nm_komisi'].' - '.$u['nm_jab_komisi'];
					
					$row[] = convert_blokir($u['blokir']);
					$row[] = convert_status($u['id_status']);
					$row[] = '<button type="button" class="btn btn-xs btn-orange btnEdit" data-token="'.$u['token'].'" title="Edit data user"><i class="fa fa-pencil"></i> </button>';
					$data[] = $row;
				}

				$output = array(
					"draw" => $this->input->post('draw'),
					"recordsTotal" => $this->mdprd->count_all(),
					"recordsFiltered" => $this->mdprd->count_filtered($param),
					"data" => $data,
					);
			}
			//output to json format
			echo json_encode($output);
		}
	}

	public function details()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			$token  	= escape($this->input->post('tokenId', TRUE));
			if(!empty($token) AND !empty($session)) {
				$data = $this->mdprd->getDataDetailUsers($token);
				$row = array();
				$row['fullname']	= !empty($data) ? $data['fullname'] : '';
				$row['username']	= !empty($data) ? $data['username'] : '';
				$row['id_opd']	= !empty($data) ? $data['id_opd'] : '';
				$row['sub_opd']	= !empty($data) ? $data['sub_opd'] : '';
				$row['nm_sub_opd']	= !empty($data) ? $data['nm_sub_opd'] : '';
				$row['email']		= !empty($data) ? $data['email'] : '';
				$row['blokir']		= !empty($data) ? $data['blokir'] : 0;
				$row['status']		= !empty($data) ? $data['id_status'] : 1;
				$row['groupid']		= !empty($data) ? explode(',', str_replace(' ', '', $data['group_user'])) : array();
				$result = array('status' => 1, 'message' => $row, 'csrfHash' => $csrfHash);
			} else {
				$result = array('status' => 0, 'message' => array(), 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	public function create()
	{
		/*if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			if(!empty($session)) 
			{
				
					$this->mdprd->insertDataUsers();
					if($data['message'] == 'ERROR') {
						$result = array('status' => 0, 'message' => array('isi' => ''), 'csrfHash' => $csrfHash);
					} else if($data['message'] == 'SUCCESS') {
						$result = array('status' => 1, 'message' => 'Data user <b>'.$data['note'].'</b> berhasil ditambahkan...', 'csrfHash' => $csrfHash);
					}
				
				$result = array('status' => 1, 'message' => 'Berhasil', 'csrfHash' => $csrfHash);
			} else {
				$result = array('status' => 0, 'message' => 'Proses input data gagal, mohon periksa data kembali...', 'csrfHash' => $csrfHash);
			}
			
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}*/		
		$data = $this->mdprd->insertDataUsers();
		

	}

	

	public function update()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			$token 		= escape($this->input->post('tokenId', TRUE));
			if(!empty($session) AND !empty($token)) {
				if($this->mdprd->validasiDataValue('edit') == FALSE) {
					$result = array('status' => 0, 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
				} else {
					$data = $this->mdprd->updateDataUsers();
					if($data['message'] == 'NODATA') {
						$result = array('status' => 0, 'message' => array('isi' => 'Data user <b>'.$data['note'].'</b> gagal diupdate karena data tidak ditemukan, silahkan periksa kembali...'), 'csrfHash' => $csrfHash);
					}	else if($data['message'] == 'ERROR') {
						$result = array('status' => 0, 'message' => array('isi' => 'Proses update data <b>'.$data['note'].'</b> gagal, karena username yang diinputkan sudah ada yang menggunakan, silakan inputkan username lain...'), 'csrfHash' => $csrfHash);
					} else if($data['message'] == 'SUCCESS') {
						$result = array('status' => 1, 'message' => 'Data user <b>'.$data['note'].'</b> berhasil diperbaharui...', 'csrfHash' => $csrfHash);
					}
				}
			} else {
				$result = array('status' => 0, 'message' => array('isi' => 'Proses update data user gagal, mohon periksa data kembali...'), 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	public function delete()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$session   = $this->app_loader->current_account();
			$csrfHash  = $this->security->get_csrf_hash();
			$token     = escape($this->input->post('tokenId', TRUE));
			if(!empty($session) AND !empty($token)) {
				$data = $this->mdprd->deleteDataUsers();
				if($data['message'] == 'SUCCESS') {
					$result = array('status' => 1, 'message' => 'Data user berhasil dihapus...', 'csrfHash' => $csrfHash);
				} else {
					$result = array('status' => 0, 'message' => 'Proses delete data user gagal, silahkan periksa kembali data yang akan dihapus...', 'csrfHash' => $csrfHash);
				}
			} else {
				$result = array('status' => 0, 'message' => 'Proses delete data gagal...', 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	public function searching()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			$username = escape($this->input->post('username', TRUE));
			if(!empty($session) AND !empty($username)) {
				$data  = $this->mdprd->searchDataUsername($username);
				$result = array('message' => $data, 'csrfHash' => $csrfHash);
			} else
			$result = array('message' => 0, 'csrfHash' => $csrfHash);
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	public function subOpd()
	{
		echo $this->mdprd->getInstansiAll();
	}

	public function subOpd1()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			$opdId = $this->input->get('opdId', TRUE);
			if(!empty($opdId)AND !empty($session)) {
				$data = $this->mdprd->getDataSubOpd($opdId);
				if(count($data) > 0) {
					$row = array();
					foreach ($data as $key => $val) {
						$row['id'] 		= $val['id_opd'];
						$row['text']	= $val['nm_sub_opd'];
						$hasil[] = $row;
					}
					$result = array('status' => 1, 'message' => $hasil, 'csrfHash' => $csrfHash);
				} else
				$result = array('status' => 0, 'message' => '', 'csrfHash' => $csrfHash);
			} else {
				$result = array('status' => 0, 'message' => '', 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}
}

// This is the end of users class
