<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of group class
 *
 * @author Yogi "solop" Kaputra
 */

class Group extends SLP_Controller {

	public function __construct()
  {
    parent::__construct();
		$this->load->model(array('model_group'));
  }

	public function index()
	{
    $this->breadcrumb->add('Dashboard', site_url('home'));
    $this->breadcrumb->add('Manajemen', '#');
    $this->breadcrumb->add('Group', site_url('manajemen/group'));

		$this->session_info['page_name'] 	= "Group";
		$this->session_info['list_group']	= $this->model_group->getDataListGroup();
    $this->template->build('form_group/list', $this->session_info);
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
    $this->breadcrumb->add('Group', site_url('manajemen/group'));
    $this->breadcrumb->add('Entri Baru', site_url('manajemen/group/create'));

		$this->session_info['page_name']    = "Group - Entri Baru";
		$this->session_info['level_akses']	= $this->model_group->getDataLevelAkses();
    $this->template->build('form_group/add', $this->session_info);
	}

	private function createData()
	{
		if($this->model_group->validasiDataValue() == FALSE) {
			error_message('danger', 'Peringatan!', 'Tolong dilengkapi form inputan dibawah...');
      $this->createForm();
    }
		else {
			$data = $this->model_group->insertDataGroup();
			if($data) {
				error_message('success', 'Sukses!', 'Data berhasil disimpan...');
				redirect('manajemen/group');
			}
		}
	}

	public function update($id, $name)
	{
		if(!isset($id) OR !isset($name))
      redirect('manajemen/group');

		if($this->input->post('save', TRUE))
      $this->updateData($id, $name);
    else
      $this->updateForm($id, $name);
	}

	private function updateForm($id, $name)
	{
    $data_edit = $this->model_group->editDataGroup($id, $name);
    if($data_edit->num_rows() == 0)
      redirect('manajemen/group/create');

		$this->breadcrumb->add('Dashboard', site_url('home'));
    $this->breadcrumb->add('Manajemen', '#');
    $this->breadcrumb->add('Group', site_url('manajemen/group'));
    $this->breadcrumb->add('Edit Data', site_url('manajemen/group/update'));

		$this->session_info['page_name'] 		 = "Group - Edit Data";
		$this->session_info['level_akses']	 = $this->model_group->getDataLevelAkses();
		$this->session_info['data_group']	   = $data_edit->row();
    $this->session_info['urlform']			 = "manajemen/group/update/".$id."/".$name;
    $this->template->build('form_group/edit', $this->session_info);
	}

	private function updateData($id, $name)
	{
		if($this->model_group->validasiDataValue() == FALSE){
			error_message('danger', 'Peringatan!', 'Tolong dilengkapi form inputan dibawah...');
      $this->updateForm($id, $name);
    }
		else {
			$data = $this->model_group->updateDataGroup();
			if($data === FALSE) {
				error_message('danger', 'Peringatan!', 'Data yang diinputkan sudah digunakan...');
	      $this->updateForm($id, $name);
			} else {
				error_message('success', 'Sukses!', 'Data berhasil disimpan...');
				redirect('manajemen/group');
			}
		}
	}

	public function delete()
	{
		$group = $this->input->post('checkid', TRUE);
		if(empty($group)) {
			error_message('danger', 'Peringatan!', 'Data harus dipilih terlebih dahulu jika ingin dihapus..');
			redirect('manajemen/group');
		}else
      $this->deleteData();
	}

	private function deleteData()
	{
		$data = $this->model_group->deleteDataGroup();
		if($data){
      error_message('success', 'Sukses Hapus!', 'Data berhasil dihapus.');
      redirect('manajemen/group');
    }
	}

	public function privileges($id, $name)
	{
		if(!isset($id) OR !isset($name))
      redirect('manajemen/group');

		if($this->input->post('save', TRUE))
      $this->privilegesData($id, $name);
    else
      $this->privilegesForm($id, $name);
	}

	private function privilegesForm($id, $name)
	{
		$data_group = $this->model_group->getDataGroupById($id);
    if($data_group->num_rows() == 0)
      redirect('manajemen/group');

		$privilege = $this->model_group->getDataRulesGroupPrivileges($data_group->row()->id_group);
		$pv = array();
		foreach ($privilege as $key) {
			$pv[] = $key->id_rules;
		}

    $rules = array();
		$result = $this->model_group->getDataAllRulesModule();
		foreach ($result as $r) {
			$list['id_rules'] = $r['id_rules'];
			$list['title_fungsi'] = $r['label_fungsi'];
			$list['checked'] = in_array($r['id_rules'], $pv) ? 'checked="checked"' : '';
			$rules[$r['label_module']][$r['label_kontrol']][] = $list;
		}

		$this->breadcrumb->add('Dashboard', site_url('home'));
    $this->breadcrumb->add('Manajemen', '#');
    $this->breadcrumb->add('Group', site_url('manajemen/group'));
    $this->breadcrumb->add('Privileges', site_url('manajemen/group/update'));

		$this->session_info['page_name']	= "Group - Privileges";
    $this->session_info['urlform']		= "manajemen/group/privileges/".$id."/".$name;
		$this->session_info['group']			= $data_group->row()->id_group;
		$this->session_info['nama_group']	= $data_group->row()->nama_group;
		$this->session_info['data_rules']	= $rules;
    $this->template->build('form_group/privileges', $this->session_info);
	}

	private function privilegesData($id, $name)
	{
		if(empty($this->input->post('group', TRUE))) {
			error_message('danger', 'Peringatan!', 'Pastikan group yang ingin disetting sudah dipilih terlebih dahulu...');
      $this->privilegesForm($id, $name);
    } else {
			$data = $this->model_group->insertDataGroupPrivilege();
			if($data) {
				error_message('success', 'Sukses!', 'Data berhasil disimpan.');
				redirect('manajemen/group/privileges/'.$id.'/'.$name);
			}
		}
	}
}

// This is the end of fungsi class
