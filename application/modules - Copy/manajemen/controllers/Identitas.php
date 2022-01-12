<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of identitas class
 *
 * @author KOminfo
 */

class identitas extends SLP_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('model_identitas'));
	}

	
	public function index()
	{
		if($this->input->post('save', TRUE))
			$this->updateData();
		else
			$this->updateForm();
	}

	private function updateForm()
	{
		$data_edit = $this->model_identitas->editDataidentitas();

		$this->breadcrumb->add('Dashboard', site_url('home'));
		$this->breadcrumb->add('Manajemen', '#');
		$this->breadcrumb->add('identitas', site_url('manajemen/identitas'));

		$this->session_info['page_name'] 		= "identitas - Edit Data";
		$this->session_info['data_identitas']	= $data_edit->row();
		$this->session_info['urlform']			= "manajemen/identitas";
		$this->template->build('form_identitas/edit', $this->session_info);
	}

	private function updateData()
	{
		if($this->model_identitas->validasiDataValue("edit") == FALSE) 
		{
			error_message('danger', 'Peringatan!', 'Tolong dilengkapi form inputan dibawah...');
			$this->updateForm();
		} 
		else 
		{
			$data = $this->model_identitas->updateDataidentitas();
			if($data === FALSE) {
				error_message('danger', 'Peringatan!', 'Data yang diinputkan sudah digunakan...');
				$this->updateForm();
			} else {
				error_message('success', 'Sukses!', 'Data berhasil disimpan.');
				redirect('manajemen/identitas');
			}
		}
	}

	public function delete()
	{
		$identitas = $this->input->post('checkid', TRUE);
		if(empty($identitas)) {
			error_message('danger', 'Peringatan!', 'Data harus dipilih terlebih dahulu jika ingin dihapus..');
			redirect('manajemen/identitas');
		}else
		$this->deleteData();
	}

	private function deleteData()
	{
		$data = $this->model_identitas->deleteDataidentitas();
		if($data === "ONUSE")
			error_message('danger', 'Peringatan!', 'identitas tidak bisa dihapus karena sedang digunakan...');
		elseif($data === "ONLYNOTUSE")
			error_message('success', 'Sukses!', 'Data berhasil dihapus kecuali identitas yang digunakan.');
		else
			error_message('success', 'Sukses!', 'Data berhasil dihapus.');
		redirect('manajemen/identitas');
	}
}

// This is the end of fungsi class
