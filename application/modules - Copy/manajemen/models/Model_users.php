<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of users model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_users extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{
		if($role == 'new') {
			$valid = 'required|';
		} else {
			$valid = ($this->input->post('password') != '') ? 'required|' : '';
		}
  	$this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[6]|alpha_dash');
  	$this->form_validation->set_rules('fullname', 'Nama Lengkap', 'required|trim');
  	$this->form_validation->set_rules('id_opd',   'Nama OPD', 'required|trim');
  	$this->form_validation->set_rules('email',    'Email', 'trim|valid_email');
		$this->form_validation->set_rules('password', 'Password', $valid.'regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/]');
  	$this->form_validation->set_rules('conf_password', 'Konfirmasi Password', $valid.'matches[password]');
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
	    //$this->db->where('id_opd', 1);
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
		$this->db->join('xi_sa_users_privileges b', 'a.id_users = b.id_users', 'INNER');
		$this->db->join('xi_sa_group c', 'b.id_group = c.id_group', 'INNER');
		$this->db->where('a.account_type', 1);
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
		$this->db->where('a.account_type', 1);
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
		$nm_opd    = escape($this->getNamaInstansi($id_opd));

		$sub_opd    = escape($this->input->post('sub_opd', TRUE));
		$nm_sub_opd    = escape($this->getNamaInstansi($sub_opd));

		$token			 = generateToken($username, $fullname);
		$data = array(
			'token'				  	=> $token,
			'username' 				=> $username,
			'password' 				=> $this->bcrypt->hash_password($password),
			'email' 				=> escape($this->input->post('email', TRUE)),
			'fullname' 				=> $fullname,
			'foto_profile' 			=> 'default.png',
			'blokir' 				=> escape($this->input->post('blokir', TRUE)),
			'id_status' 			=> escape($this->input->post('status', TRUE)),
			'id_opd' 				=> escape($this->input->post('id_opd', TRUE)),
			'nm_opd' 				=> $nm_opd,
			'sub_opd' 				=> $sub_opd,
			'nm_sub_opd' 			=> $nm_sub_opd,
			'validate_email_code'	=> '',
			'validate_email_status'	=> 0,
			'reset_password_code'	=> '',
			'reset_password_status'	=> 0,
			'reset_password_expired'=> 0,
			'create_by' 			=> $create_by,
			'create_date' 			=> $create_date,
			'create_ip' 			=> $create_ip,
			'mod_by' 				=> $create_by,
			'mod_date' 				=> $create_date,
			'mod_ip' 				=> $create_ip
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
		$token   	= escape($this->input->post('tokenId', TRUE));
		$username   = escape($this->input->post('username', TRUE));
		$password 	= escape($this->input->post('password', TRUE));
		$group		= escape($this->input->post('groupid', TRUE));
		
		$id_opd     = escape($this->input->post('id_opd', TRUE));
		$nm_opd     = escape($this->getNamaInstansi($id_opd));

		$sub_opd    = escape($this->input->post('sub_opd', TRUE));
		$nm_sub_opd = escape($this->getNamaInstansi($sub_opd));

		$data = array(
			'username'  	=> $username,
			'email' 	  	=> escape($this->input->post('email', TRUE)),
			'fullname' 		=> escape($this->input->post('fullname', TRUE)),
			'blokir'    	=> escape($this->input->post('blokir', TRUE)),
			'id_status' 	=> escape($this->input->post('status', TRUE)),
			'id_opd' 		=> escape($this->input->post('id_opd', TRUE)),
			'nm_opd' 		=> $nm_opd,
			'sub_opd' 		=> $sub_opd,
			'nm_sub_opd' 	=> $nm_sub_opd,
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

	public function getInstansiAll()
	{     

	        if(!$this->app_loader->is_admin()) 
	        {
	          $id_opd = $this->app_loader->current_opd();
	          $child_ins   = $id_opd;
	        } 
	        else
	        {
	          $id_opd      = escape($this->input->get('opdId', TRUE));
	          $child_ins   = 1;  
	        }
	        
	        return $this->getInstansiParent($id_opd, $child_ins);
	}
  
    public function getInstansiParent($id_opd, $child_ins)
    {
        $tampil = "";

        $this->db->where('id_status', 1);
        $this->db->where('id_opd', $id_opd);
        $this->db->order_by('id_opd ASC');
        $data_parent = $this->db->get('master_opd');


        if($data_parent->num_rows() > 0)
        { 
            foreach ($data_parent->result() as $data_parent) 
            {
              if($data_parent->id_opd == $child_ins)
                  $pilih = "selected";
              else
                  $pilih = "";
              
              $tampil .= '<option value="'.$data_parent->id_opd.'" '.$pilih.'>&#8866; '.$data_parent->nm_opd.'</option>';

              $this->db->select('id_opd');
              $this->db->where('parent_id', $id_opd);
              $this->db->order_by('id_opd ASC');
              $cekChild = $this->db->get('master_opd');

              if($cekChild->num_rows() > 0)
                $tampil .= $this->getInstansiChild($data_parent->id_opd, $child_ins, 1);

            }
        }

        return $tampil;
    }

    public function getInstansiChild($parent_id, $child_id, $number)
    {
        $child = "";

        $this->db->where('id_status', 1);
        if(!$this->app_loader->is_admin()) 
        {
          $id_opd = $this->app_loader->current_opd();
          $this->db->where('id_opd', $id_opd);
        }    
        $this->db->where('parent_id', $parent_id);
        $this->db->order_by('id_opd ASC');
        $data_child = $this->db->get('master_opd');


        $spasi = "";
        $nomor = $number + 1;

        for ($i = 1; $i < $nomor; $i++) {
            $spasi .= "&mdash;";
        }

        foreach ($data_child->result() as $key) {
            if($key->id_opd == $child_id)
                $pilih = "selected";
            else
                $pilih = "";

            $child .= '<option value="'.$key->id_opd.'" '.$pilih.'>&#8866;'.$spasi.' '.$key->nm_opd.'</option>';

            $this->db->select('id_opd');
            $this->db->order_by('id_opd ASC');
            $cekChild = $this->db->get('master_opd');

            if($cekChild->num_rows() > 0)               
                $child .= $this->getInstansiChild($key->id_opd, $child_id, $nomor);
        }

        return $child;
    }

    public function getNamaInstansi($id){
		$this->db->select('nm_opd');
		$this->db->from('master_opd');
		$this->db->where('id_opd', $id);
		$this->db->limit(1);
		$data = $this->db->get();

		return $data->row_array()['nm_opd'];
	}

	/*---------------------------------Data Pegawai Simpeg------------------------------------*/
	public function validasiDataPegawai($role)
	{
		if($role == 'new') {
			$valid = 'required|';
			$this->form_validation->set_rules('username', 'Username', 'required|is_unique[xi_sa_users.username]|min_length[6]|alpha_dash');
  			$this->form_validation->set_rules('nip', 	  'NIP', 	  'required|is_unique[xi_sa_users.nip]|min_length[6]|trim');
		} else {
			$valid = ($this->input->post('password') != '') ? 'required|' : '';
			$this->form_validation->set_rules('username', 'Username', 'required|min_length[6]|alpha_dash');
  			$this->form_validation->set_rules('nip', 	  'NIP', 	  'required|min_length[6]|trim');
		}
   	
  	$this->form_validation->set_rules('fullname', 'Nama Lengkap', 'required|trim');
  	$this->form_validation->set_rules('id_opd',   'Nama OPD', 'required|trim');
  	$this->form_validation->set_rules('email',    'Email', 'trim|valid_email');
		$this->form_validation->set_rules('password', 'Password', $valid.'regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/]');
  	$this->form_validation->set_rules('conf_password', 'Konfirmasi Password', $valid.'matches[password]');
		$this->form_validation->set_rules('groupid[]', 'Group User', 'required|trim');
  	validation_message_setting();
    if ($this->form_validation->run() == FALSE)
      return false;
    else
      return true;
	}

	public function insertDataPegawai()
	{
		//get data
		$create_by   = $this->app_loader->current_account();
		$create_date = date('Y-m-d H:i:s');
		$create_ip   = $this->input->ip_address();
		$nip	 = escape($this->input->post('nip', TRUE));
		$cekPegawai = $this->getDetailPegawai($nip);
		$username	 = escape($this->input->post('username', TRUE));
		$password 	 = escape($this->input->post('password', TRUE));
		$group		 = escape($this->input->post('groupid', TRUE));
		$fullname    = escape($this->input->post('fullname', TRUE));
		$id_opd      = escape($this->input->post('id_opd', TRUE));
		
		$token			 = generateToken($username, $fullname);
		
		if ($cekPegawai['status']==false) 
		{
			return array('message'=>'NOPEG', 'note'=>$username);
			echo "dsadsasda";
		}
		else
		{
			$id_opd = $cekPegawai['result']->opd_id;
			$nm_opd = $cekPegawai['result']->opd_nm;
			$sub_opd = $cekPegawai['result']->sub_opd_id;
			$nm_sub_opd = $cekPegawai['result']->sub_opd_nm;
			$jns_jbtn_id = $cekPegawai['result']->jns_jbtn_id;
			$jns_jbtn_nm = $cekPegawai['result']->jns_jbtn_nm;
			$jns_jbtn_nm = $cekPegawai['result']->jns_jbtn_nm;
			$jabatan_id = $cekPegawai['result']->jabatan_id;
			$jabatan_nm = $cekPegawai['result']->jabatan_nm;
			$pangkat = $cekPegawai['result']->pangkat;
			$eselon_id = $cekPegawai['result']->eselon_id;
			$eselon_nm = $cekPegawai['result']->eselon_nm;
			$jenjang_nm = $cekPegawai['result']->jenjang_nm;

			$data = array(
				'token'				  	=> $token,
				'username' 				=> $username,
				'password' 				=> $this->bcrypt->hash_password($password),
				'email' 				=> escape($this->input->post('email', TRUE)),
				'fullname' 				=> $fullname,
				'foto_profile' 			=> 'default.png',
				'blokir' 				=> escape($this->input->post('blokir', TRUE)),
				'id_status' 			=> escape($this->input->post('status', TRUE)),
				'id_opd' 				=> escape($id_opd),
				'nm_opd' 				=> escape($nm_opd),
				'sub_opd' 				=> escape($sub_opd),
				'nm_sub_opd' 			=> escape($nm_sub_opd),
				'jns_jbtn_id' 			=> escape($jns_jbtn_id),
				'jns_jbtn_nm' 			=> escape($jns_jbtn_nm),
				'jabatan_id' 			=> escape($jabatan_id),
				'jabatan_nm' 			=> escape($jabatan_nm),
				'eselon_id' 			=> escape($eselon_id),
				'eselon_nm' 			=> escape($eselon_nm),
				'nip' 					=> escape($nip),
				'pangkat' 				=> escape($pangkat),
				'jenjang' 				=> escape($jenjang_nm),
				
				'validate_email_code'	=> '',
				'validate_email_status'	=> 0,
				'reset_password_code'	=> '',
				'reset_password_status'	=> 0,
				'reset_password_expired'=> 0,
				'create_by' 			=> $create_by,
				'create_date' 			=> $create_date,
				'create_ip' 			=> $create_ip,
				'mod_by' 				=> $create_by,
				'mod_date' 				=> $create_date,
				'mod_ip' 				=> $create_ip
			);
			
			$this->db->where('username', $username);
			$nUser = $this->db->count_all_results('xi_sa_users');
			if($nUser > 0)
				return array('message'=>'ERROR', 'note'=>$username);
			else {

				$this->db->insert('xi_sa_users', $data);
				$id_users = $this->db->insert_id();
				
				$this->db->insert('xi_sa_users_default_pass', array('id_users' => $id_users, 'pass_plain' => $password, 'updated' => 'N'));
				
				foreach ($group as $id) {
					$this->db->insert('xi_sa_users_privileges', array('id_users' => $id_users, 'id_group' => $id, 'id_status' => 1));
				}
				return array('message'=>'SUCCESS', 'note'=>$username);
			}
		}		
	}

	public function getDetailPegawai($nip)
	{
		$url = "http://simpeg.bkd.sumbarprov.go.id/webapi/pegawai/asn/detail/token/XBnKaywRCrj05m-XXX-v6DXuZ3FFkUgiw45/nip/$nip";
        $dataPegawai = get_content($url);

      	if ($dataPegawai!='' || $dataPegawai !=NULL) 
      	{
	        if ($dataPegawai->response=='RC404') 
	        {
	          return array('status'=>false, 'result'=>'');
	        }
	        else
	        {
	        	return array('status'=>true, 'result'=>$dataPegawai->result);
	        }
	    }else{
	    	return array('status'=>false, 'result'=>'');
	    }
	}

	public function updateDataUsersPegawai()
    {
	    //get data
	    $create_by   	= $this->app_loader->current_account();
	    $create_date 	= date('Y-m-d H:i:s');
	    $create_ip  	= $this->input->ip_address();
		$token   	= escape($this->input->post('tokenId', TRUE));
		$username   = escape($this->input->post('username', TRUE));
		$password 	= escape($this->input->post('password', TRUE));
		$group		= escape($this->input->post('groupid', TRUE));
		
		$nip	 = escape($this->input->post('nip', TRUE));
		$cekPegawai = $this->getDetailPegawai($nip);
		if ($cekPegawai['status']==false) 
		{
			return array('message'=>'NOPEG', 'note'=>$username);
			echo "dsadsasda";
		}
		else
		{
			$id_opd = $cekPegawai['result']->opd_id;
			$nm_opd = $cekPegawai['result']->opd_nm;
			$sub_opd = $cekPegawai['result']->sub_opd_id;
			$nm_sub_opd = $cekPegawai['result']->sub_opd_nm;
			$jns_jbtn_id = $cekPegawai['result']->jns_jbtn_id;
			$jns_jbtn_nm = $cekPegawai['result']->jns_jbtn_nm;
			$jns_jbtn_nm = $cekPegawai['result']->jns_jbtn_nm;
			$jabatan_id = $cekPegawai['result']->jabatan_id;
			$jabatan_nm = $cekPegawai['result']->jabatan_nm;
			$pangkat = $cekPegawai['result']->pangkat;
			$eselon_id = $cekPegawai['result']->eselon_id;
			$eselon_nm = $cekPegawai['result']->eselon_nm;
			$jenjang_nm = $cekPegawai['result']->jenjang_nm;
			
				$data = array(
					'username'  	=> $username,
					'email' 	  	=> escape($this->input->post('email', TRUE)),
					'fullname' 		=> escape($this->input->post('fullname', TRUE)),
					'blokir'    	=> escape($this->input->post('blokir', TRUE)),
					'id_status' 	=> escape($this->input->post('status', TRUE)),
					'id_opd' 				=> escape($id_opd),
					'nm_opd' 				=> escape($nm_opd),
					'sub_opd' 				=> escape($sub_opd),
					'nm_sub_opd' 			=> escape($nm_sub_opd),
					'jns_jbtn_id' 			=> escape($jns_jbtn_id),
					'jns_jbtn_nm' 			=> escape($jns_jbtn_nm),
					'jabatan_id' 			=> escape($jabatan_id),
					'jabatan_nm' 			=> escape($jabatan_nm),
					'eselon_id' 			=> escape($eselon_id),
					'eselon_nm' 			=> escape($eselon_nm),
					'nip' 					=> escape($nip),
					'pangkat' 				=> escape($pangkat),
					'jenjang' 				=> escape($jenjang_nm),
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
  }
	/*---------------------------------Data Pegawai Simpeg------------------------------------*/
}

// This is the end of auth signin model
