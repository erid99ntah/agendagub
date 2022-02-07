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


	public function getDetailDraft($token)
	{
		$this->db->select('a.id_agenda, a.token,a.jenis_agenda, a.nama_agenda,a.status_disposisi, a.tanggal,
						   a.penerima,a.id_status, a.id_opd, a.status_verifikasi, a.jam_mulai, a.jam_selesai, 
						   a.kegiatan, a.lokasi_kegiatan, a.dokumen, a.keterangan, a.create_date,
						   a.penyelenggara, a.cp,a.penerima_disposisi, a.keterangan_hadir, a.create_by, b.nm_status');
        $this->db->from('data_agenda a');
        $this->db->join('master_status b',      'b.id_status 	= a.id_status', 'INNER');
       // $this->db->where('a.status_verifikasi', 'SM');
        $this->db->where('a.token', $token);
        $this->db->limit(1);
        $data = $this->db->get();
        return $data->row_array();
	}


    public function validasiDraft($role)
	{
		$this->form_validation->set_rules('nama_agenda',    'Nama Agenda',  'trim|required|min_length[3]');
		if ($role=='add') {
			$this->form_validation->set_rules('jenis_agenda',   'Jenis Agenda', 'required|trim');
			$this->form_validation->set_rules('penerima', 		'Penerima', 	'required|trim');
		}
		
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
		set_time_limit(0);
		ini_set('memory_limit', '-1');

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
					'penyelenggara'   => escape($this->input->post('penyelenggara', TRUE)),
					'cp' 			  => escape($this->input->post('cp', TRUE)),
					'keterangan'	  => escape($this->input->post('keterangan', TRUE)),				
					'dokumen'		  => '',	
					'status_verifikasi'=> escape('CC'),				
					'status_disposisi'=> escape($status_disposisi),				
					'id_status'		  => escape($this->input->post('id_status', TRUE)),				
					'penerima_disposisi'=> escape($this->input->post('penerima_disposisi', TRUE)),				
					'keterangan_hadir'	=> escape($this->input->post('keterangan_hadir', TRUE)),				
					'create_by'		  => $create_by,
					'create_date'	  => $create_date,
					'create_ip'		  => $create_ip,
					'mod_by'		  => '',
					'mod_date'		  => '',
					'mod_ip'		  => ''

					);
					$this->db->insert('data_agenda', $data);	

		

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

    public function updateDataDraft()
	{
		set_time_limit(0);
		ini_set('memory_limit', '-1');

		$create_by    = escape($this->input->post('create_by', TRUE));
		$create_date  = gmdate('Y-m-d H:i:s', time()+60*60*7);
		$create_ip    = $this->input->ip_address();
		$token  = escape($this->input->post('token', TRUE));
		$id_opd       =1;
		$status_disposisi="BD";
		$draft_agenda="";
		$id_status="SM";

		$detail = $this->getDetailDraft($token);

		$base64 = $this->input->post('dokumen', TRUE);
       	$tahun  = substr($detail['create_date'],0,4);
	 	$bulan = substr($detail['create_date'],5,2); 

       		$data = array(					
					'nama_agenda'	  => escape($this->input->post('nama_agenda', TRUE)),				
					'tanggal'		  => escape($this->input->post('tanggal', TRUE)),
					'id_opd'		  => escape($id_opd),
					//'penerima'		  => escape($this->input->post('penerima', TRUE)),
					//'jenis_agenda'	  => escape($this->input->post('jenis_agenda', TRUE)),
					'jam_mulai'	      => escape($this->input->post('jam_mulai', TRUE)),				
					'jam_selesai'	  => escape($this->input->post('jam_selesai', TRUE)),
					'kegiatan'		  => escape($this->input->post('kegiatan', TRUE)),
					'lokasi_kegiatan' => escape($this->input->post('lokasi_kegiatan', TRUE)),
					'penyelenggara'   => escape($this->input->post('penyelenggara', TRUE)),
					'cp' 			  => escape($this->input->post('cp', TRUE)),
					'keterangan'	  => escape($this->input->post('keterangan', TRUE)),	
					//'status_verifikasi'=> escape('CC'),				
					//'status_disposisi'=> escape($status_disposisi),				
					'id_status'		  => escape($this->input->post('id_status', TRUE)),				
					'penerima_disposisi'=> escape($this->input->post('penerima_disposisi', TRUE)),				
					'keterangan_hadir'	=> escape($this->input->post('keterangan_hadir', TRUE)),	
					'mod_by'		  => $create_by,
					'mod_date'		  => $create_date,
					'mod_ip'		  => $create_ip

					);
					$this->db->where('token', $token);	
					$this->db->update('data_agenda', $data);	

		

	 	if ($base64 !='' || $base64 !=NULL  ) 
	 	{
	 		$detailDraft = $this->getDetailDraft($token);
	 		if (count($detailDraft >=0)) 
	 		{
	 			$foto = $detailDraft['dokumen'];
	 			if ($foto!='' || $foto !=NULL) 
	 			{
		 			$upload_path = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']).'../images/agenda/'.$tahun.'/'.$bulan.'/';	
		 			if(file_exists($upload_path.'/'.$foto)){
			            unlink($upload_path.'/'.$foto);   
		 			}
		 		}
	 		}
	 		$this->uploadBase64($token, $base64, $tahun, $bulan);
	 	}	

		return array('message'=>'SUCCESS', 'token'=>$token);
	}


	public function deleteDataDraft($token)
	{
		$detail = $this->getDetailDraft($token);
		$hadir = $this->getDataDraftDihadiri($token);

		if(count($hadir)>=1) 
		{
			return array('status'=>FALSE, 'message'=>'Draft tidak bisa dihapus karena sudah menjadi agenda yang dihadiri/diwakilkan');	
		}
		else
		{
			$tahun  = substr($detail['create_date'],0,4);
	 		$bulan = substr($detail['create_date'],5,2); 
	 		$foto = $detail['dokumen'];

	 		if ($foto!='' || $foto !=NULL) 
	 		{
	 			$upload_path = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']).'../images/agenda/'.$tahun.'/'.$bulan.'/';	
	 			if(file_exists($upload_path.'/'.$foto)){
		            unlink($upload_path.'/'.$foto);   
	 			}
	 		}	
 			

 			$this->db->where('token', $token);	
			$this->db->delete('data_agenda');	
			return array('status'=>TRUE, 'message'=>'Draft berhasil dihapus');	
		}
	}

	private function getDataDraftDihadiri($token)
	{
		$stat = array('SH', 'SW');
		$this->db->select('id_agenda');
		$this->db->from('data_agenda');
		$this->db->where('token', $token);
		$this->db->where_in('id_status', $stat);
		$this->db->limit(1);
		$data = $this->db->get();
		return $data->row_array();

	}

	public function getDataStatus()
	{
		$this->db->select('*');
		$this->db->from('master_status');
		$data = $this->db->get();
		return $data->result_array();
	}
}

// This is the end of agenda model
