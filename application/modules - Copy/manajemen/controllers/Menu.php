<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of menu class
 *
 * @author Yogi "solop" Kaputra
 */

class Menu extends SLP_Controller {

	public function __construct()
  {
    parent::__construct();
		$this->load->model(array('model_menu'));
  }

	public function index()
	{
    $this->breadcrumb->add('Dashboard', site_url('home'));
    $this->breadcrumb->add('Manajemen', '#');
    $this->breadcrumb->add('Menu', site_url('manajemen/menu'));

		$this->session_info['page_name'] = "Menu";
		$this->session_info['list_menu'] = $this->model_menu->getDataListMenu();
    $this->template->build('form_menu/list', $this->session_info);
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
    $this->breadcrumb->add('Manajemen', '#');
    $this->breadcrumb->add('Menu', site_url('manajemen/menu'));
    $this->breadcrumb->add('Entri Baru', site_url('manajemen/menu/create'));

		$this->session_info['page_name'] 		= "Menu - Entri Baru";
		$this->session_info['list_parent']	= $this->model_menu->getDataParentMenu();
		$this->session_info['rules_list'] 	= $this->model_menu->getDataRulesModule();
		$this->session_info['parentID']			= $this->input->post('parent_id', TRUE) ? $this->input->post('parent_id', TRUE) : $id;
		$this->session_info['urlform']			= $id ? "manajemen/menu/create/".$id."/".str_replace(' ', '-',  strtolower($nama)) : "manajemen/menu/create";
    $this->template->build('form_menu/add', $this->session_info);
	}

	private function createData()
	{
		$type = $this->input->post('is_parent', TRUE);
		if($this->model_menu->validasiDataValue($type) == FALSE) {
			error_message('danger', 'Peringatan!', 'Tolong dilengkapi form inputan dibawah...');
      $this->createForm();
    } else {
			$data = $this->model_menu->insertDataMenu();
			if($data) {
				error_message('success', 'Sukses!', 'Data berhasil disimpan.');
				redirect('manajemen/menu');
			}
		}
	}

	public function update($id, $name)
	{
		if(!isset($id) OR !isset($name))
      redirect('manajemen/menu');

		if($this->input->post('save', TRUE))
      $this->updateData($id, $name);
    else
      $this->updateForm($id, $name);
	}

	private function updateForm($id, $name)
	{
    $data_edit = $this->model_menu->editDataMenu($id, $name);
    if($data_edit->num_rows() == 0)
      redirect('manajemen/menu/create');

		$this->breadcrumb->add('Dashboard', site_url('home'));
    $this->breadcrumb->add('Manajemen', '#');
    $this->breadcrumb->add('Menu', site_url('manajemen/menu'));
    $this->breadcrumb->add('Edit Data', site_url('manajemen/menu/update'));

		$this->session_info['page_name'] 		= "Menu - Edit Data";
		$this->session_info['list_parent']	= $this->model_menu->getDataParentMenu();
		$this->session_info['rules_list'] 	= $this->model_menu->getDataRulesModule();
		$this->session_info['data_menu'] 		= $data_edit->row();
		$this->session_info['urlform']			= "manajemen/menu/update/".$id."/".$name;
    $this->template->build('form_menu/edit', $this->session_info);
	}

	private function updateData($id, $name)
	{
		$type = $this->input->post('is_parent', TRUE);
		if($this->model_menu->validasiDataValue($type) == FALSE) {
			error_message('danger', 'Peringatan!', 'Tolong dilengkapi form inputan dibawah...');
      $this->updateForm($id, $name);
    } else {
			$data = $this->model_menu->updateDataMenu();
			if($data) {
				error_message('success', 'Sukses!', 'Data berhasil disimpan.');
				redirect('manajemen/menu');
			}
		}
	}

	public function delete()
	{
		$menu = $this->input->post('menuid', TRUE);
		if(empty($menu)) {
			error_message('danger', 'Peringatan!', 'Data harus dipilih terlebih dahulu jika ingin dihapus..');
			redirect('manajemen/menu');
		}
		else
      $this->deleteData();
	}

	private function deleteData()
	{
		$data = $this->model_menu->deleteDataMenu();
		if($data) {
			error_message('success', 'Sukses!', 'Data berhasil dihapus.');
			redirect('manajemen/menu');
		}
	}

}

// This is the end of fungsi class
