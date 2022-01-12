<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of admin model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_admin extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{
		if($role == "add") {
			$rules = 'required|trim|min_length[8]|alpha_dash|is_unique[xi_sa_users.username]';
			$valid = 'required|';
		}
		else {
			$rules = 'required|trim|min_length[8]|alpha_dash';
			if($this->input->post('password') != "")
				$valid = 'required|';
			else
				$valid = '';
		}

  	$this->form_validation->set_rules('username', 'Username', $rules);
  	$this->form_validation->set_rules('nama_user', 'Nama User', 'required|trim');
  	$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
		$this->form_validation->set_rules('password', 'Password', $valid.'regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/]');
  	$this->form_validation->set_rules('conf_password', 'Konfirmasi Password', $valid.'matches[password]');
		$this->form_validation->set_rules('nama_group[]', 'Nama Group', 'required|trim');
  	validation_message_setting();
    if ($this->form_validation->run() == FALSE)
      return false;
    else
      return true;
	}

	public function getDataGroup()
	{
		$this->db->select('*');
		$this->db->from('xi_sa_group');
		$this->db->where('id_status', 1);
		$query = $this->db->get();

		return $query->result();
	}

	/*Fungsi Get Data List*/
  public function getDataListAdmin()
  {
    $this->db->select('u.*,
											GROUP_CONCAT(DISTINCT(g.nama_group) ORDER BY g.id_group ASC SEPARATOR ", ") AS grup_user');
    $this->db->from('xi_sa_users u');
		$this->db->join('xi_sa_users_privileges up', 'up.id_users = u.id_users', 'left');
		$this->db->join('xi_sa_group g', 'g.id_group = up.id_group', 'left');
    $this->db->where('u.id_pegawai', 0);
		$this->db->where('u.id_users !=', 1);
    $this->db->where('up.id_status', 1);
		$this->db->group_by('u.id_users');
    $this->db->order_by('u.id_users', 'ASC');
    $query = $this->db->get();
    return $query->result_array();
  }

	/*Fungsi get data edit by id dan url*/
	public function editDataAdmin($id, $name)
	{
		$this->db->select('*');
    $this->db->from('xi_sa_users');
		$this->db->where('id_users', abs($id));
		$this->db->where('username', $this->db->escape_str($name));
    $query = $this->db->get();

    return $query;
	}

	public function getDataUserGroupPrivileges($id_users)
	{
		$this->db->select('*');
    $this->db->from('xi_sa_users_privileges');
		$this->db->where('id_users', abs($id_users));
		$this->db->where('id_status', 1);
    $query = $this->db->get();

    return $query->result_array();
	}

	/* Fungsi untuk insert data */
	public function insertDataAdmin()
	{
		//get data
		$create_by   = $this->app_loader->current_account();
		$create_date = date('Y-m-d H:i:s');
		$create_ip   = $this->input->ip_address();
		$password 	= escape($this->input->post('conf_password', TRUE));
		$group			= escape($this->input->post('nama_group', TRUE));
		$data = array(
			'id_pegawai' 		=> 0,
			'nip' 					=> '',
			'username' 			=> escape($this->input->post('username', TRUE)),
			'password' 			=> $this->bcrypt->hash_password($password),
			'email' 				=> escape($this->input->post('email', TRUE)),
			'nama_user' 		=> escape($this->input->post('nama_user', TRUE)),
			'foto_profile' 	=> 'default.png',
			'create_by' 		=> $create_by,
			'create_date' 	=> $create_date,
			'create_ip' 		=> $create_ip,
			'mod_by' 				=> $create_by,
			'mod_date' 			=> $create_date,
			'mod_ip' 				=> $create_ip,
			'blokir' 				=> escape($this->input->post('blokir', TRUE)),
			'id_status' 		=> escape($this->input->post('status', TRUE)),
		);
		/*query insert*/
		$this->db->insert('xi_sa_users', $data);
		$id_users = $this->db->insert_id();
		/*query insert user group privileges*/
		foreach ($group as $id) {
			$this->db->insert('xi_sa_users_privileges', array('id_users' => $id_users, 'id_group' => $id, 'id_status' => 1));
		}
		return TRUE;
	}

	/* Fungsi untuk update data */
  public function updateDataAdmin()
  {
    //get data
    $create_by   	= $this->app_loader->current_account();
    $create_date 	= date('Y-m-d H:i:s');
    $create_ip  	= $this->input->ip_address();
		$id_users			= escape($this->encryption->decrypt($this->input->post('users', TRUE)));
		$username   	= escape($this->input->post('username', TRUE));
		$password 		= escape($this->input->post('conf_password', TRUE));
		$group				= escape($this->input->post('nama_group', TRUE));
		$data = array(
			'username' 			=> $username,
			'email' 				=> escape($this->input->post('email', TRUE)),
			'nama_user' 		=> escape($this->input->post('nama_user', TRUE)),
			'mod_by' 				=> $create_by,
			'mod_date' 			=> $create_date,
			'mod_ip' 				=> $create_ip,
			'blokir' 				=> escape($this->input->post('blokir', TRUE)),
			'id_status' 		=> escape($this->input->post('status', TRUE)),
		);
		if($password != "")
			$data = array_merge($data, array('password' => $this->bcrypt->hash_password($password)));

		//cek nama username biar tidak terjadi duplikat data
		$this->db->where('id_users !=', abs($id_users));
		$this->db->where('username', $username);
		$count = $this->db->count_all_results('xi_sa_users');
		if($count > 0)
			return FALSE;
		else {
			/*query update*/
			$this->db->where('id_users', abs($id_users));
			$this->db->update('xi_sa_users', $data);
		}

		/*query update user group privileges*/
		$this->db->set('id_status', 0);
		$this->db->where('id_users', abs($id_users));
		$this->db->update('xi_sa_users_privileges');

		foreach ($group as $id) {
			$this->db->where('id_users', abs($id_users));
			$this->db->where('id_group', abs($id));
			$qGroup = $this->db->count_all_results('xi_sa_users_privileges');
			if($qGroup > 0) {
				//update status group privileges jadi 1
				$this->db->set('id_status', 1);
				$this->db->where('id_users', abs($id_users));
				$this->db->where('id_group', abs($id));
				$this->db->update('xi_sa_users_privileges');
			}else
				$this->db->insert('xi_sa_users_privileges', array('id_users' => $id_users, 'id_group' => $id, 'id_status' => 1));
		}

    return TRUE;
  }

	public function deleteDataAdmin()
	{
		$users = $this->input->post('checkid', TRUE);
		//jika ingin menghapus data lakukan looping
		foreach ($users as $id) {
			/*query delete*/
			$id_users = $this->encryption->decrypt($id);
			$this->db->delete('xi_sa_users', array('id_users' => abs($id_users)));
			$this->db->delete('xi_sa_users_privileges', array('id_users' => abs($id_users)));
			$this->db->delete('xi_sa_users_default_pass', array('id_users' => abs($id_users)));
		}
		return TRUE;
	}
}

// This is the end of auth signin model
