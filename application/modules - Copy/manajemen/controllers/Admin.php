<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of admin class
 *
 * @author Yogi "solop" Kaputra
 */

class Admin extends SLP_Controller {

	public function __construct()
  {
    parent::__construct();
		$this->load->model(array('model_admin'));
  }

	public function index()
	{
    $this->breadcrumb->add('Dashboard', site_url('home'));
    $this->breadcrumb->add('Administrator', '#');
    $this->breadcrumb->add('Manajemen Admin', site_url('manajemen/admin'));

		$this->session_info['page_name'] 		= "Manajemen Admin";
		$this->session_info['list_user']		= $this->model_admin->getDataListAdmin();
    $this->template->build('form_admin/list', $this->session_info);
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
    $this->breadcrumb->add('Administrator', '#');
    $this->breadcrumb->add('Manajemen Admin', site_url('manajemen/admin'));
    $this->breadcrumb->add('Add', site_url('manajemen/admin/create'));

		$this->session_info['page_name'] 	= "Manajemen Admin - Add";
		$this->session_info['group_list']	= $this->model_admin->getDataGroup();
    $this->template->build('form_admin/add', $this->session_info);
	}

	private function createData()
	{
		if($this->model_admin->validasiDataValue("add") == FALSE) {
			error_message('danger', 'Gagal Simpan!', 'Tolong dilengkapi form inputan dibawah...');
      $this->createForm();
    } else {
			$data = $this->model_admin->insertDataAdmin();
			if($data) {
				error_message('success', 'Sukses Simpan!', 'Data berhasil disimpan.');
				redirect('manajemen/admin');
			}
		}
	}

	public function update($id, $name)
	{
		if(empty($id) || empty($name))
      redirect('manajemen/admin');

		if($this->input->post('save', TRUE))
      $this->updateData($id, $name);
    else
      $this->updateForm($id, $name);
	}

	private function updateForm($id, $name)
	{
    $data_edit = $this->model_admin->editDataAdmin($id, $name);
    if($data_edit->num_rows() == 0)
      redirect('manajemen/admin/create');

		$this->breadcrumb->add('Dashboard', site_url('home'));
    $this->breadcrumb->add('Administrator', '#');
    $this->breadcrumb->add('Manajemen Admin', site_url('manajemen/admin'));
    $this->breadcrumb->add('Edit', site_url('manajemen/admin/update'));

		$this->session_info['page_name'] 	= "Manajemen Admin - Edit";
		$this->session_info['group_list']	= $this->model_admin->getDataGroup();
		$this->session_info['data_admin']	= $data_edit->row();
		$this->session_info['user_group']	= $this->model_admin->getDataUserGroupPrivileges($id);
		$this->session_info['urlform']		= "manajemen/admin/update/".$id."/".$name;
    $this->template->build('form_admin/edit', $this->session_info);
	}

	private function updateData($id, $name)
	{
		if($this->model_admin->validasiDataValue("edit") == FALSE) {
			error_message('danger', 'Gagal Simpan!', 'Tolong dilengkapi form inputan dibawah...');
      $this->updateForm($id, $name);
    } else {
			$data = $this->model_admin->updateDataAdmin();
			if($data === FALSE) {
				error_message('danger', 'Gagal Simpan!', 'Data yang diinputkan sudah digunakan...');
	      $this->updateForm($id, $name);
			} else {
				error_message('success', 'Sukses Simpan!', 'Data berhasil disimpan.');
				redirect('manajemen/admin');
			}
		}
	}

	public function delete()
	{
		$users = $this->input->post('checkid', TRUE);
		if(empty($users)) {
			error_message('danger', 'Peringatan!', 'Data harus dipilih terlebih dahulu jika ingin dihapus..');
			redirect('manajemen/admin');
		}else
      $this->deleteData();
	}

	private function deleteData()
	{
		$data = $this->model_admin->deleteDataAdmin();
		error_message('success', 'Sukses Hapus!', 'Data berhasil dihapus.');
		redirect('manajemen/admin');
	}
}

// This is the end of users class
