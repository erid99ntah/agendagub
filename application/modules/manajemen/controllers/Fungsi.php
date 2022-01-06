<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of fungsi class
 *
 * @author Yogi "solop" Kaputra
 */

class Fungsi extends SLP_Controller {

	public function __construct()
  {
    parent::__construct();
		$this->load->model(array('model_fungsi'));
  }

	public function index()
	{
    $this->breadcrumb->add('Dashboard', site_url('home'));
    $this->breadcrumb->add('Manajemen', '#');
    $this->breadcrumb->add('Fungsi', site_url('manajemen/fungsi'));

		$this->session_info['page_name'] 		= "Fungsi";
		$this->session_info['list_fungsi']	= $this->model_fungsi->getDataListFungsi();
    $this->template->build('form_fungsi/list', $this->session_info);
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
    $this->breadcrumb->add('Fungsi', site_url('manajemen/fungsi'));
    $this->breadcrumb->add('Entri Baru', site_url('manajemen/fungsi/create'));

		$this->session_info['page_name'] 		= "Fungsi - Entri Baru";
		$this->session_info['jenis_fungsi']	= $this->model_fungsi->getDataJenisFungsi();
    $this->template->build('form_fungsi/add', $this->session_info);
	}

	private function createData()
	{
		if($this->model_fungsi->validasiDataValue("add") == FALSE) {
			error_message('danger', 'Peringatan!', 'Tolong dilengkapi form inputan dibawah...');
      $this->createForm();
    } else {
			$data = $this->model_fungsi->insertDataFungsi();
			if($data) {
				error_message('success', 'Sukses!', 'Data berhasil disimpan.');
				redirect('manajemen/fungsi');
			}
		}
	}

	public function update($id, $name)
	{
		if(!isset($id) OR !isset($name))
      redirect('manajemen/fungsi');

		if($this->input->post('save', TRUE))
      $this->updateData($id, $name);
    else
      $this->updateForm($id, $name);
	}

	private function updateForm($id, $name)
	{
    $data_edit = $this->model_fungsi->editDataFungsi($id, $name);
    if($data_edit->num_rows() == 0)
      redirect('manajemen/fungsi/create');

		$this->breadcrumb->add('Dashboard', site_url('home'));
    $this->breadcrumb->add('Manajemen', '#');
    $this->breadcrumb->add('Fungsi', site_url('manajemen/fungsi'));
    $this->breadcrumb->add('Edit Data', site_url('manajemen/fungsi/update'));

		$this->session_info['page_name'] 		= "Fungsi - Edit Data";
		$this->session_info['jenis_fungsi']	= $this->model_fungsi->getDataJenisFungsi();
		$this->session_info['data_fungsi']	= $data_edit->row();
		$this->session_info['urlform']			= "manajemen/fungsi/update/".$id."/".$name;
    $this->template->build('form_fungsi/edit', $this->session_info);
	}

	private function updateData($id, $name)
	{
		if($this->model_fungsi->validasiDataValue("edit") == FALSE) {
			error_message('danger', 'Peringatan!', 'Tolong dilengkapi form inputan dibawah...');
      $this->updateForm($id, $name);
    } else {
			$data = $this->model_fungsi->updateDataFungsi();
			if($data === FALSE) {
				error_message('danger', 'Peringatan!', 'Data yang diinputkan sudah digunakan...');
	      $this->updateForm($id, $name);
			} else {
				error_message('success', 'Sukses!', 'Data berhasil disimpan.');
				redirect('manajemen/fungsi');
			}
		}
	}

	public function delete()
	{
		$fungsi = $this->input->post('checkid', TRUE);
		if(empty($fungsi)) {
			error_message('danger', 'Peringatan!', 'Data harus dipilih terlebih dahulu jika ingin dihapus..');
			redirect('manajemen/fungsi');
		} else
      $this->deleteData();
	}

	private function deleteData()
	{
		$data = $this->model_fungsi->deleteDataFungsi();
		if($data === "ONUSE")
			error_message('danger', 'Peringatan!', 'Fungsi tidak bisa dihapus karena sedang digunakan...');
		elseif($data === "ONLYNOTUSE")
			error_message('success', 'Sukses!', 'Data berhasil dihapus kecuali fungsi yang digunakan.');
		else
			error_message('success', 'Sukses!', 'Data berhasil dihapus.');
		redirect('manajemen/fungsi');
	}
}

// This is the end of fungsi class
