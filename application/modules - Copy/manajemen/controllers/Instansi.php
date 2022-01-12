<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of Instansi class
 *
 * @author Yogi "solop" Kaputra
 */

class Instansi extends SLP_Controller {

	public function __construct()
  {
    parent::__construct();
		$this->load->model(array('model_instansi'));
  }

	public function index()
	{
    $this->breadcrumb->add('Dashboard', site_url('home'));
    $this->breadcrumb->add('Master', '#');
    $this->breadcrumb->add('Instansi', site_url('manajemen/instansi'));

		$this->session_info['page_name'] = "Instansi";
		$this->session_info['list_instansi'] = $this->model_instansi->getDataListInstansi();
    $this->template->build('form_instansi/list', $this->session_info);
	}

  public function create()
  {
		if($this->input->post('save', TRUE))
      $this->createData();
    else
      $this->createForm();
  }

	private function createForm()
	{
		$id 	= urldecode($this->uri->segment(4,0));
		$nama = urldecode($this->uri->segment(5,0));

		$this->breadcrumb->add('Dashboard', site_url('home'));
    $this->breadcrumb->add('Master', '#');
    $this->breadcrumb->add('Instansi', site_url('manajemen/instansi'));
    $this->breadcrumb->add('Entri Baru', site_url('manajemen/instansi/create'));

		$this->session_info['page_name'] 		= "Instansi - Entri Baru";
		$this->session_info['list_parent']	= $this->model_instansi->getDataParentInstansi();
		
		$this->session_info['parentID']			= $this->input->post('parent_id', TRUE) ? $this->input->post('parent_id', TRUE) : $id;
		$this->session_info['urlform']			= $id ? "manajemen/instansi/create/".$id."/".str_replace(' ', '-',  strtolower($nama)) : "manajemen/instansi/create";
		$this->session_info['nm_instansi'] = $this->model_instansi->getNamaInstansi($id);
    $this->template->build('form_instansi/add', $this->session_info);
	}

	private function createData()
	{
		if($this->model_instansi->validasiDataValue('parent') == FALSE) {
			error_message('danger', 'Peringatan!', 'Tolong dilengkapi form inputan dibawah...');
      $this->createForm();
    } else {
			$data = $this->model_instansi->insertDataInstansi();
			if($data) {
				error_message('success', 'Sukses!', 'Data berhasil disimpan.');
				redirect('manajemen/instansi');
			}
		}
	}

	public function update($id, $name)
	{
		if(!isset($id) OR !isset($name))
      redirect('manajemen/instansi');

		if($this->input->post('save', TRUE))
      $this->updateData($id, $name);
    else
      $this->updateForm($id, $name);
	}

	private function updateForm($id, $name)
	{
    $data_edit = $this->model_instansi->editDataInstansi($id, $name);
    if($data_edit->num_rows() == 0)
      redirect('manajemen/instansi/create');

		$this->breadcrumb->add('Dashboard', site_url('home'));
    $this->breadcrumb->add('Master', '#');
    $this->breadcrumb->add('Instansi', site_url('manajemen/instansi'));
    $this->breadcrumb->add('Edit Data', site_url('manajemen/instansi/update'));

		$this->session_info['page_name'] 		= "Instansi - Edit Data";
		$this->session_info['list_parent']	= $this->model_instansi->getDataParentInstansi();
		$this->session_info['rules_list'] 	= $this->model_instansi->getDataRulesModule();
		$this->session_info['data_Instansi'] 		= $data_edit->row();
		$this->session_info['urlform']			= "manajemen/instansi/update/".$id."/".$name;
    $this->template->build('form_instansi/edit', $this->session_info);
	}

	private function updateData($id, $name)
	{
		$type = $this->input->post('is_parent', TRUE);
		if($this->model_instansi->validasiDataValue($type) == FALSE) {
			error_message('danger', 'Peringatan!', 'Tolong dilengkapi form inputan dibawah...');
      $this->updateForm($id, $name);
    } else {
			$data = $this->model_instansi->updateDataInstansi();
			if($data) {
				error_message('success', 'Sukses!', 'Data berhasil disimpan.');
				redirect('manajemen/instansi');
			}
		}
	}

	public function delete()
	{
		$Instansi = $this->input->post('instansiid', TRUE);
		if(empty($Instansi)) {
			error_message('danger', 'Peringatan!', 'Data harus dipilih terlebih dahulu jika ingin dihapus..');
			redirect('manajemen/instansi');
		}
		else
      $this->deleteData();
	}

	private function deleteData()
	{
		$data = $this->model_instansi->deleteDataInstansi();
		if($data==TRUE) {
			error_message('success', 'Sukses!', 'Data berhasil dihapus.');
			redirect('manajemen/instansi');
		}
		else{
			error_message('danger', 'Gagal!', 'Data gagal dihapus.');
			redirect('manajemen/instansi');	
		}
	}

}

// This is the end of fungsi class
