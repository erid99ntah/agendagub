<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Draft 
 *
 * @author Diskominfo Sumbar
 */

class Draftnew extends SLP_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('model_draftnew' => 'mdraft', 'model_master' => 'mmas'));
		$this->mdraft->setFolder();
	}

	public function index()
	{
		$this->breadcrumb->add('Dashboard', site_url('home'));
		$this->breadcrumb->add('Dokumen', '#');
		$this->breadcrumb->add('Data Draft Agenda', '#');
		
		$this->session_info['page_name'] = "Data Draft Agenda";
		$this->session_info['data_penerima'] = $this->mdraft->getDataPenerimaNew();
		$this->session_info['status_agenda'] = $this->mdraft->getDaftarStatusAgenda();
		$this->template->build('form_draftnew/list_draft', $this->session_info);
	}

	public function listview()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$data = array();
			$session = $this->app_loader->current_account();
			if(isset($session)){
				$param = $this->input->post('param',TRUE);
				$dataList = $this->mdraft->get_datatables($param);
				$no = $this->input->post('start');
				foreach ($dataList as $key => $dl) 
				{
					
					if($this->app_loader->is_sekretaris() || $this->app_loader->is_admin())
			           $btn='';
			        else
			        	$btn='disabled';

					if ($dl['jenis_agenda']=='P' ){
					 	$ver='<button type="button" '.$btn.' class="btn btn-xs btn-success btnReview" data-id="'.$dl['token'].'" data-nm="'.$dl['nama_agenda'].'" title="Validasi Agenda"><i class="fa fa-check-square-o"></i> Acc</button>
						      <button type="button" '.$btn.' class="btn btn-xs btn-danger btnReject" data-id="'.$dl['token'].'" data-nm="'.$dl['nama_agenda'].'"title="Tolak Agenda"><i class="fa fa-times"></i> Tolak </button>';	
					}					
					
					$cekStatusAgenda = $this->mdraft->getStatusAgenda($dl['id_status']);
					if ($dl['id_status']=='SM')
						$status_agenda='<label class="label label-warning">'.$cekStatusAgenda.'</label>';
					elseif($dl['id_status']=='SH')
						$status_agenda='<label class="label label-success">'.$cekStatusAgenda.'</label>';
					else
						$status_agenda='<label class="label label-danger">'.$cekStatusAgenda.'</label>';

					$no++;
					$row = array();
					$row[] = $no;
					$row[] = '<a data-toggle="tooltip" data-placement="left" title="Detail Draft Agenda" href="'.site_url('dokumen/draftnew/review/'.$dl['token']).'/'.create_url($dl['nama_agenda']).'" 
							  class="tooltips"><i class="fa fa-edit"></i> '.$dl['nama_agenda'].'</a>';
					$row[] = convert_agenda($dl['jenis_agenda']);
					$row[] = tgl_indo($dl['tanggal']);
					$row[] = ' '.$dl['jam_mulai'].' s.d '.$dl['jam_selesai'].' ';
					$row[] = $dl['kegiatan'];
					$row[] = $dl['lokasi_kegiatan'];
					$row[] = $dl['penyelenggara'];
					$row[] = $status_agenda;
					$row[] = $this->mmas->getUserProfileByUsername($dl['create_by'])['fullname'];
					
					//$row[] = $status;
					$row[] = '
				<a data-toggle="tooltip" data-placement="left" title="Detail Draft Agenda" href="'.site_url('dokumen/draftnew/review/'.$dl['token']).'/'.create_url($dl['nama_agenda']).'" 
							  class="tooltips btn btn-xs btn-primary"><i class="fa fa-check"></i> Review</a>
					<button type="button" class="btn btn-xs btn-orange btnEdit" data-id="'.$dl['token'].'" title="Edit Agenda"><i class="fa fa-pencil"></i> </button>
					<button type="button" class="btn btn-xs btn-danger btnDelete" data-id="'.$dl['token'].'" title="Delete Agenda"><i class="fa fa-trash-o"></i> </button>';
					$data[] = $row;
				}

				$output = array(
					"draw" => $this->input->post('draw'),
					"recordsTotal" => $this->mdraft->count_all(),
					"recordsFiltered" => $this->mdraft->count_filtered($param),
					"data" => $data,
					);
			}
			//output to json format
			$this->output->set_content_type('application/json')->set_output(json_encode($output));
		}
	}

	public function create()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			if(!empty($session)) {
				if($this->mdraft->validasiDataValue() == FALSE) {
					$result = array('status' => 0, 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
				} else {
					$data = $this->mdraft->insertDataAgenda();
					if($data['message'] == 'ERROR') {
						$result = array('status' => 0, 'message' => array('isi' => 'Proses input data <b>'.$data['nama_agenda'].' gagal,'), 'csrfHash' => $csrfHash);
					} else if($data['message'] == 'SUCCESS') {
						$result = array('status' => 1, 'message' => 'Data <b>'.$data['nama_agenda'].' berhasil ditambahkan.</b>', 'csrfHash' => $csrfHash);
					}
				}
			} else {
				$result = array('status' => 0, 'message' => array('isi' => 'Proses input Data Draft Agenda gagal, mohon periksa data kembali...'), 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}


	public function review()
	{
		$this->breadcrumb->add('Dashboard', site_url('home'));
		$this->breadcrumb->add('Dokumen', '#');
		$this->breadcrumb->add('Data Draft Agenda', site_url('dokumen/draftnew'));
		$this->breadcrumb->add('Detail Draft Agenda', '#');
		$this->session_info['page_name'] = "Detail Draft Agenda";

		$token = $this->uri->segment(4,0);
		$detail_agenda = $this->mdraft->getDetailDraft($token);				
		$this->session_info['detail']  = $this->mdraft->getDetailDraft($token);
		$this->template->build('form_draftnew/detail_draft', $this->session_info);		
	}


	public function validasi()
	{
		$token  = escape($this->input->post('token'));
		$detail = $this->mdraft->getDetailDraft($token);
		$url = create_url($detail['nama_agenda']);
		 
		if($this->mdraft->validasiDataAgendaPimpinan("add") == FALSE) 
		{
			error_message('danger', 'Peringatan!', 'Tolong dilengkapi form inputan dibawah...'.validation_errors().' ');
     		 redirect('dokumen/draftnew/review/'.$token.'/'.$url);
    	} else {
			$data = $this->mdraft->insertDataReview();
			if($data) {
				error_message('success', 'Sukses!', 'Data berhasil disimpan.');
				redirect('dokumen/draftnew');
			}
		}
	}

	public function acc()
	{
		$token  = escape($this->input->post('token'));
		$detail = $this->mdraft->getDetailDraft($token);
		$url = create_url($detail['nama_agenda']);
		 
		if($this->mdraft->validasiDataAgendaSekretaris("add") == FALSE) 
		{
			error_message('danger', 'Peringatan!', 'Tolong dilengkapi form inputan dibawah...'.validation_errors().' ');
     		 redirect('dokumen/draftnew/review/'.$token.'/'.$url);
    	} else {
			$data = $this->mdraft->insertDataAcc();
			if($data) {
				error_message('success', 'Sukses!', 'Data berhasil disimpan.');
				redirect('dokumen/draftnew');
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
			if(!empty($token) AND !empty($session)) {
				$data = $this->mdraft->getDetailDraft($token);
				$row = array();
				$row['token'] 			= !empty($data) ? $data['token'] : '';
				$row['nama_agenda']		= !empty($data) ? $data['nama_agenda'] : '';
				$row['jenis_agenda']	= !empty($data) ? $data['jenis_agenda'] : '';
				$row['tanggal']			= !empty($data) ? $data['tanggal'] : '';
				$row['penerima']		= !empty($data) ? $data['penerima'] : '';
				$row['jam_mulai']		= !empty($data) ? $data['jam_mulai'] : '';
				$row['jam_selesai']		= !empty($data) ? $data['jam_selesai'] : '';
				$row['kegiatan']		= !empty($data) ? $data['kegiatan'] : '';
				$row['lokasi_kegiatan']	= !empty($data) ? $data['lokasi_kegiatan'] : '';
				$row['penyelenggara']	= !empty($data) ? $data['penyelenggara'] : '';
				$row['penerima_disposisi']	= !empty($data) ? $data['penerima_disposisi'] : '';
				$row['keterangan_hadir']	= !empty($data) ? $data['keterangan_hadir'] : '';
				$row['id_status']			= !empty($data) ? $data['id_status'] : '';
				$row['cp']					= !empty($data) ? $data['cp'] : '';
				$row['keterangan']			= !empty($data) ? $data['keterangan'] : '';
				$row['dokumen'] 			= !empty($data) ? $data['dokumen'] : '';	
				
				$tahun = substr($data['create_date'],0,4);
          		$bulan = substr($data['create_date'],5,2); 

				$fileUpload ='<a href="'.site_url('dokumen/draftnew/download_file/'.$token).'">
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

	public function update()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			$token 		= escape($this->input->post('tokenId', TRUE));
			if(!empty($session) AND !empty($token)) {
				if($this->mdraft->validasiDataValue() == FALSE) {
					$result = array('status' => 0, 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
				} else {
					$data = $this->mdraft->updateDataAgenda();
					if($data['message'] == 'NODATA') {
						$result = array('status' => 0, 'message' => array('isi' => 'Proses update data gagal, data yang akan diupdate tidak ditemukan. Mohon diperiksa kembali data yang akan diupdate...'), 'csrfHash' => $csrfHash);
					}	else if($data['message'] == 'ERROR') {
						$result = array('status' => 0, 'message' => array('isi' => 'Proses update data <b>'.$data['nama_agenda'].'</b> gagal'), 'csrfHash' => $csrfHash);
					} else if($data['message'] == 'SUCCESS') {
						$result = array('status' => 1, 'message' => 'Data fasilitas layanan kesehatan <b>'.$data['nama_agenda'].'</b> berhasil diperbaharui...', 'csrfHash' => $csrfHash);
					}
				}
			} else {
				$result = array('status' => 0, 'message' => array('isi' => 'Proses update data gagal, mohon periksa data kembali...'), 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	public function delete()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} 
		else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			$token 		= escape($this->input->post('tokenId', TRUE));
			if(!empty($session) AND !empty($token)) {
				$data = $this->mdraft->deleteDataDraft();
				
				if($data['message'] == 'FAIL') {
					$result = array('status' => 0, 'message' => 'Data agenda gagal di hapus karena data sudah di verifikasi/agenda sudah dihadiri/diwalkilkan...', 'csrfHash' => $csrfHash);
				}elseif($data['message'] == 'ERROR') {
					$result = array('status' => 0, 'message' => 'Proses delete data agenda gagal dikarenakan data tidak ditemukan...', 'csrfHash' => $csrfHash);
				}	else if($data['message'] == 'SUCCESS') {
					$result = array('status' => 1, 'message' => 'Data  <b>'.$data['nama_agenda'].'</b> telah didelete...', 'csrfHash' => $csrfHash);
				}
			} else {
				$result = array('status' => 0, 'message' => 'Proses delete data agenda gagal...', 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	public function approve()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			$token 		= escape($this->input->post('tokenId', TRUE));
			if(!empty($session) AND !empty($token)) {
				if($this->mdraft->validasiDataReview() == FALSE) {
					$result = array('status' => 0, 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
				} else {
					$data = $this->mdraft->approveDataAgenda();
					if($data['message'] == 'NODATA') {
						$result = array('status' => 0, 'message' => array('isi' => 'Proses validasi data gagal, data yang akan divalidasi tidak ditemukan. Mohon diperiksa kembali data yang akan diupdate...'), 'csrfHash' => $csrfHash);
					}	else if($data['message'] == 'ERROR') {
						$result = array('status' => 0, 'message' => array('isi' => 'Proses validasi data <b>'.$data['nama_agenda'].' gagal'), 'csrfHash' => $csrfHash);
					} else if($data['message'] == 'SUCCESS') {
						$result = array('status' => 1, 'message' => 'Data <b>'.$data['nama_agenda'].' </b> berhasil divalidasi...', 'csrfHash' => $csrfHash);
					}
				}
			} else {
				$result = array('status' => 0, 'message' => array('isi' => 'Proses validasi gagal, mohon periksa data kembali...'), 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	public function reject()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} else {
			$session  = $this->app_loader->current_account();
			$csrfHash = $this->security->get_csrf_hash();
			$token 		= escape($this->input->post('tokenId', TRUE));
			if(!empty($session) AND !empty($token)) {
				if($this->mdraft->validasiDataReview() == FALSE) {
					$result = array('status' => 0, 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
				} else {
					$data = $this->mdraft->rejectDataAgenda();
					if($data['message'] == 'NODATA') {
						$result = array('status' => 0, 'message' => array('isi' => 'Proses tolak data gagal, data yang akan tolak tidak ditemukan. Mohon diperiksa kembali data yang akan diupdate...'), 'csrfHash' => $csrfHash);
					}	else if($data['message'] == 'ERROR') {
						$result = array('status' => 0, 'message' => array('isi' => 'Proses tolak data <b>'.$data['nama_agenda'].' gagal'), 'csrfHash' => $csrfHash);
					} else if($data['message'] == 'SUCCESS') {
						$result = array('status' => 1, 'message' => 'Data <b>'.$data['nama_agenda'].' </b> berhasil ditolak...', 'csrfHash' => $csrfHash);
					}
				}
			} else {
				$result = array('status' => 0, 'message' => array('isi' => 'Proses tolak gagal, mohon periksa data kembali...'), 'csrfHash' => $csrfHash);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}
	}

	public function getPenerima()
	{
			if (!$this->input->is_ajax_request()) {
	   		exit('No direct script access allowed');
			} else {
				$session  = $this->app_loader->current_account();
				$csrfHash = $this->security->get_csrf_hash();
				$jenis_agenda = $this->input->get('jenis_agenda', TRUE);
				if(!empty($jenis_agenda)AND !empty($session)) {
					$data = $this->mdraft->getDataPenerima($jenis_agenda);
					if(count($data) > 0) {
						$row = array();
						
						$row['id'] 		= $data['token'];
						$row['text']	= $data['fullname'];
						$hasil[] = $row;
						
						$result = array('status' => 1, 'message' => $hasil, 'csrfHash' => $csrfHash);
					} else
						$result = array('status' => 0, 'message' => '', 'csrfHash' => $csrfHash);
				} else {
					$result = array('status' => 0, 'message' => '', 'csrfHash' => $csrfHash);
				}
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
			}
	}

	public function getPenerimaDisposisi()
	{
			if (!$this->input->is_ajax_request()) {
	   		exit('No direct script access allowed');
			} else {
				$session  = $this->app_loader->current_account();
				$csrfHash = $this->security->get_csrf_hash();
				$jenis_agenda = $this->input->get('jenis_agenda', TRUE);
				$token = $this->input->get('token_agenda', TRUE);
				$detail = $this->mdraft->getDetailDraft($token);

				$out='';

				if(!empty($session)) {
					$data = $this->mdraft->getDataPenerimaDisposisi($detail['jenis_agenda']);					

					if(count($data) > 0) 
					{
						foreach ($data as $key => $value) 
						{
							if ($jenis_agenda=='P') {
								$out .='<option value="'.$value['token'].'"> '.$value['fullname'].' </option>';
							}
							else{
								$out .='<option value="'.$value['token'].'"> '.$value['fullname'].' </option>';
							}
							
						}
						
					} 
					echo $out;
				}
			}
	}

	public function download_file()
	{
		$this->load->helper('download');

		$token = escape($this->uri->segment(4,0));
		$detailAgenda = $this->mdraft->getDetailDraft($token);

		$tahun = substr($detailAgenda['create_date'],0,4);
        $bulan = substr($detailAgenda['create_date'],5,2); 
        $dokumen = $detailAgenda['dokumen'];

        if ( ($dokumen !="") && file_exists('images/agenda/'.$tahun.'/'.$bulan.'/'.$dokumen) ){
        	 $isi = file_get_contents(realpath('./images/agenda/'.$tahun.'/'.$bulan.'/'.$dokumen));
			 force_download($dokumen,$isi);
        }
	}

	
}

// This is the end of draft class
