<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of model agenda
 *
 * @author Diskominfo Sumbar
 */

class Model_account extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

    public function validasiDataSandi()
	{
	  	$this->form_validation->set_rules('password', 	   'Sandi Lama', 			'required|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/]');
	    $this->form_validation->set_rules('password_baru', 'Sandi Baru', 			'required|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/]');
	  	$this->form_validation->set_rules('conf_password', 'Konfirmasi Sandi Baru', 'required|matches[password_baru]');
			
	  	validation_message_setting();
	    if ($this->form_validation->run() == FALSE)
	      return false;
	    else
	      return true;
	}

	
    public function updatePassword()
	{
	    $token = escape($this->input->post('token', TRUE));
		$cek = $this->getUsersProfileByToken($token);

		$password = escape($this->input->post('password', TRUE));
		$password_baru = escape($this->input->post('password_baru', TRUE));

		if (count($cek) <=0) 
		{
			return array('status'=>FALSE, 'message'=>'Data pengguna tidak ditemukan');
		}
		else
		{
			$token 		    = $cek['token'];
			$hash_password  = $cek['password'];
			$id_users  	    = $cek['id_users'];
		
			if ($this->bcrypt->check_password($password, $hash_password))
			{	
				$data = array('password' => $this->bcrypt->hash_password($password_baru));

				$this->db->where('id_users', $id_users);
				$this->db->where('token', $token);
				$this->db->update('xi_sa_users', $data);
			
				return array('status'=>TRUE, 'message'=>'Password berhasil diubah');
			
			}
			else
			{
				return array('status'=>FALSE, 'message'=>'Password lama salah');
			}
		}
	}


	public function getUsersProfileByToken($token)
    {
        $this->db->select('id_users,token, fullname, username, password');
        $this->db->from('xi_sa_users');
        $this->db->where('token', $token);

        $data = $this->db->get();
        return $data->row_array();      
    }
}

// This is the end of agenda model
