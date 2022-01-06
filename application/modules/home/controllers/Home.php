<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of home class
 *
 * @author Yogi "solop" Kaputra
 */

class Home extends SLP_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('model_home' => 'mhome'));
	}

	public function index()
	{
		$this->breadcrumb->add('Dashboard', site_url('home'));
		$this->session_info['page_name'] = "Home";
		if (!$this->app_loader->is_admin()) 
		{
			if ($this->app_loader->is_pimpinan() || $this->app_loader->is_sekretaris() || $this->app_loader->is_ajudan()) 
				$this->template->build('home_pimpinan', $this->session_info);
			else
				$this->template->build('home_umum', $this->session_info);
		}else{
				$this->template->build('home_pimpinan', $this->session_info);
		}		
	}

	/*public function listview()
	{
		$tgl = escape($this->input->post('tgl'));
		if ($tgl=='') {
			$tgl_agenda = date('Y-m-d');
		}
		else{
			$tgl_agenda = $tgl;
		}
		$data = $this->mhome->getAgendaKetuaDprd($tgl);
		$data =  array('agenda' => 'asdasddsa', 'asd','jhsdahsadkh');
		return $data;
	}*/

	public function listview(){
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$csrfHash = $this->security->get_csrf_hash();
			$session = $this->app_loader->current_account();
			if(isset($session)){				
				$tgl   = escape($this->input->post('tgl', TRUE));
				$dataAgendaPimpinan = $this->mhome->getDataListAgendaPimpinan($tgl);
				$dataAgendaSekretaris = $this->mhome->getDataListAgendaSekretaris($tgl);

				$result = array(
					'agendaPimpinan'   => (count($dataAgendaPimpinan) > 0) ? $dataAgendaPimpinan : array(),					
					'agendaSekretaris' => (count($dataAgendaSekretaris) > 0) ? $dataAgendaSekretaris : array(),					
					'csrfHash' => $csrfHash,
					'tgl' => tgl_indo($tgl)
					);
				//output to json format
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
			}
		}
	}

	public function listdisposisi(){
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$csrfHash = $this->security->get_csrf_hash();
			$session = $this->app_loader->current_account();
			if(isset($session)){				
				$tgl   = escape($this->input->post('tgl', TRUE));
				$dataDispomasuk = $this->mhome->getDataDispomasuk($tgl);
				$result = array(
					'dataDispomasuk'   => (count($dataDispomasuk) > 0) ? $dataDispomasuk : array(),						
					'csrfHash' => $csrfHash,
					'tgl' => tgl_indo($tgl)
					);
				//output to json format
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
			}
		}
	}

	
	public function details()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			$token  	= $this->input->post('token', TRUE);

			if(!empty($token) AND !empty($session)) 
			{
				$data = $this->mdraft->getDetailDraft($token);
				$row = array();
				$row['token'] 		= !empty($data) ? $data['token'] : '';
				$row['nama_agenda']	= !empty($data) ? $data['nama_agenda'] : '';
				$row['jenis_agenda']= !empty($data) ? $data['jenis_agenda'] : '';
				$row['tanggal']		= !empty($data) ? $data['tanggal'] : '';
				$row['penerima']	= !empty($data) ? $data['penerima'] : '';
				$row['jam_mulai']	= !empty($data) ? $data['jam_mulai'] : '';
				$row['jam_selesai']	= !empty($data) ? $data['jam_selesai'] : '';
				$row['kegiatan']		= !empty($data) ? $data['kegiatan'] : '';
				$row['lokasi_kegiatan']	= !empty($data) ? $data['lokasi_kegiatan'] : '';
				$row['keterangan']		= !empty($data) ? $data['keterangan'] : '';
				$row['dokumen'] 		= !empty($data) ? $data['dokumen'] : '';	
				
				$tahun = substr($data['create_date'],0,4);
				$bulan = substr($data['create_date'],5,2); 

				$fileUpload ='<a href="'.site_url('dokumen/draft/download_file/'.$token).'">
				'.$row['dokumen'].'
			</a>
			<span class="help-block"><i>* File Yang Telah Diupload </i></span>';		
			$result = array('status' => 1, 'message' => $row, 'csrfHash' => $csrfHash, 'file_upload'=>$fileUpload);
		} else {
			$result = array('status' => 0, 'message' => array(), 'csrfHash' => $csrfHash, 'file_upload'=>'');
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}
}

// This is the end of home clas
