<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of module class
 *
 * @author Yogi "solop" Kaputra
 */

class Module extends SLP_Controller {

	public function __construct()
  {
    parent::__construct();
		$this->load->model(array('model_module'));
  }

	public function index()
	{
    $this->breadcrumb->add('Dashboard', site_url('home'));
    $this->breadcrumb->add('Manajemen', '#');
    $this->breadcrumb->add('Module', site_url('manajemen/module'));

		$this->session_info['page_name'] 		= "Module";
		$this->session_info['list_module']	= $this->model_module->getDataListModule();
    $this->template->build('form_module/list', $this->session_info);
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
		$this->breadcrumb->add('Dashboard', site_url('home'));
    $this->breadcrumb->add('Manajemen', '#');
    $this->breadcrumb->add('Module', site_url('manajemen/module'));
    $this->breadcrumb->add('Entri Baru', site_url('manajemen/module/create'));

		$this->session_info['page_name'] = "Module - Entri Baru";
    $this->template->build('form_module/add', $this->session_info);
	}

	private function createData()
	{
		if($this->model_module->validasiDataValue("add") == FALSE) {
			error_message('danger', 'Peringatan!', 'Tolong dilengkapi form inputan dibawah...');
      $this->createForm();
    } else {
			$data = $this->model_module->insertDataModule();
			if($data) {
				error_message('success', 'Sukses!', 'Data berhasil disimpan.');
				redirect('manajemen/module');
			}
		}
	}

	public function update($id, $name)
	{
		if(!isset($id) OR !isset($name))
      redirect('manajemen/module');

		if($this->input->post('save', TRUE))
      $this->updateData($id, $name);
    else
      $this->updateForm($id, $name);
	}

	private function updateForm($id, $name)
	{
    $data_edit = $this->model_module->editDataModule($id, $name);
    if($data_edit->num_rows() == 0)
      redirect('manajemen/module/create');

		$this->breadcrumb->add('Dashboard', site_url('home'));
    $this->breadcrumb->add('Manajemen', '#');
    $this->breadcrumb->add('Module', site_url('manajemen/module'));
    $this->breadcrumb->add('Edit Data', site_url('manajemen/module/update'));

		$this->session_info['page_name'] 		= "Module - Edit Data";
		$this->session_info['data_module']	= $data_edit->row();
		$this->session_info['urlform']			= "manajemen/module/update/".$id."/".$name;
    $this->template->build('form_module/edit', $this->session_info);
	}

	private function updateData($id, $name)
	{
		if($this->model_module->validasiDataValue("edit") == FALSE) {
			error_message('danger', 'Peringatan!', 'Tolong dilengkapi form inputan dibawah...');
      $this->updateForm($id, $name);
    } else {
			$data = $this->model_module->updateDataModule();
			if($data === FALSE) {
				error_message('danger', 'Peringatan!', 'Data yang diinputkan sudah digunakan...');
	      $this->updateForm($id, $name);
			} else {
				error_message('success', 'Sukses!', 'Data berhasil disimpan.');
				redirect('manajemen/module');
			}
		}
	}

	public function delete()
	{
		$module = $this->input->post('checkid', TRUE);
		if(empty($module)) {
			error_message('danger', 'Peringatan!', 'Data harus dipilih terlebih dahulu jika ingin dihapus..');
			redirect('manajemen/module');
		}else
      $this->deleteData();
	}

	private function deleteData()
	{
		$data = $this->model_module->deleteDataModule();
		if($data === "ONUSE")
			error_message('danger', 'Peringatan!', 'Module tidak bisa dihapus karena sedang digunakan...');
		elseif($data === "ONLYNOTUSE")
			error_message('success', 'Sukses!', 'Data berhasil dihapus kecuali module yang digunakan.');
		else
			error_message('success', 'Sukses!', 'Data berhasil dihapus.');
		redirect('manajemen/module');
	}

	public function rules()
	{
		$id 		= urldecode($this->uri->segment(4,0));
    $name 	= urldecode($this->uri->segment(5,0));

		if(!isset($id) OR !isset($name))
      redirect('manajemen/module');

    $data_edit = $this->model_module->editDataModule($id, $name);
    if($data_edit->num_rows() == 0)
      redirect('manajemen/module');
		else
			$this->generateForm($id, $name);
	}

	private function generateForm($id, $name)
	{
		$this->breadcrumb->add('Dashboard', site_url('home'));
    $this->breadcrumb->add('Manajemen', '#');
    $this->breadcrumb->add('Module', site_url('manajemen/module'));
    $this->breadcrumb->add('Rules', site_url('manajemen/module/rules'));

		$this->session_info['page_name'] 		= 'Module - Rules';
		$this->session_info['data_kontrol']	= $this->model_module->getDataKontrolAll();
		$this->session_info['data_fungsi']	= $this->model_module->getDataFungsiAll();
		$this->session_info['urlform']			= 'manajemen/module/set-rules/'.$id.'/'.$name;

		$result = $this->model_module->getDataRulesModule($id);
		if($result != FALSE)
		{
			$rules = array();
			foreach ($result as $q) {
				$isi['id_rules'] 			= $q['id_rules'];
				$isi['nama_fungsi'] 	= $q['nama_fungsi'];
				$isi['label_fungsi'] 	= $q['label_fungsi'];
				$isi['status'] 				= $q['id_status'];
				$rules[$q['label_kontrol']][] = $isi;
			}
			$this->session_info['rules_lists'] = $rules;
		}
		else
			$this->session_info['rules_lists'] = 0;

    $this->template->build('form_module/rules_form', $this->session_info);
	}

	public function set_rules($id, $nama)
	{
		$id_rules = $this->input->post('checkid', TRUE) ? $this->input->post('checkid', TRUE) : '';
		if($this->input->post('save', TRUE) && empty($id_rules))
			$this->generateCreate($id, $nama);
		elseif($this->input->post('update', TRUE) && !empty($id_rules))
		 	$this->generateUpdate($id, $nama);
		else {
			error_message('danger', 'Peringatan!', 'Silahkan pilih proses yang ingin dilakukan terlebih dahulu...');
			redirect('manajemen/module/rules/'.$id.'/'.$nama);
		}
	}

	private function generateCreate($id, $nama)
	{
		if($this->model_module->validasiDataRulesValue() == FALSE)
			error_message('danger', 'Peringatan!', 'Tolong dilengkapi form inputan dibawah...');
		else {
			$data = $this->model_module->insertDataModuleRules($id);
			if($data === FALSE)
				error_message('danger', 'Peringatan!', 'Nama kontrol dan fungsi sudah digunakan di module ini...');
			else
				error_message('success', 'Sukses!', 'Data berhasil disimpan.');
		}
		redirect('manajemen/module/rules/'.$id.'/'.$nama);
	}

	private function generateUpdate($id, $nama)
	{
		$data = $this->model_module->updateDataModuleRules($id);
		if($data == "AR")
			error_message('success', 'Sukses!', 'Data rules module berhasil diaktifkan...');
		elseif($data == "NR")
			error_message('success', 'Sukses!', 'Data rules module berhasil dinonaktifkan...');
		elseif($data == "DR")
			error_message('success', 'Sukses!', 'Data rules module berhasil dihapus...');
		redirect('manajemen/module/rules/'.$id.'/'.$nama);
	}
}

// This is the end of fungsi class
