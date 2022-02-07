<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of model agenda
 *
 * @author Diskominfo Sumbar
 */

class Model_draftnew extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
		
	}

	public function getDataPenerimaNew()
	{	
		$arr=array(1, 88);
			$this->db->where('id_opd ', 1);
			$this->db->where_not_in('id_users ', $arr);
			$this->db->where('id_jabatan', 1);
			$this->db->where('jenis_user', 1);
			$this->db->order_by('id_users ASC');
			$query = $this->db->get('xi_sa_users');
		    $dd_prov[''] = 'Pilih Penerima';
		    if ($query->num_rows() > 0) {
		      foreach ($query->result_array() as $row) {
		        $dd_prov[$row['token']] = $row['fullname'];
		      }
		    }
	    return $dd_prov;
	}

	public function getDaftarStatusAgenda()
	{	
		$query = $this->db->get('master_status');
		$dd[''] = 'Pilih Status Agenda';
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$dd[$row['id_status']] = $row['nm_status'];
			}
		}
		return $dd;
	}


	public function validasiDataValue()
	{
		$this->form_validation->set_rules('nama_agenda',   'Nama Agenda',  'trim|required|min_length[3]');		
		$this->form_validation->set_rules('penerima', 		'Penerima', 	'required|trim');
		$this->form_validation->set_rules('tanggal', 	    'Tanggal',      'required|valid_date');
		$this->form_validation->set_rules('jam_mulai', 	    'Jam Mulai',    'required');
		$this->form_validation->set_rules('jam_selesai', 	'Jam Selesai',  'required');
		$this->form_validation->set_rules('kegiatan',       'Kegiatan',      'required|trim');
		$this->form_validation->set_rules('lokasi_kegiatan',' Lokasi Kegiatan',      'required|trim');
		$this->form_validation->set_rules('penyelenggara',  'Penyelenggara Kegiatan',      'required|trim');		
		$this->form_validation->set_rules('id_status',	    'Status Draft',      'required|trim');
		validation_message_setting();
		if ($this->form_validation->run() == FALSE)
			return false;
		else
			return true;
	}

	var $search = array('a.nama_agenda', 'a.tanggal', 'a.kegiatan', 'a.lokasi_kegiatan');
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
		if(!$this->app_loader->is_admin()){

			if($this->app_loader->is_pimpinan()){
				$this->db->where('a.id_status', 'SM');
			}
		}
		return $this->db->count_all_results('data_agenda');
	}

	private function _get_datatables_query($param)
	{	
		$status=array('SH', 'SW');
		$status_verifikasi=array('SM', 'CC');

		$post = array();
		if (is_array($param)) {
			foreach ($param as $v) {
				$post[$v['name']] = $v['value'];
			}
		}
		$this->db->select('a.id_agenda, a.token,a.jenis_agenda, a.nama_agenda,a.status_disposisi, a.tanggal,
			a.penerima,a.id_status, a.status_verifikasi, a.jam_mulai, a.jam_selesai, a.kegiatan, a.lokasi_kegiatan, 
			a.penyelenggara, a.create_by, b.nm_status');
		$this->db->from('data_agenda a');
		$this->db->join('master_status b',      'b.id_status = a.id_status', 'INNER');

		/*if(!$this->app_loader->is_admin()){

			if($this->app_loader->is_pimpinan()){
				$this->db->where('a.id_status', 'SM');
			}
		}*/
		
		if(isset($post['jenis_agenda']) AND $post['jenis_agenda'] != '')
			$this->db->where('a.jenis_agenda', $post['jenis_agenda']);

		if(isset($post['status']) AND $post['status'] != '')
			$this->db->where('a.id_status', $post['status']);

		if(isset($post['tanggal']) AND $post['tanggal'] != '')
			$this->db->where('a.tanggal', $post['tanggal']);


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
		  $this->db->order_by('a.tanggal DESC');
		  $this->db->order_by('a.jam_mulai DESC');
		  $this->db->group_by('a.id_agenda');
	}
	
	public function getDetailDraft($token)
	{
		$this->db->select('a.id_agenda, a.token,a.jenis_agenda, a.status_verifikasi, a.nama_agenda,a.status_disposisi, a.tanggal,
			a.penerima, a.id_status, a.dokumen, a.jam_mulai, a.jam_selesai, a.kegiatan, a.lokasi_kegiatan, a.penyelenggara, a.cp,
			a.keterangan, a.create_date, a.penyelenggara, a.keterangan_hadir, a.penerima_disposisi, a.cp, b.nm_status');
		$this->db->from('data_agenda a');        
		$this->db->join('master_status b',  'b.id_status = a.id_status', 'LEFT');
		$this->db->where('token', escape($token));
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function setFolder(){

		$dirAgenda   ='images/agenda/'.date('Y').'/'.date('m').'/';
		if (is_dir($dirAgenda)===false) {
			mkdir($dirAgenda, 0777, true);	
		} 

		$dirAgenda1   =site_url('images/agenda/'.date('Y').'/'.date('m').'/');
		if (is_dir($dirAgenda1)===false) {
			mkdir($dirAgenda1, 0777, true);	
		} 

	}

	public function insertDataAgenda()
	{
		$id_user    = $this->app_loader->current_user();
		$create_by    = $this->app_loader->current_account();
		$create_date  = gmdate('Y-m-d H:i:s', time()+60*60*7);
		$create_ip    = $this->input->ip_address();
		$nama_agenda  = escape($this->input->post('nama_agenda', TRUE));
		$token		  = generateToken($nama_agenda.'-'.$create_date, $create_by);
		$id_opd=14;
		$status_disposisi="BD";
		$draft_agenda="";
		$id_status="SM";

		
		$filename = time().'_'.$_FILES['dokumen']['name'];		
	    $without_extension = pathinfo($filename, PATHINFO_FILENAME);
	    $nama_baru    = preg_replace("/[^A-Za-z0-9\_\-]/i", '', $without_extension);

		$config   = array(
			'allowed_types' => 'pdf|jpg|png|doc|docx',
			'upload_path' 	=> realpath('./images/agenda/'.date('Y').'/'.date('m').'/'),
			'file_name' 	=> $nama_baru,
			'max_size' 		=> 5000,
			'max_filename' 	=> 200,
			'max_filename_increment' 	=> 1000,
			'remove_spaces' => TRUE,
			'detect_mime'   => TRUE,
			'mod_mime_fix'  => TRUE,
			'overwrite'  	=> FALSE,
			);                  

		$this->load->library('upload', $config);
		$this->upload->do_upload();

		$file = $this->upload->file_name;

		if($this->upload->do_upload('dokumen'))
		{

			$file1 = $this->upload->data();
			$file2 = $file1['file_name'];
			$gambar = $file2;    
		}
		else
		{
			$gambar="";
		}
		

				$data = array(
					'token'			  => $token,
					'nama_agenda'	  => escape($this->input->post('nama_agenda', TRUE)),				
					'tanggal'		  => escape($this->input->post('tanggal', TRUE)),
					'id_opd'		  => escape($id_opd),
					'penerima'		  => escape($this->input->post('penerima', TRUE)),
					'jenis_agenda'	  => escape('P'),
					'jam_mulai'	      => escape($this->input->post('jam_mulai', TRUE)),				
					'jam_selesai'	  => escape($this->input->post('jam_selesai', TRUE)),
					'kegiatan'		  => escape($this->input->post('kegiatan', TRUE)),
					'lokasi_kegiatan' => escape($this->input->post('lokasi_kegiatan', TRUE)),
					'penyelenggara'   => escape($this->input->post('penyelenggara', TRUE)),
					'penyelenggara'   => escape($this->input->post('penyelenggara', TRUE)),
					'cp'	  	      => escape($this->input->post('cp', TRUE)),				
					'dokumen'		  => $gambar,
					'keterangan'	    => escape($this->input->post('keterangan', TRUE)),	
					'status_verifikasi'	=> escape($id_status),				
					'status_disposisi'=> escape($status_disposisi),				
					'id_status'		  => escape($id_status),	
					'id_status' => escape($this->input->post('id_status', TRUE)),			
					'penerima_disposisi' => escape($this->input->post('penerima_disposisi', TRUE)),			
					'keterangan_hadir' => escape($this->input->post('keterangan_hadir', TRUE)),			
					'create_by'		  => $create_by,
					'create_date'	  => $create_date,
					'create_ip'		  => $create_ip,
					'mod_by'		  => '',
					'mod_date'		  => '',
					'mod_ip'		  => ''

					);
					$this->db->insert('data_agenda', $data);

					/*$penerima = $this->mmas->getUserSekretaris()['token'];

					$nm_pengirim = $this->mmas->getUserFullname($id_user);
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
					$errNotifikasi='';

		return array('message'=>'SUCCESS', 'nama_agenda'=>$nama_agenda, 'notifikasi'=>$errNotifikasi);	
	}



	public function updateDataAgenda()
	{
		$create_by    = $this->app_loader->current_account();
		$create_date  = gmdate('Y-m-d H:i:s', time()+60*60*7);
		$create_ip    = $this->input->ip_address();
		$token		  = escape($this->input->post('tokenId', TRUE));
		$nama_agenda  = escape($this->input->post('nama_agenda', TRUE));
		$id_opd=14;
			//cek data token
		$dataDetail = $this->getDetailDraft($token);
		$id_agenda  = $dataDetail['id_agenda'];
		if(count($dataDetail) <= 0)
			return array('message'=>'ERROR', 'nama_agenda'=>'');
		else 
		{	
			 
			 $file_name          = $_FILES['dokumen']['name'];
	         if ($file_name=='')
	         {
		        	$data = array(
					'token'			  => $token,
					'nama_agenda'	  => escape($this->input->post('nama_agenda', TRUE)),				
					'tanggal'		  => escape($this->input->post('tanggal', TRUE)),
					'id_opd'		  => escape($id_opd),
					'penerima'		  => escape($this->input->post('penerima', TRUE)),
					'jenis_agenda'	  => escape('P'),	
					'jam_mulai'	      => escape($this->input->post('jam_mulai', TRUE)),				
					'jam_selesai'	  => escape($this->input->post('jam_selesai', TRUE)),
					'kegiatan'		  => escape($this->input->post('kegiatan', TRUE)),
					'lokasi_kegiatan' => escape($this->input->post('lokasi_kegiatan', TRUE)),
					'keterangan'	  => escape($this->input->post('keterangan', TRUE)),	
					'id_status' => escape($this->input->post('id_status', TRUE)),			
					'penerima_disposisi' => escape($this->input->post('penerima_disposisi', TRUE)),			
					'keterangan_hadir' => escape($this->input->post('keterangan_hadir', TRUE)),													
					'create_by'		  => $create_by,
					'create_date'	  => $create_date,
					'create_ip'		  => $create_ip,
					'mod_by'		  => '',
					'mod_date'		  => '',
					'mod_ip'		  => ''
					);
	         }
	         else
	         {

	         	//$nama_file 	  = time().'-'.$_FILES["dokumen"]['name'];
				//$filenameOnly = preg_replace('/(.*)\\.[^\\.]*/', '$1', $nama_file);
				//$nama_baru    = preg_replace("/[^A-Za-z0-9\_\-]/", '', $filenameOnly);
				$filename = time().'_'.$_FILES['dokumen']['name'];		
			    $without_extension = pathinfo($filename, PATHINFO_FILENAME);
			    $nama_baru    = preg_replace("/[^A-Za-z0-9\_\-]/i", '', $without_extension);

				$config   = array(
					'allowed_types' => 'pdf|jpg|png|doc|docx',
					'upload_path' 	=> realpath('./images/agenda/'.date('Y').'/'.date('m').'/'),
					'file_name' 	=> $nama_baru,
					'max_size' 		=> 5000,
					'max_filename' 	=> 200,
					'max_filename_increment'=> 1000,
					'remove_spaces' => TRUE,
					'detect_mime'   => TRUE,
					'mod_mime_fix'  => TRUE,
					'overwrite'  	=> FALSE,
					);     

		        $this->load->library('upload', $config);
		        $this->upload->do_upload();

		        if($this->upload->do_upload('dokumen'))
		        {	     	
		        	$year  = substr($dataDetail['create_date'],0,4);
    		 		$month = substr($dataDetail['create_date'],5,2); 
    		 		$foto  = $dataDetail['dokumen'];

		            if ($foto != "" || $foto != NULL)
		            {
		                $path = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']);
		                $direktori    = $path.'images/agenda/'.$year.'/'.$month.'/';
		                if(file_exists($direktori.'/'.$foto))
		                unlink($direktori.'/'.$foto);                
		            }

		            $file1 = $this->upload->data();
		            $file2 = $file1['file_name'];
		            $update_gambar = $file2;
		        }
		        else
		        {
		        	$update_gambar='';
		        }

	         		$data = array(
					'token'			  => $token,
					'nama_agenda'	  => escape($this->input->post('nama_agenda', TRUE)),				
					'tanggal'		  => escape($this->input->post('tanggal', TRUE)),
					'id_opd'		  => escape($id_opd),
					'penerima'		  => escape($this->input->post('penerima', TRUE)),
					'jenis_agenda'	  => escape('P'),	
					'jam_mulai'	      => escape($this->input->post('jam_mulai', TRUE)),				
					'jam_selesai'	  => escape($this->input->post('jam_selesai', TRUE)),
					'kegiatan'		  => escape($this->input->post('kegiatan', TRUE)),
					'lokasi_kegiatan' => escape($this->input->post('lokasi_kegiatan', TRUE)),
					'keterangan'	  => escape($this->input->post('keterangan', TRUE)),													
					'dokumen'	  	  => escape($update_gambar),	
					'id_status' => escape($this->input->post('id_status', TRUE)),			
					'penerima_disposisi' => escape($this->input->post('penerima_disposisi', TRUE)),			
					'keterangan_hadir' => escape($this->input->post('keterangan_hadir', TRUE)),													
					'create_by'		  => $create_by,
					'create_date'	  => $create_date,
					'create_ip'		  => $create_ip,
					'mod_by'		  => '',
					'mod_date'		  => '',
					'mod_ip'		  => ''
					);
	         }
			$this->db->where('token', $token);
			$this->db->update('data_agenda', $data);

			return array('message'=>'SUCCESS', 'nama_agenda'=>$nama_agenda);			
		}
	}

	public function validasiDataReview()
	{
		$this->form_validation->set_rules('nama_agenda',   'Nama Agenda',  'trim|required|min_length[3]');
		
		validation_message_setting();
		if ($this->form_validation->run() == FALSE)
			return false;
		else
			return true;
	}

	public function approveDataAgenda()
	{
		$create_by   = $this->app_loader->current_account();
		$create_date = gmdate('Y-m-d H:i:s', time()+60*60*7);
		$create_ip   = $this->input->ip_address();
		$token		 = escape($this->input->post('tokenId', TRUE));
		$nama_agenda = escape($this->input->post('nama_agenda', TRUE));
		$keterangan  = escape($this->input->post('keterangan', TRUE));
		$status_verifikasi='CC';
		$id_user    = $this->app_loader->current_user();

			//cek data rs by toked
		$dataDetail = $this->getDetailDraft($token);
		if(count($dataDetail) <= 0)
			return array('message'=>'ERROR', 'nama_agenda'=>'');
		else {		

			$penerima = $dataDetail['penerima'];
			$nm_pengirim = $this->mmas->getUserFullname($id_user);
			$token_disposisi='';
			$tipe_notifikasi='SR';
			$pesan_notifikasi='Ada draft yang harus diverifikasi';
		
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

			$data = array(					
				'status_verifikasi'	=> escape($status_verifikasi),					
				'pesan_verifikasi'	=> $keterangan					
				);
			$this->db->where('token', $token);
			$this->db->update('data_agenda', $data);
			return array('message'=>'SUCCESS', 'nama_agenda'=>$nama_agenda, 'notifikasi', $errNotifikasi);			
		}
	}

	public function rejectDataAgenda()
	{
		$create_by   = $this->app_loader->current_account();
		$create_date = gmdate('Y-m-d H:i:s', time()+60*60*7);
		$create_ip   = $this->input->ip_address();
		$token		 = escape($this->input->post('tokenId', TRUE));
		$nama_agenda = escape($this->input->post('nama_agenda', TRUE));
		$keterangan  = escape($this->input->post('keterangan', TRUE));
		$status_verifikasi='LK';

			//cek data rs by toked
		$dataDetail = $this->getDetailDraft($token);
		if(count($dataDetail) <= 0)
			return array('message'=>'ERROR', 'nama_agenda'=>'');
		else {			
			$data = array(					
				'status_verifikasi'	=> escape($status_verifikasi),					
				'pesan_verifikasi'	=> $keterangan					
				);
			$this->db->where('token', $token);
			$this->db->update('data_agenda', $data);
			return array('message'=>'SUCCESS', 'nama_agenda'=>$nama_agenda);			
		}
	}

	public function getStatusAgenda($id_status)
	{
		$this->db->select('nm_status');
		$this->db->from('master_status');
		$this->db->where('id_status', $id_status);
		$query = $this->db->get();

		return $query->row_array()['nm_status'];
	}

	public function getDataPenerima($jenis_agenda)
	{	

		$this->db->select('id_users, token, fullname');		
		if ($jenis_agenda =='P') {
			$this->db->where('jab_dprd', 7);
		}
		if ($jenis_agenda =='S') {
			$this->db->where('jabatan_id', 191);
			$this->db->where('account_type', 1);
		}
		$this->db->where('id_status', 1);
		$this->db->from('xi_sa_users');
		$this->db->limit(1);
		$query = $this->db->get();

		return $query->row_array();
	}

	public function getDataPenerimaDisposisi($jenis_agenda)
	{	

		$this->db->select('id_users, token, fullname');		
		if ($jenis_agenda =='P') {
	    		$this->db->where('id_users >', 90);
		}
		
		$this->db->from('xi_sa_users');    	
		$query = $this->db->get();

		return $query->result_array();
	}

	public function validasiDataAgendaPimpinan()
	{	
		$id_status = $this->input->post('id_status');
		if ($id_status=='SW') {
			$this->form_validation->set_rules('penerima_disposisi',   'Penerima',  'trim|required');	
			$this->form_validation->set_rules('keterangan',  		 'Isi Disposisi',  'trim|required');	
		}
		$this->form_validation->set_rules('id_status',   'Status Agenda',  'trim|required');
		
		validation_message_setting();
		if ($this->form_validation->run() == FALSE)
			return false;
		else
			return true;
	}

	public function insertDataReview()
	{
		$id_user    = $this->app_loader->current_user();
		$create_by    = $this->app_loader->current_account();
		$userid       = $this->app_loader->current_user();
		$userpenerima = $this->input->post('penerima_disposisi', TRUE);
		$create_date  = gmdate('Y-m-d H:i:s', time()+60*60*7);
		$create_ip    = $this->input->ip_address();

		$id_status  = escape($this->input->post('id_status'));
		$token  	= escape($this->input->post('token'));
		$detail 	= $this->getDetailDraft($token);
		$id_agenda  = $detail['id_agenda'];
		$url 		= create_url($detail['nama_agenda']);		
		$status_disposisi="BD";
		$draft_agenda="";


		$opd_pengirim = $this->mmas->getIdOpdByUserid($userid);
		$opd_penerima = $this->mmas->getIdOpdByUserid($userpenerima);

		$id_opd_pengirim = $opd_pengirim['id_opd'];
		$id_opd_penerima = $opd_penerima['id_opd'];

		$data = array(			
			'id_status'	  => escape($id_status),				
			'keterangan_hadir'	  => escape($this->input->post('keterangan')),				
			'mod_by'		  => $create_by,
			'mod_date'	  => $create_date,
			'mod_ip'		  => $create_ip
			);
		$this->db->where('token', $token);
		$this->db->update('data_agenda', $data);						

		$errNotifikasi='';

		if ($id_status=='SW') 
		{					

			$tokenDisposisi= generateToken($url.'-'.$create_date, $create_by);
			$dataDisposisi = array(
				'token'			  => $tokenDisposisi,
				'id_agenda'	      => escape($id_agenda),				
				'tgl_disposisi'	  => escape($create_date),
				'isi_disposisi'	  => escape($this->input->post('keterangan', TRUE)),				
				'id_pengirim'	  => escape($userid),				
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

			$disposisiMasuk = array(

				'token'	  		  => escape($tokenDisposisi),				
				'id_disposisi'	  => escape($id_disposisi),				
				'id_penerima'	  => escape($this->input->post('penerima_disposisi', TRUE)),
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

			$penerima = escape($this->input->post('penerima_disposisi', TRUE));
			$nm_pengirim = $this->mmas->getUserFullname($id_user);
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

		}
		return array('message'=>'SUCCESS');		
	}

	public function deleteDataDraft()
	{
		$token = escape($this->input->post('tokenId', TRUE));
		
		$detail = $this->getDetailDraft($token);
		$nama_agenda   = !empty($detail) ? $detail['nama_agenda'] : '';

		$stats=array('SH', 'SW', 'CC');
		$verifikasi='SM';


		$arrExc=array('SH', 'SW');

		if(count($detail) <= 0){
			return array('message'=>'ERROR', 'nama_agenda'=>$nama_agenda);
		}
		elseif (in_array($detail['id_status'], $arrExc)) 
		{
			return array('message'=>'FAIL', 'nama_agenda'=>$nama_agenda);		
		}
		else {

			$tahun  = substr($detail['create_date'],0,4);
	 		$bulan = substr($detail['create_date'],5,2); 
	 		$dokumen  = $detail['dokumen'];

            if ( ($dokumen !="") && file_exists('images/agenda/'.$tahun.'/'.$bulan.'/'.$dokumen) )
            {
                $path = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']);
                $direktori    = $path.'images/agenda/'.$tahun.'/'.$bulan.'/';
                if(file_exists($direktori.'/'.$dokumen))
                unlink($direktori.'/'.$dokumen);                
            }

			$this->db->where('token', $token);
			$this->db->delete('data_agenda');
			return array('message'=>'SUCCESS', 'nama_agenda'=>$nama_agenda);
		}
	}

	public function validasiDataAgendaSekretaris()
	{	
		$id_status = $this->input->post('id_status');
		if ($id_status=='SW') {
			$this->form_validation->set_rules('penerima_disposisi[]',   'Penerima',  'trim|required');	
			$this->form_validation->set_rules('keterangan',  		    'Isi Disposisi',  'trim|required');	
		}
		$this->form_validation->set_rules('id_status',   'Status Agenda',  'trim|required');
		
		validation_message_setting();
		if ($this->form_validation->run() == FALSE)
			return false;
		else
			return true;
	}

	public function insertDataAcc()
	{
		$create_by    = $this->app_loader->current_account();
		$userid       = $this->app_loader->current_user();
		$userpenerima = $this->input->post('penerima_disposisi', TRUE);
		$create_date  = gmdate('Y-m-d H:i:s', time()+60*60*7);
		$create_ip    = $this->input->ip_address();

		$id_status  = escape($this->input->post('id_status'));
		$token  	= escape($this->input->post('token'));
		$detail 	= $this->getDetailDraft($token);
		$id_agenda  = $detail['id_agenda'];
		$url 		= create_url($detail['nama_agenda']);		
		$status_disposisi="BD";
		$draft_agenda="";
		$status_verifikasi="CC";

		$opd_pengirim = $this->mmas->getIdOpdByUserid($userid);
		$id_opd_pengirim = $opd_pengirim['id_opd'];
		
		$data = array(			
			'status_verifikasi'	  => escape($status_verifikasi),				
			'id_status'	  => escape($id_status),				
			'keterangan_hadir'	  => escape($this->input->post('keterangan')),				
			'mod_by'		  => $create_by,
			'mod_date'	  => $create_date,
			'mod_ip'		  => $create_ip
			);
		$this->db->where('token', $token);
		$this->db->update('data_agenda', $data);						

		if ($id_status=='SW') 
		{					

			$tokenDisposisi= generateToken($url.'-'.$create_date, $create_by);
			$dataDisposisi = array(
				'token'			  => $tokenDisposisi,
				'id_agenda'	      => escape($id_agenda),				
				'tgl_disposisi'	  => escape($create_date),
				'isi_disposisi'	  => escape($this->input->post('keterangan', TRUE)),				
				'id_pengirim'	  => escape($userid),				
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

			$errNotifikasi='';
			$totpenerima=count($userpenerima);
			for ($i=0; $i < $totpenerima; $i++)
			{ 				
				$opd_penerima = $this->mmas->getIdOpdByUserid($userpenerima[$i]);
				$id_opd_penerima = $opd_penerima['id_opd'];

				$tokenDisposisiMasuk= generateToken($url.'-'.$create_date, $userpenerima[$i]);

				$disposisiMasuk = array(

					'token'	  		  => escape($tokenDisposisiMasuk),		
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

				$nm_pengirim = $this->mmas->getUserFullname($userid);
				$token_disposisi=$tokenDisposisi;
				$tipe_notifikasi='DM';
				$pesan_notifikasi='Ada disposisi masuk';
			
				$regId = $this->mmas->getDeviceIdUser($userpenerima);			
				
				$id_status='0';
        		$token_notifikasi = generateToken($token_agenda, $create_date);

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
		return array('message'=>'SUCCESS');		
	}

}

// This is the end of draft model
