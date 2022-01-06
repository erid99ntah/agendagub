<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of users model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_spj extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{
		/*if($role == 'new') {
			$valid = 'required|';
		} else {
			$valid = ($this->input->post('password') != '') ? 'required|' : '';
		}*/
  	$this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[6]|alpha_dash');
  	//$this->form_validation->set_rules('fullname', 'Nama Lengkap', 'required|trim');
  //	$this->form_validation->set_rules('id_opd',   'Nama OPD', 'required|trim');
  //	$this->form_validation->set_rules('email',    'Email', 'trim|valid_email');
	//	$this->form_validation->set_rules('password', 'Password', $valid.'regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/]');
  	//$this->form_validation->set_rules('conf_password', 'Konfirmasi Password', $valid.'matches[password]');
		$this->form_validation->set_rules('groupid[]', 'Group User', 'required|trim');
  	validation_message_setting();
    if ($this->form_validation->run() == FALSE)
      return false;
    else
      return true;
	}

	public function getDataListGroup()
	{
		$this->db->where('id_status', 1);
		if(!$this->app_loader->is_admin()) {
			$this->db->where_not_in('id_level_akses', array(1));
		}
		$this->db->order_by('id_level_akses ASC');
		$this->db->order_by('id_group ASC');
		$query = $this->db->get('xi_sa_group');
		return $query->result_array();
	}

   public function getDataListInstansi()
   {
	    $this->db->where('id_status', 1);
		$this->db->order_by('id_opd ASC');
		$query = $this->db->get('master_opd');

			$dd_instansi[''] = 'Pilih Data';
	    if ($query->num_rows() > 0) {
	      foreach ($query->result() as $row) {
	        $dd_instansi[$row->id_opd] = $row->nm_opd;
	      }
	    }
	    return $dd_instansi;
   }

	public function getDataLevelAkses()
    {
		if(!$this->app_loader->is_admin()) {
			$this->db->where('id_level_akses !=', 1);
		}
		$this->db->where('id_status', 1);
		$query = $this->db->get('xi_sa_level_akses');
    $dd_level[''] = 'Pilih Data';
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $dd_level[$row['id_level_akses']] = $row['level_akses'];
      }
    }
    return $dd_level;
  }

	var $search = array('a.username', 'a.fullname', 'c.nama_group');
	public function get_datatables($param)
  {
    $this->_get_datatables_query($param);
    if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    return $query->result_array();
  }

	public function count_filtered($param)
  {
    $this->_get_datatables_query($param);
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all()
  {
		$this->db->select('a.id_users');
		$this->db->from('xi_sa_users a');
		$this->db->join('xi_sa_users_privileges b', 'a.id_users = b.id_users', 'left');
		$this->db->join('xi_sa_group c', 'b.id_group = c.id_group', 'left');
		$this->db->where('a.account_type', 2);
		if(!$this->app_loader->is_admin()) {
			$this->db->where('c.id_level_akses !=', 1);
		}
    return $this->db->count_all_results();
  }

  private function _get_datatables_query($param)
  {
		$post = array();
		if (is_array($param)) {
      foreach ($param as $v) {
        $post[$v['name']] = $v['value'];
      }
    }
		$this->db->select('a.id_users,
											 a.token,
											 a.username,
											 a.email,
											 a.fullname,
											 a.foto_profile,
											 a.nm_opd,
											 a.nm_sub_opd,
											 a.blokir,
											 a.id_status,
											 (CASE
											   WHEN d.pass_plain IS NULL THEN "-"
											   ELSE d.pass_plain
											 END) AS pass_plain,
											 GROUP_CONCAT(c.nama_group ORDER BY c.id_level_akses ASC SEPARATOR ",") AS group_user');
    $this->db->from('xi_sa_users a');
		$this->db->join('xi_sa_users_privileges b', 'a.id_users = b.id_users', 'left');
		$this->db->join('xi_sa_group c', 'b.id_group = c.id_group', 'left');
		$this->db->join('xi_sa_users_default_pass d', 'a.id_users = d.id_users', 'left');
		$this->db->where('b.id_status', 1);
		$this->db->where('a.account_type', 2);
		if(!$this->app_loader->is_admin()) {
			$this->db->where('c.id_level_akses !=', 1);
		}
		//level
		if(isset($post['level']) AND $post['level'] != '')
			$this->db->where('c.id_level_akses', $post['level']);
		//blokir
		if(isset($post['blokir']) AND $post['blokir'] != '')
			$this->db->where('a.blokir', $post['blokir']);
		//status
		if(isset($post['status']) AND $post['status'] != '')
			$this->db->where('a.id_status', $post['status']);
		//username
		if(isset($post['username']) AND $post['username'] != '')
			$this->db->like('a.username', $post['username'], 'after');
		//fullname
		if(isset($post['fullname']) AND $post['fullname'] != '')
			$this->db->like('a.fullname', $post['fullname'], 'after');
		//email
		if(isset($post['email']) AND $post['email'] != '')
			$this->db->like('a.email', $post['email'], 'after');
		//group
		if(isset($post['group']) AND $post['group'] != '')
			$this->db->like('c.nama_group', $post['group'], 'after');
    $i = 0;
    foreach ($this->search as $item) { // loop column
      if($_POST['search']['value']) { // if datatable send POST for search
        if($i===0) { // first loop
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($item, $_POST['search']['value']);
        } else {
          $this->db->or_like($item, $_POST['search']['value']);
        }

        if(count($this->search) - 1 == $i) //last loop
          $this->db->group_end(); //close bracket
      }
      $i++;
    }
		$this->db->group_by('a.id_users');
		$this->db->order_by('a.id_users ASC');
  }

	/*Fungsi get data edit by id dan url*/
	public function getDataDetailUsers($token)
	{
		$this->db->select('a.id_users,
											 a.token,
											 a.username,
											 a.password,
											 a.email,
											 a.fullname,
											 a.foto_profile,
											 a.id_opd,
											 a.nm_opd,
											 a.sub_opd,
											 a.nm_sub_opd,
											 a.blokir,
											 a.id_status,
											 GROUP_CONCAT(b.id_group ORDER BY b.id_group ASC SEPARATOR ",") AS group_user');
		$this->db->from('xi_sa_users a');
		$this->db->join('xi_sa_users_privileges b', 'a.id_users = b.id_users', 'left');
		$this->db->where('a.token', $token);
		$this->db->where('b.id_status', 1);
		$this->db->group_by('a.id_users');
		$this->db->order_by('a.id_users ASC');
		$this->db->limit(1);
    $query = $this->db->get();
    return $query->row_array();
	}

	private function getDataUserByToken($token)
	{
		$this->db->where('token', $token);
		$query = $this->db->get('xi_sa_users');
		return $query->row_array();
	}

	/* Fungsi untuk insert data */
	public function insertDataUsers()
	{
		//get data
		$create_by   = $this->app_loader->current_account();
		$create_date = date('Y-m-d H:i:s');
		$create_ip   = $this->input->ip_address();
		$username		 = escape($this->input->post('username', TRUE));
		$password 	 = escape($this->input->post('password', TRUE));
		$group			 = escape($this->input->post('groupid', TRUE));
		$fullname    = escape($this->input->post('fullname', TRUE));
		$id_opd    = escape($this->input->post('id_opd', TRUE));
		$token			 = generateToken($username, $fullname);
		$data = array(
			'token'				  					=> $token,
			'username' 								=> $username,
			'password' 								=> $this->bcrypt->hash_password($password),
			'email' 									=> escape($this->input->post('email', TRUE)),
			'fullname' 								=> $fullname,
			'foto_profile' 						=> 'default.png',
			'blokir' 									=> escape($this->input->post('blokir', TRUE)),
			'id_status' 							=> escape($this->input->post('status', TRUE)),
			'id_opd' 							=> escape($this->input->post('id_opd', TRUE)),
			'validate_email_code'			=> '',
			'validate_email_status'		=> 0,
			'reset_password_code'			=> '',
			'reset_password_status'		=> 0,
			'reset_password_expired'	=> 0,
			'create_by' 							=> $create_by,
			'create_date' 						=> $create_date,
			'create_ip' 							=> $create_ip,
			'mod_by' 									=> $create_by,
			'mod_date' 								=> $create_date,
			'mod_ip' 									=> $create_ip
		);
		/*cek username yang diinputkan*/
		$this->db->where('username', $username);
		$nUser = $this->db->count_all_results('xi_sa_users');
		if($nUser > 0)
			return array('message'=>'ERROR', 'note'=>$username);
		else {
			/*query insert*/
			$this->db->insert('xi_sa_users', $data);
			$id_users = $this->db->insert_id();
			/*query insert user password*/
			$this->db->insert('xi_sa_users_default_pass', array('id_users' => $id_users, 'pass_plain' => $password, 'updated' => 'N'));
			/*query insert user group privileges*/
			foreach ($group as $id) {
				$this->db->insert('xi_sa_users_privileges', array('id_users' => $id_users, 'id_group' => $id, 'id_status' => 1));
			}
			return array('message'=>'SUCCESS', 'note'=>$username);
		}
	}

	/* Fungsi untuk update data */
  public function updateDataUsers()
  {
    //get data
    $create_by   	= $this->app_loader->current_account();
    $create_date 	= date('Y-m-d H:i:s');
    $create_ip  	= $this->input->ip_address();
		$token   			= escape($this->input->post('tokenId', TRUE));
		$username   	= escape($this->input->post('username', TRUE));
		$password   	= escape($this->input->post('password', TRUE));
		
		$group				= escape($this->input->post('groupid', TRUE));
		
		$data = array(
			'username'  	=> $username,			
			'mod_by' 	  	=> $create_by,
			'mod_date'  	=> $create_date,
			'mod_ip'    	=> $create_ip
		);
		if($password != "")
			$data = array_merge($data, array('password' => $this->bcrypt->hash_password($password)));
		//get data user by token
		$dataUser = $this->getDataUserByToken($token);
		$id_users = !empty($dataUser) ? $dataUser['id_users'] : 0;
		//cek data user ditemukan atau tidak
		if(count($dataUser) <= 0)
			return array('message'=>'NODATA', 'note'=>$username);
		else {
			//cek nama username biar tidak terjadi duplikat data
			$this->db->where('username', $username);
			$this->db->where('id_users !=', $id_users);
			$nUser = $this->db->count_all_results('xi_sa_users');
			if($nUser > 0)
				return array('message'=>'ERROR', 'note'=>$username);
			else {
				/*query update*/
				$this->db->where('id_users', $id_users);
				$this->db->where('token', $token);
				$this->db->update('xi_sa_users', $data);
				/*query update user password*/
				if($password != ""){
					$this->db->set('pass_plain', $password);
					$this->db->where('id_users', abs($id_users));
					$this->db->update('xi_sa_users_default_pass');
				}
				/*query update user group privileges*/
				$this->db->set('id_status', 0);
				$this->db->where('id_users', abs($id_users));
				$this->db->update('xi_sa_users_privileges');

				foreach ($group as $id) {
					$this->db->where('id_users', abs($id_users));
					$this->db->where('id_group', abs($id));
					$nGroup = $this->db->count_all_results('xi_sa_users_privileges');
					if($nGroup > 0){
						//update status group privileges jadi 1
						$this->db->set('id_status', 1);
						$this->db->where('id_users', abs($id_users));
						$this->db->where('id_group', abs($id));
						$this->db->update('xi_sa_users_privileges');
					} else
						$this->db->insert('xi_sa_users_privileges', array('id_users' => $id_users, 'id_group' => $id, 'id_status' => 1));
				}
				return array('message'=>'SUCCESS', 'note'=>$username);
			}
		}
  }

	public function deleteDataUsers()
	{
		$users = escape($this->input->post('tokenId', TRUE));
		//jika ingin menghapus data lakukan looping
		foreach ($users as $id) {
			/*query delete*/
			$this->db->where('token', $id);
			$this->db->delete('xi_sa_users');
		}
		return array('message'=>'SUCCESS');
	}

	public function searchDataUsername($username)
  {
		$this->db->where('username', $username);
		return $this->db->count_all_results('xi_sa_users');
  }

	public function getDataUserPassword($id_users)
	{
		$this->db->select('pass_plain');
		$this->db->where('id_users', $id_users);
		$query = $this->db->get('xi_sa_users_default_pass');
		return $query->row_array();
	}

	public function getDataUserGroup($id_users)
	{
		$this->db->select('p.id_group,
										   g.nama_group');
		$this->db->from('xi_sa_users_privileges p');
		$this->db->join('xi_sa_group g', 'g.id_group = p.id_group', 'inner');
		$this->db->where('p.id_users', $id_users);
		$this->db->where('p.id_status', 1);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getDataUserGroupPrivileges($id_users)
	{
		$this->db->where('id_users', abs($id_users));
		$this->db->where('id_status', 1);
    $query = $this->db->get('xi_sa_users_privileges');
    return $query->result_array();
	}
}

// This is the end of auth signin model
