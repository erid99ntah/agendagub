<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of kontrol class
 *
 * @author Yogi "solop" Kaputra
 */

class Kontrol extends SLP_Controller {

	public function __construct()
  {
    parent::__construct();
		$this->load->model(array('model_kontrol'));
  }

	public function index()
	{
    $this->breadcrumb->add('Dashboard', site_url('home'));
    $this->breadcrumb->add('Manajemen', '#');
    $this->breadcrumb->add('Kontrol', site_url('manajemen/kontrol'));

		$this->session_info['page_name'] 		= "Kontrol";
		$this->session_info['list_kontrol']	= $this->model_kontrol->getDataListKontrol();
    $this->template->build('form_kontrol/list', $this->session_info);
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
    $this->breadcrumb->add('Kontrol', site_url('manajemen/kontrol'));
    $this->breadcrumb->add('Entri Baru', site_url('manajemen/kontrol/create'));

		$this->session_info['page_name'] = "Kontrol - Entri Baru";
    $this->template->build('form_kontrol/add', $this->session_info);
	}

	private function createData()
	{
		if($this->model_kontrol->validasiDataValue("add") == FALSE) {
			error_message('danger', 'Peringatan!', 'Tolong dilengkapi form inputan dibawah...');
      $this->createForm();
    } else {
			$data = $this->model_kontrol->insertDataKontrol();
			if($data) {
				error_message('success', 'Sukses!', 'Data berhasil disimpan.');
				redirect('manajemen/kontrol');
			}
		}
	}

	public function update($id, $name)
	{
		if(!isset($id) OR !isset($name))
      redirect('manajemen/kontrol');

		if($this->input->post('save', TRUE))
      $this->updateData($id, $name);
    else
      $this->updateForm($id, $name);
	}

	private function updateForm($id, $name)
	{
    $data_edit = $this->model_kontrol->editDataKontrol($id, $name);
    if($data_edit->num_rows() == 0)
      redirect('manajemen/kontrol/create');

		$this->breadcrumb->add('Dashboard', site_url('home'));
    $this->breadcrumb->add('Manajemen', '#');
    $this->breadcrumb->add('Kontrol', site_url('manajemen/kontrol'));
    $this->breadcrumb->add('Edit Data', site_url('manajemen/kontrol/update'));

		$this->session_info['page_name'] 		= "Kontrol - Edit Data";
		$this->session_info['data_kontrol']	= $data_edit->row();
		$this->session_info['urlform']			= "manajemen/kontrol/update/".$id."/".$name;
    $this->template->build('form_kontrol/edit', $this->session_info);
	}

	private function updateData($id, $name)
	{
		if($this->model_kontrol->validasiDataValue("edit") == FALSE) {
			error_message('danger', 'Peringatan!', 'Tolong dilengkapi form inputan dibawah...');
      $this->updateForm($id, $name);
    } else {
			$data = $this->model_kontrol->updateDataKontrol();
			if($data === FALSE) {
				error_message('danger', 'Peringatan!', 'Data yang diinputkan sudah digunakan...');
	      $this->updateForm($id, $name);
			} else {
				error_message('success', 'Sukses!', 'Data berhasil disimpan.');
				redirect('manajemen/kontrol');
			}
		}
	}

	public function delete()
	{
		$kontrol = $this->input->post('checkid', TRUE);
		if(empty($kontrol)) {
			error_message('danger', 'Peringatan!', 'Data harus dipilih terlebih dahulu jika ingin dihapus..');
			redirect('manajemen/kontrol');
		}else
      $this->deleteData();
	}

	private function deleteData()
	{
		$data = $this->model_kontrol->deleteDataKontrol();
		if($data === "ONUSE")
			error_message('danger', 'Peringatan!', 'Kontrol tidak bisa dihapus karena sedang digunakan...');
		elseif($data === "ONLYNOTUSE")
			error_message('success', 'Sukses!', 'Data berhasil dihapus kecuali kontrol yang digunakan.');
		else
			error_message('success', 'Sukses!', 'Data berhasil dihapus.');
		redirect('manajemen/kontrol');
	}
}

// This is the end of fungsi class
