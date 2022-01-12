<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of model notifikasi
 *
 * @author Diskominfo Sumbar
 */

class Model_notifikasi extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function getDetailDraft($token_agenda)
	{
		$this->db->select('id_agenda');
        $this->db->from('data_agenda');
        $this->db->where('token', $token_agenda);
        $data = $this->db->get();

        return $data->row_array();
	}

	public function getDetailDisposisiMasuk($token_agenda)
	{
		$this->db->select('id_agenda');
        $this->db->from('data_agenda');
        $this->db->where('token_agenda', $token_agenda);
        $data = $this->db->get();

        return $data->row_array();
	}

	public function getDetailNotifikasi($token_notifikasi)
	{
		$this->db->select('id_notifikasi');
        $this->db->from('data_notifikasi');
        $this->db->where('token_notifikasi', $token_notifikasi);
        $data = $this->db->get();

        return $data->row_array();
	}

	public function validasiDataNotifikasi($rule)
	{	
		$arrDisposisi=array('DM');
		$arrDraft=array('SM', 'SR', 'SV');

		$tipe_notifikasi = $this->input->post('tipe_notifikasi');
		if (in_array($tipe_notifikasi, $arrDisposisi)) {
				$this->form_validation->set_rules('token_disposisi',  'Token Disposisi',  'trim|required');	
		}

		if (in_array($tipe_notifikasi, $arrDraft)) {
				$this->form_validation->set_rules('token_agenda',  'Token Agenda',  'trim|required');	
		}
			
		$this->form_validation->set_rules('id_pengirim',  	 'Pengirim',  'trim|required');	
		$this->form_validation->set_rules('id_penerima',  	 'Penerima',  'trim|required');	
		$this->form_validation->set_rules('tipe_notifikasi', 'Tipe Notifikasi',  'trim|required');	
		$this->form_validation->set_rules('pesan_notifikasi', 'Pesan Notifikasi',  'trim|required');	
		
		validation_message_setting();
	    if ($this->form_validation->run() == FALSE)
	      return false;
	    else
	      return true;
	}

	public function insertDataNotifikasi()
	{
		$create_by    = escape($this->input->post('create_by'));
		$create_date  = gmdate('Y-m-d H:i:s', time()+60*60*7);
		$create_ip    = $this->input->ip_address();

		$id_status  =0;	
		$url = create_url(escape($this->input->post('pesan_notifikasi')));
		$id_pengirim = escape($this->input->post('id_pengirim'));		

		
		$id_penerima = escape($this->input->post('id_penerima', TRUE));
		$userpenerima = explode(',', rtrim($id_penerima, ','));
		$totpenerima = count($userpenerima);
		for ($i=0; $i < $totpenerima; $i++)
		{ 	
			$token_notifikasi= generateToken($url.'-'.$create_date, $userpenerima[$i]);
			$data   = array(
					'token_notifikasi'=> escape($token_notifikasi),
					'token_agenda'	  => escape($this->input->post('token_agenda')),				
					'token_disposisi' => escape($this->input->post('token_disposisi')),				
					'id_pengirim'	  => escape($this->input->post('id_pengirim')),				
					'id_penerima'	  => escape($userpenerima[$i]),				
					'tipe_notifikasi' => escape($this->input->post('tipe_notifikasi')),				
					'pesan_notifikasi'=> escape($this->input->post('pesan_notifikasi')),				
					'id_status'	  	  => escape($id_status),									
					'create_by'		  => $create_by,
					'create_date'	  => $create_date,
					'create_ip'		  => $create_ip,
					'mod_by'		  => '',
					'mod_date'		  => '',
					'mod_ip'		  => ''
				);
				$this->db->insert('data_notifikasi', $data);
		}
		return TRUE;		
	}

	public function updateNotifikasi($token_notifikasi)
	{		
		$id_status=1;

		$data = array(					
			'id_status'	=> escape($id_status)
		);
		$this->db->where('token_notifikasi', $token_notifikasi);
		$this->db->update('data_notifikasi', $data);

		return TRUE;					
	}	


	public function getListNotifikasi($id_user)
	{
		$this->db->select('id_notifikasi, token_notifikasi, token_agenda, token_disposisi,
							id_pengirim, id_penerima, tipe_notifikasi, pesan_notifikasi, id_status,
							create_date');
        $this->db->from('data_notifikasi');
        $this->db->where('id_penerima', $id_user);
        $data = $this->db->get();

        return $data->result_array();
	}

	public function getDetailAgendaByToken($token)
	{
		$this->db->select('id_agenda, token, nama_agenda');
        $this->db->from('data_agenda');
        $this->db->where('token', $token);
        $this->db->limit(1);
        $data = $this->db->get();

        return $data->row_array();
	}

	public function getDetailDisposisiByToken($token)
	{
		$this->db->select('id_disposisi, tgl_disposisi, isi_disposisi');
        $this->db->from('data_disposisi');
        $this->db->where('token', $token);
        $this->db->limit(1);
        $data = $this->db->get();

        return $data->row_array();
	}

	/*$penerima = escape($this->input->post('penerima', TRUE));
					$id_user  = $this->mmas->getUsersProfileByUsername($this->input->post('create_by', TRUE))['token'];
					
					$nm_pengirim = $this->mmas->getUserFullnameByUsername($create_by);
					$token_disposisi='';
					$tipe_notifikasi='SM';
					$pesan_notifikasi='Ada draft baru';

					$itemsNotifikasi=array('token_agenda'	=>$token,
										   'token_disposisi'=>$token_disposisi,
										   'id_pengirim'=>$id_user,
										   'nm_pengirim'=>$nm_pengirim,
										   'id_penerima'=>$penerima,
										   'tipe_notifikasi'=>$tipe_notifikasi,
										   'pesan_notifikasi'=>$pesan_notifikasi
										   );
					$regId = $this->mmas->getDeviceIdAllUsers($penerima);
					
					$this->mmas->insertNotification($token, $token_disposisi, $id_user, $penerima, $tipe_notifikasi, $pesan_notifikasi);
					
					
					$items = array('data' => array('title'   => $nm_pengirim,
												   'message' => $pesan_notifikasi,
									  		   	   'tipe_notifikasi' => $tipe_notifikasi
												   ));

					$kirim_notifikasi = $this->mmas->sendNotification($regId, $items);
					if ($kirim_notifikasi==false) {
						$errNotifikasi='Notifikasi Gagal Terkirim';
					}
					else{
						$errNotifikasi='Notifikasi Terkirim';
					}*/

}

// This is the end of notifikasi model
