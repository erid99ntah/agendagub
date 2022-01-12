<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of model agenda
 *
 * @author Diskominfo Sumbar
 */

class Model_draft extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function getStatusAgenda($id_status)
	{
		$this->db->select('nm_status');
		$this->db->from('master_status');
		$this->db->where('id_status', $id_status);
		$query = $this->db->get();

		return $query->row_array()['nm_status'];
	}

	public function getListDataDraft($id_group)
	{
		$this->db->select('a.id_agenda, a.token,a.jenis_agenda, a.nama_agenda,a.status_disposisi, a.tanggal,
						   a.penerima,a.id_status, a.status_verifikasi, a.jam_mulai, a.jam_selesai, 
						   a.kegiatan, a.lokasi_kegiatan, a.dokumen,a.keterangan, a.create_date, b.nm_status');
        $this->db->from('data_agenda a');
        $this->db->join('master_status b',  'b.id_status = a.status_verifikasi', 'INNER');
        if ($id_group==='AJD') { 
        	 $this->db->where('a.id_status', 'SM');
        }
        elseif ($id_group==='PIM') {
        	$this->db->where('a.jenis_agenda', 'P');
        	$this->db->where('a.id_status', 'SM');
        }      
        $this->db->group_by('a.id_agenda');
        $this->db->order_by('a.id_agenda DESC');
        $data = $this->db->get();
        return $data->result_array();
	}

	public function getDetailDraft($token)
	{
		$this->db->select('a.id_agenda, a.token,a.jenis_agenda, a.nama_agenda,a.status_disposisi, a.tanggal,
						   a.penerima,a.id_status, a.id_opd, a.status_verifikasi, a.jam_mulai, a.jam_selesai, 
						   a.kegiatan, a.lokasi_kegiatan, a.dokumen, a.keterangan, a.create_date, b.nm_status');
        $this->db->from('data_agenda a');
        $this->db->join('master_status b',      'b.id_status 	= a.status_verifikasi');
       // $this->db->where('a.status_verifikasi', 'SM');
        $this->db->where('a.token', $token);

        $data = $this->db->get();
        return $data->row_array();
	}

	public function approveDraft($token,$id_user)
	{		
		$status_verifikasi='CC';
		$dataDetail = $this->mag->getDetailDraft($token);
		$penerima = $dataDetail['penerima'];
		$nm_pengirim = $this->mmas->getUserFullname($id_user);
		$token_disposisi='';
		$tipe_notifikasi='SR';
		$pesan_notifikasi='Ada draft yang harus diverifikasi';
	
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
		}


		$data = array(					
			'status_verifikasi'	=> escape($status_verifikasi),					
			'pesan_verifikasi'	=> escape($this->input->post('pesan_verifikasi'))
		);
		$this->db->where('token', $token);
		$this->db->update('data_agenda', $data);

		return TRUE;					
	}

	public function rejectDraft($token)
	{		
		$status_verifikasi='LK';

		$data = array(					
			'status_verifikasi'	=> escape($status_verifikasi),					
			'pesan_verifikasi'	=> escape($this->input->post('pesan_verifikasi'))
		);
		$this->db->where('token', $token);
		$this->db->update('data_agenda', $data);

		return TRUE;					
	}	

	public function validasiDataAgendaPimpinan()
	{	
		$id_status = $this->input->post('id_status');
		if ($id_status=='SW') {
			$this->form_validation->set_rules('id_penerima',   	 'Penerima',  'trim|required');	
			$this->form_validation->set_rules('keterangan',  	 'Isi Disposisi',  'trim|required');	
		}
		$this->form_validation->set_rules('id_status',   'Status Agenda',  'trim|required');
	
	  //	validation_message_setting();
	    if ($this->form_validation->run() == FALSE)
	      return false;
	    else
	      return true;
	}

	public function insertDataReview()
	{
		$create_by    = escape($this->input->post('create_by'));
		$id_user = $create_by;
		$create_date  = gmdate('Y-m-d H:i:s', time()+60*60*7);
		$create_ip    = $this->input->ip_address();

		$id_status  = escape($this->input->post('id_status'));
		$token  = escape($this->input->post('token'));
		$detail = $this->mag->getDetailDraft($token);
		$id_agenda = $detail['id_agenda'];
		$url = create_url($detail['nama_agenda']);

		$opd_pengirim = $this->getIdOpdByUserid($create_by);
		$id_opd_pengirim = $opd_pengirim['id_opd'];

		$status_disposisi="BD";
		$draft_agenda="";

		$data = array(			
				'id_status'	  		=> escape($id_status),				
				'keterangan_hadir'	=> escape(escape($this->input->post('keterangan'))),				
				'mod_by'	  => $create_by,
				'mod_date'	  => $create_date,
				'mod_ip'	  => $create_ip
			);
			$this->db->where('token', $token);
			$this->db->update('data_agenda', $data);						
			
		if ($id_status=='SW') {

			$tokenDisposisi= generateToken($url.'-'.$create_date, $create_by);
			$dataDisposisi = array(
				'token'			  => $tokenDisposisi,
				'id_agenda'	      => escape($id_agenda),				
				'tgl_disposisi'	  => escape($create_date),
				'isi_disposisi'	  => escape($this->input->post('keterangan', TRUE)),
				'id_pengirim'	  => escape($create_by),				
				'id_opd'	  	  => escape($id_opd_pengirim),						
				'create_by'		  => $create_by,
				'create_date'	  => $create_date,
				'create_ip'		  => $create_ip,
				'mod_by'		  => '',
				'mod_date'		  => '',
				'mod_ip'		  => ''
			);
			$this->db->insert('data_disposisi', $dataDisposisi);
			$id_disposisi = $this->db->insert_id();

			$disposisiMasuk = array(
				'token'			  => $tokenDisposisi,
				'id_disposisi'	  => escape($id_disposisi),				
				'id_penerima'	  => escape($this->input->post('id_penerima', TRUE)),
				'tgl_terima'	  => '',
				'status_penerima' => 'BD',
				'pesan_penerima'  => '',				
				'create_by'		  => $create_by,
				'create_date'	  => $create_date,
				'create_ip'		  => $create_ip,
				'mod_by'		  => '',
				'mod_date'		  => '',
				'mod_ip'		  => ''
			);

			$penerima = escape($this->input->post('id_penerima', TRUE));
			$nm_pengirim = $this->mmas->getUserFullname($create_by);
			$token_disposisi=$tokenDisposisi;
			$tipe_notifikasi='DM';
			$pesan_notifikasi='Ada disposisi masuk';
		
			$regId = $this->mmas->getDeviceIdUser($penerima);
			
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
			}

			$this->db->insert('data_disposisi_masuk', $disposisiMasuk);
		}
		return TRUE;		
	}

	public function getDataPenerima($jenis_agenda)
	{
		$this->db->select('token, fullname, id_opd, nm_opd');
		$this->db->from('xi_sa_users');
		if ($jenis_agenda=='P') {
			$this->db->where('account_type', 3);
		}		 
		$this->db->where('id_users !=', 1);

		$data=$this->db->get();
		return $data->result_array();
	}

	public function validasiDataAgendaSekretaris()
	{	
		$id_status = $this->input->post('id_status');
		if ($id_status=='SW') {
			$this->form_validation->set_rules('create_by',   	 'Nama Pengirim',  'trim|required');	
			$this->form_validation->set_rules('id_penerima',   	 'Penerima',  		'trim|required');	
			$this->form_validation->set_rules('keterangan',  	 'Isi Disposisi',  'trim|required');	
		}
		$this->form_validation->set_rules('id_status',   'Status Agenda',  'trim|required');
	
	  //	validation_message_setting();
	    if ($this->form_validation->run() == FALSE)
	      return false;
	    else
	      return true;
	}

	public function insertDataValidasi()
	{
		$create_by    = escape($this->input->post('create_by'));
		$userid=$create_by;
		$create_date  = gmdate('Y-m-d H:i:s', time()+60*60*7);
		$create_ip    = $this->input->ip_address();

		$id_status  = escape($this->input->post('id_status'));
		$token  = escape($this->input->post('token'));
		$detail = $this->mag->getDetailDraft($token);
		$id_agenda = $detail['id_agenda'];
		$url = create_url($detail['nama_agenda']);

		
		$status_disposisi="BD";
		$draft_agenda="";
		$status_verifikasi="CC";

		$opd_pengirim = $this->getIdOpdByUserid($create_by);
		$id_opd_pengirim = $opd_pengirim['id_opd'];

		$data = array(			
				'status_verifikasi'	  => escape($status_verifikasi),					
				'id_status'	  		=> escape($id_status),				
				'keterangan_hadir'	=> escape(escape($this->input->post('keterangan'))),				
				'mod_by'	  => $create_by,
				'mod_date'	  => $create_date,
				'mod_ip'	  => $create_ip
			);
			$this->db->where('token', $token);
			$this->db->update('data_agenda', $data);						
			
		if ($id_status=='SW') {

			$tokenDisposisi= generateToken($url.'-'.$create_date, $create_by);
			$dataDisposisi = array(
				'token'			  => $tokenDisposisi,
				'id_agenda'	      => escape($id_agenda),				
				'tgl_disposisi'	  => escape($create_date),
				'isi_disposisi'	  => escape($this->input->post('keterangan', TRUE)),				
				'id_pengirim'	  => escape($create_by),				
				'id_opd'	  	  => escape($id_opd_pengirim),				
				'jenis_disposisi' => 'D',				
				'create_by'		  => $create_by,
				'create_date'	  => $create_date,
				'create_ip'		  => $create_ip,
				'mod_by'		  => '',
				'mod_date'		  => '',
				'mod_ip'		  => ''
				);
			$this->db->insert('data_disposisi', $dataDisposisi);
			$id_disposisi = $this->db->insert_id();

			$id_penerima = escape($this->input->post('id_penerima', TRUE));
			$userpenerima = explode(',', rtrim($id_penerima, ','));
			$totpenerima = count($userpenerima);
			for ($i=0; $i < $totpenerima; $i++)
			{ 	
				$urlDisposisi = create_url($this->input->post('keterangan', TRUE));
				$tokenDisposisiMasuk= generateToken($url.'-'.$create_date, $userpenerima[$i]);

				$opd_penerima = $this->getIdOpdByUserid($userpenerima[$i]);
				$id_opd_penerima = $opd_penerima['id_opd'];

				$disposisiMasuk = array(
						'token'			  => $tokenDisposisiMasuk,
						'id_disposisi'	  => escape($id_disposisi),				
						'id_penerima'	  => escape($userpenerima[$i]),
						'id_opd'	  	  => escape($id_opd_penerima),
						'tgl_terima'	  => '',
						'status_penerima' => 'BD',
						'pesan_penerima'  => '',				
						'status_disposisi'  => 'SH',				
						'create_by'		  => $create_by,
						'create_date'	  => $create_date,
						'create_ip'		  => $create_ip,
						'mod_by'		  => '',
						'mod_date'		  => '',
						'mod_ip'		  => ''
				);
				$this->db->insert('data_disposisi_masuk', $disposisiMasuk);

				$nm_pengirim = $this->mmas->getUserFullname($create_by);
				$token_disposisi=$tokenDisposisi;
				$tipe_notifikasi='DM';
				$pesan_notifikasi='Ada disposisi masuk';
			
				$regId = $this->mmas->getDeviceIdAllUsers($userpenerima);			
				
				$id_status='0';
        		$token_notifikasi = generateToken($token, $create_date);

				 $dataNotif = array(
		          'token_notifikasi' => $token_notifikasi,
		          'token_agenda'     => escape($token),
		          'token_disposisi'  => $token_disposisi,
		          'id_pengirim'      => $userid,
		          'id_penerima'      => $userpenerima[$i],
		          'tipe_notifikasi'  => $tipe_notifikasi,
		          'pesan_notifikasi' => $pesan_notifikasi,
		          'id_status'        => $id_status,
		          'create_by'        => $create_by,
		          'create_date'      => $create_date,
		          'create_ip'        => $create_ip,
		          'mod_by'           => '',
		          'mod_date'         => '',
		          'mod_ip'           => ''
		        );
		        $this->db->insert('data_notifikasi', $dataNotif);
				
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
				}
				
			}
		}
		return TRUE;		
	}

	public function getIdOpdByUserid($userid)
    {
        $this->db->select('id_opd, sub_opd');
        $this->db->from('xi_sa_users');
        $this->db->where('token', $userid);
        $data = $this->db->get();

        return $data->row_array();
    }

    public function validasiDraft($role)
	{
		$this->form_validation->set_rules('nama_agenda',    'Nama Agenda',  'trim|required|min_length[3]');
		$this->form_validation->set_rules('jenis_agenda',   'Jenis Agenda', 'required|trim');
		$this->form_validation->set_rules('penerima', 		'Penerima', 	'required|trim');
		$this->form_validation->set_rules('tanggal', 	    'Tanggal',      'required');
		$this->form_validation->set_rules('jam_mulai', 	    'Jam Mulai',    'required');
		$this->form_validation->set_rules('jam_selesai', 	'Jam Selesai',  'required');
		$this->form_validation->set_rules('kegiatan',       'Kegiatan',      'required|trim');
		$this->form_validation->set_rules('lokasi_kegiatan','Lokasi Kegiatan',      'required|trim');
		//$this->form_validation->set_rules('penyelenggara',  'Penyelenggara Kegiatan',      'required|trim');
		//$this->form_validation->set_rules('cp',  		    'Contact Person',      'required|trim');
		$this->form_validation->set_rules('create_by',       'Create By',      'required|trim');
		
		validation_message_setting();
		if ($this->form_validation->run() == FALSE)
			return false;
		else
			return true;
	}

	public function insertDataDraft()
	{
		$create_by    = escape($this->input->post('create_by', TRUE));
		$create_date  = gmdate('Y-m-d H:i:s', time()+60*60*7);
		$create_ip    = $this->input->ip_address();
		$nama_agenda  = escape($this->input->post('nama_agenda', TRUE));
		$token		  = generateToken($nama_agenda.'-'.$create_date, $create_by);
		$id_opd       =1;
		$status_disposisi="BD";
		$draft_agenda="";
		$id_status="SM";

		$base64 = $this->input->post('dokumen', TRUE);
       	$tahun = date('Y');
        $bulan = date('m');

       		$data = array(
					'token'			  => $token,
					'nama_agenda'	  => escape($this->input->post('nama_agenda', TRUE)),				
					'tanggal'		  => escape($this->input->post('tanggal', TRUE)),
					'id_opd'		  => escape($id_opd),
					'penerima'		  => escape($this->input->post('penerima', TRUE)),
					'jenis_agenda'	  => escape($this->input->post('jenis_agenda', TRUE)),
					'jam_mulai'	      => escape($this->input->post('jam_mulai', TRUE)),				
					'jam_selesai'	  => escape($this->input->post('jam_selesai', TRUE)),
					'kegiatan'		  => escape($this->input->post('kegiatan', TRUE)),
					'lokasi_kegiatan' => escape($this->input->post('lokasi_kegiatan', TRUE)),
					//'penyelenggara' => escape($this->input->post('penyelenggara', TRUE)),
					//'cp' => escape($this->input->post('cp', TRUE)),
					'keterangan'	  => escape($this->input->post('keterangan', TRUE)),				
					'dokumen'		  => '',	
					'status_verifikasi'=> escape('CC'),				
					'status_disposisi'=> escape($status_disposisi),				
					'id_status'		  => escape($id_status),				
					'create_by'		  => $create_by,
					'create_date'	  => $create_date,
					'create_ip'		  => $create_ip,
					'mod_by'		  => '',
					'mod_date'		  => '',
					'mod_ip'		  => ''

					);
					$this->db->insert('data_agenda', $data);	

		set_time_limit(0);
		ini_set("memory_limit", '-1');

	 	if ($base64 !='' || $base64 !=NULL  ) 
	 	{
	 		$this->uploadBase64($token, $base64, $tahun, $bulan);
	 	}	

		return array('message'=>'SUCCESS', 'token'=>$token);//'nama_agenda'=>$nama_agenda, 'notifikasi'=>$errNotifikasi);	
	}

	public function uploadBase64($token, $base64, $tahun, $bulan)
	{
		 if ($base64 !='' || !empty($base64) || $base64!==NULL) 
         {
        	
        	$tanggalgambar  = gmdate('d-m-Y_H-i-s', time()+60*60*7);
			$upload_path = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']).'../images/agenda/'.$tahun.'/'.$bulan.'/';	
			$imageData = base64_decode($base64);
	        $filename = "agendagub_".$tanggalgambar.'.pdf';
	        $ads = file_put_contents($upload_path.'/'.$filename, $imageData);	 

	        $data = array(					
				'dokumen'	=> escape($filename)
			);
			$this->db->where('token', $token);
			$this->db->update('data_agenda', $data);
         }
	}

	public function getListPenerimaAgenda()
    {
        $this->db->select('token, fullname, id_opd,nm_opd, sub_opd, nm_sub_opd');
        $this->db->from('xi_sa_users');
        $this->db->where('id_opd', '1');
        $this->db->where('id_users >=', 90);

        $data = $this->db->get();
        return $data->result_array();      
    }
}

// This is the end of agenda model
