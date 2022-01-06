<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of login class
 *
 * @author Yogi "solop" Kaputra
 */

class Signin extends MY_Controller {

	var $username;
	var $password;
	var $ip_address;
	var $user_agent;
	var $captcha;

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('model_auth_signin' => 'mas'));
		$this->username 	= addslashes(escape(trim($this->input->post('username', TRUE))));
		$this->password 	= escape($this->input->post('password', TRUE));
		$this->captcha		= addslashes(escape(trim($this->input->post('captcha', TRUE))));
		$this->ip_address = addslashes($this->input->ip_address());
		$this->user_agent = addslashes($this->input->user_agent());	   
	}

	
	public function login()
	{		
		if($this->input->post('submit', TRUE))
			$this->prosesLoginForm();
		elseif($this->input->post('next', TRUE))
			$this->prosesSelectGroupForm();
		else
			$this->createLoginForm();				
	}
	
	private function createLoginForm()
	{
		$list = array();
		$tot_error = $this->session->userdata('error_session');
		if($this->is_captcha($tot_error) == TRUE)
			$list['captcha_img'] = $this->create_captcha();
		$this->load->view('form_login', $list);
	}

	private function createSelectGroupForm($datagroup)
	{
		$data['multi_group'] = $datagroup;
		$this->load->view('form_select_group', $data);
	}

	private function prosesLogin(){
		if(($this->input->post('tipe', TRUE))=='asn')
			$this->prosesLoginForm();
		else
			$this->prosesLoginAspirasi();
	}

	private function prosesLoginForm()
	{
		$total = $this->session->userdata('error_session');
		if($this->mas->validasiDataValue($total) == FALSE) {
			error_message('danger', 'Peringatan!', 'Data wajib diisi...');
			$this->createLoginForm();
		} else {
			if(($total >= 5) && ($this->mas->checkCaptcha($this->ip_address, $this->captcha) <= 0)) {
				error_message('danger', 'Peringatan!', 'Kode yang anda masukan tidak sesuai...');
				$this->createLoginForm();
			} else {
				//cek username yang diinputkan pertama
				$cekuser = $this->mas->cekDataUsername($this->username);
				if(empty($cekuser) OR count($cekuser) <= 0){
					error_message('danger', 'Peringatan!', 'Username anda tidak ditemukan...');
					//insert error ke dalam session
					$this->set_error_session();
					$this->createLoginForm();
				} else {
					//cek username dan password
					if($this->is_password($this->username, $this->password) === FALSE) {
						//insert error log ke table log login
						$this->mas->setLoginFailed($this->username, $this->ip_address, $this->user_agent);
						$blockir = $this->cek_blockir($this->username);
						if($blockir >= 7 && $blockir < 10)
							error_message('danger', 'Peringatan!', 'Anda sudah '.$blockir.' kali salah menginputkan password, kesempatan anda '.(10 - $blockir).' kali lagi. Jika masih salah akun diblokir otomatis...');
						else if($blockir >= 10) {
							$this->mas->setAccountUserBlock($this->username);
							error_message('danger', 'Peringatan!', 'Akun anda sudah diblokir, silahkan hubungi administrator...');
						} else
						error_message('danger', 'Peringatan!', 'Username dan Password anda tidak cocok...');
						//insert error ke dalam session
						$this->set_error_session();
						$this->createLoginForm();
					} else {
						//cek akun aktif atau tidak
						if($this->is_actived($this->username) === FALSE) {
							error_message('danger', 'Peringatan!', 'Akun anda sudah tidak aktif, silahkan hubungi administrator...');
							$this->createLoginForm();
						} else {
							//cek akun blokir atau tidak
							if($this->is_blockir($this->username) === TRUE) {
								error_message('danger', 'Peringatan!', 'Akun anda saat ini sedang diblokir, silahkan hubungi administrator...');
								$this->createLoginForm();
							} else {
								//set session username
								$this->session->set_userdata('account_name', $this->username);
								//delete failed log
								$this->mas->deleteFailedLog($this->username);
								//insert success login
								$this->mas->setSuccessLog($this->username, $this->ip_address, $this->user_agent);
								//ambil group user
								$getGroup = $this->mas->getDataUserGroup($this->username);
								if(count($getGroup) > 1) {
									//multi group
									$this->session->set_flashdata('message', '');
									$this->createSelectGroupForm($getGroup);
								} elseif(count($getGroup) == 1) {
									//set login time
									$this->expired_login->login_time();
									//set session satu group
									$this->set_session($this->username, $getGroup[0]['id_group']);
									redirect('home');
								}
							}
						}
					}
				}
			}
		}
	}

	private function prosesSelectGroupForm()
	{
		$username = $this->session->userdata('account_name');
		$getGroup = $this->mas->getDataUserGroup($username);
		if($this->mas->validasiDataGroupValue() == FALSE) {
			error_message('danger', 'Peringatan!', 'Group wajib dipilih...');
			$this->createSelectGroupForm($getGroup);
		} else {
			$group = $this->input->post('pilgroup', TRUE);
			$this->switch_group($group);
		}
	}

	private function is_password($username, $password)
	{
		$validpass = $this->mas->cekDataUsernamePass($username, $password);
		return $validpass;
	}

	private function is_actived($username)
	{
		$actived = $this->mas->cekDataUserActive($username);
		return $actived;
	}

	private function is_blockir($username)
	{
		$blocked = $this->mas->cekDataUserBlock($username);
		return $blocked;
	}

	private function cek_blockir($username)
	{
		$log = $this->mas->getCountFailedLog($username);
		return $log->num_rows();
	}

	/**
   * Fungsi untuk melakukan hitung error login
   */
	private function set_error_session()
	{
		$getError = $this->session->userdata('error_session');
		if(isset($getError))
			$num = $getError;
		else
			$num = 0;
		$this->session->set_userdata('error_session', $num+1);
		//return $num;
	}

	/**
   * Fungsi untuk ngecek apakah user yang gagal login berulang kali
   * dan perlu untuk ditampilkan captcha
   * @access Private
   * @return boolean True jika telah melakukan kesalahan lebih dari 5 kali
   */
	private function is_captcha($total_error) {
		if ($total_error >= 5)
			return true;
		else
			return false;
	}

	private function set_session($username, $group)
	{	
		//ambil data user berdasarkan group
		$dataUser = $this->mas->getDataUserProperties($username, $group);
		if(count($dataUser) > 0) {
			$session['id_users']  			= $dataUser['id_users'];
			$session['fullname']  			= $dataUser['fullname'];
			$session['group_active']		= $dataUser['id_group'];
			$session['group_name']			= $dataUser['nama_group'];
			$session['id_level_akses']	    = $dataUser['id_level_akses'];
			$session['level_akses']			= $dataUser['level_akses'];
			$session['nick_level']			= $dataUser['nick_level'];
			$session['userid']			    = $dataUser['token'];
			$session['id_opd']			    = $dataUser['id_opd'];
			
			//simpan session
			$this->session->set_userdata($session);
		} else
		redirect('signin/logout');
	}

	/**
   * Fungsi untuk melakukan set sesi grup
   * @param array $session_data
   */
	private function set_group_session($username)
	{
		//set group session
		$dataGroup = $this->mas->getDataUserGroup($username);
		$sess = array();
		foreach ($dataGroup as $key => $v) {
			$data['id_group'] = $v['id_group'];
			$data['nama_group'] = $v['nama_group'];
			$sess['group_switch'][] = $data;
		}
		$this->session->set_userdata($sess);
	}

	public function switch_group($group)
	{
		$username 	= $this->session->userdata('account_name');
		$session_id = $this->session->userdata('EAgendaApp@2021Session');
		$statuslog	= $this->mas->cekSessionLog($username, $this->ip_address, $this->user_agent, $session_id);
		if($statuslog != 0 AND !empty($session_id) AND !empty($username) AND ((!empty($group) OR $group != 0 OR $group != ''))) {
			//set login time
			$this->expired_login->login_time();
			//set session user
			$this->set_session($username, $group);
			//set group session
			$this->set_group_session($username);
			//redirect ke home
			redirect('home');
		} else
		redirect('signin/logout');
	}

	private function create_captcha()
	{
		$vals = array(
			'img_path' 		=> './captcha/',
			'img_url' 		=> site_url('captcha/'),
			'font_path'   => './assets/fonts/captcha/Chunk.ttf',
			'img_width' 	=> 200,
			'img_height' 	=> 50,
			'expiration' 	=> 120,
			'word_length' => 5,
			'font_size'   => 30,
			'img_id'      => 'Imageid',
			'pool'        => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

      // White background and border, black text and red grid
			'colors'     	=> array(
				'background' 	=> array(255, 255, 255),
				'border' 			=> array(255, 255, 255),
				'text' 				=> array(217, 83, 79),
				'grid' 				=> array(255, 192, 203)
				)
			);
		$cap = create_captcha($vals);
		$this->mas->setCaptcha($cap);

		$html = '<div class="form-group">
		<div class="col-sm-12">
			<p>'.$cap['image'].'</p>
			<input type="text" class="form-control" name="captcha" placeholder="Masukan Kode">
			'.form_error('captcha').'
		</div>
	</div>';

	return $html;
}

	//fungsi untuk menghapus session
private function destroy_session()
{
	$array_session = array(	'account_name', 'nama_user', 'group_active',
		'group_name', 'group_switch', 'id_level_akses',
		'level_akses', 'nick_level', 'error_session',
		'userid', 'EAgendaApp@2021Session');
	$this->session->unset_userdata($array_session);
}

public function logout()
{
	$this->session->unset_userdata('expires_by');
	$username  	= $this->session->userdata('account_name');
	$session_id = $this->session->userdata('EAgendaApp@2021Session');
	$ip_address = $this->input->ip_address();
	$user_agent = $this->input->user_agent();
	$this->mas->updateDataSessionLog($session_id, $username, $ip_address, $user_agent);
	$this->destroy_session();
	error_message('info', 'Informasi!', 'Anda telah keluar dari aplikasi agenda...');
    //redirect('signin/login');
	header("location: ".base_url());
}

public function timeout()
{
	$this->session->unset_userdata('expires_by');

	$username  	= $this->session->userdata('account_name');
	$session_id = $this->session->userdata('EAgendaApp@2021Session');
	$ip_address = $this->input->ip_address();
	$user_agent = $this->input->user_agent();

	$this->mas->updateDataSessionLog($session_id, $username, $ip_address, $user_agent);
	$this->destroy_session();
	error_message('info', 'Informasi!', 'Maaf sesi anda telah habis. Silahkan masukkan Username dan Password anda kembali...');
    //redirect('signin/login');
	header("location: ".base_url());
}

/*------------------------------------------------Aspirasi----------------------------------------------*/
private function getContent($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $URL);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}


private function prosesLoginAspirasi()
{	
	$total = $this->session->userdata('error_session');
	if($this->mas->validasiDataValue($total) == FALSE) {
		error_message('danger', 'Peringatan!', 'Data wajib diisi...');
		$this->createLoginForm();
	}
	else
	{	    	    
		$postRequest = array(
			'username' => $this->username,
			'password' => $this->password
			);

		$cURLConnection = curl_init('http://aspirasi.dprd.sumbarprov.go.id/api/cek_login_dprd');
		curl_setopt($cURLConnection, CURLOPT_POST, 1);
		curl_setopt($cURLConnection, CURLOPT_POSTFIELDS,"username=$this->username&password=$this->password");
		curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

		$apiResponse = curl_exec($cURLConnection);
		curl_close($cURLConnection);

			// $apiResponse - available data from the API request
		$jsonArrayResponse = json_decode($apiResponse);
		
		if ($jsonArrayResponse ==TRUE) 
		{
			if($jsonArrayResponse->status =='Success')
			{	
				$cek = $this->mas->checkUserAspirasi($jsonArrayResponse,$this->password);
				if ($cek ==TRUE) 
				{				
							//set session username
					$this->session->set_userdata('account_name', $this->username);
							//delete failed log
					$this->mas->deleteFailedLog($this->username);
							//insert success login
					$this->mas->setSuccessLog($this->username, $this->ip_address, $this->user_agent);
							//ambil group user
					$getGroup = $this->mas->getDataUserGroup($this->username);
					
					if(count($getGroup) > 1) {
								//multi group
						$this->session->set_flashdata('message', '');
						$this->createSelectGroupForm($getGroup);
					} elseif(count($getGroup) == 1) {
								//set login time
						$this->expired_login->login_time();
								//set session satu group
						$this->set_session($this->username, $getGroup[0]['id_group']);
						redirect('home');
					}	
				}
				else{
					error_message('danger', 'Peringatan! <br>', 'Gagal...');
					$this->createLoginForm();
				}				
			}
			else
			{
				error_message('danger', 'Peringatan! <br>', ' '.$jsonArrayResponse->message.' <br>Cek Akun Aspirasi Anda...');
				$this->createLoginForm();
			}
		}
		else
		{
			echo "Server Not Responding";
		}
	}
}
/*------------------------------------------------Aspirasi----------------------------------------------*/


/*------------------------------------------------Login----------------------------------------------*/

/*------------------------------------------------Login----------------------------------------------*/
}

// This is the end of home class
