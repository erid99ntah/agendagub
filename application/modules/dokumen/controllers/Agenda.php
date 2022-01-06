<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Agenda
 *
 * @author Diskominfo Sumbar
 */

class Agenda extends SLP_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('model_agenda' => 'mag', 'model_master' => 'mmas'));
	}

	public function index()
	{
		$this->breadcrumb->add('Dashboard', site_url('home'));
		$this->breadcrumb->add('Dokumen', '#');
		$this->breadcrumb->add('Data Agenda', '#');
		
		$this->session_info['page_name'] = "Data Agenda";
		//$this->session_info['province']  = $this->mmas->getDataProvince();
		$this->template->build('form_agenda/list_agenda', $this->session_info);
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
				$dataList = $this->mag->get_datatables($param);
				$no = $this->input->post('start');
				foreach ($dataList as $key => $dl) {

					if ($dl['status_disposisi']=='SD')
						$status='Sudah Disposisi';
					else
						$status='Belum Disposisi';

					if ($dl['status_verifikasi']=='SM')
						$status_verifikasi='<label class="label label-warning">'.$dl['nm_status'].'</label>';
					elseif($dl['status_verifikasi']=='CC')
						$status_verifikasi='<label class="label label-success">'.$dl['nm_status'].'</label>';
					else
						$status_verifikasi='<label class="label label-danger">'.$dl['nm_status'].'</label>';

					if ($dl['jenis_agenda']=='P'){
					 $ver='<button type="button" class="btn btn-xs btn-success btnReview" data-id="'.$dl['token'].'" data-nm="'.$dl['nama_agenda'].'" title="Validasi Agenda"><i class="fa fa-check-square-o"></i> </button>
							  <button type="button" class="btn btn-xs btn-danger btnReject" data-id="'.$dl['token'].'" data-nm="'.$dl['nama_agenda'].'"title="Tolak Agenda"><i class="fa fa-times"></i> </button>';	
					}					
					else{
					  $ver='<button type="button" class="btn btn-xs btn-primary btnValidasi" data-id="'.$dl['token'].'" data-nm="'.$dl['nama_agenda'].'"title="Validasi Agenda"><i class="fa fa-check-square"></i> </button>
							<button type="button" class="btn btn-xs btn-danger btnReject" data-id="'.$dl['token'].'" data-nm="'.$dl['nama_agenda'].'"title="Tolak Agenda"><i class="fa fa-times"></i> </button>';
					}

					$cekStatusAgenda = $this->mag->getStatusAgenda($dl['id_status']);
					if ($dl['id_status']=='SM')
						$status_agenda='<label class="label label-warning">'.$cekStatusAgenda.'</label>';
					elseif($dl['id_status']=='SH')
						$status_agenda='<label class="label label-success">'.$cekStatusAgenda.'</label>';
					else
						$status_agenda='<label class="label label-danger">'.$cekStatusAgenda.'</label>';

					$no++;
					$row = array();
					$row[] = $no;
					$row[] = '<a data-toggle="tooltip" data-placement="left" title="Detail Draft Agenda" href="'.site_url('dokumen/agenda/review/'.$dl['token']).'/'.create_url($dl['nama_agenda']).'" 
							  class="tooltips"><i class="fa fa-edit"></i> '.$dl['nama_agenda'].'</a>';
					$row[] = convert_agenda($dl['jenis_agenda']);
					$row[] = tgl_indo($dl['tanggal']);
					$row[] = ' '.$dl['jam_mulai'].' s.d '.$dl['jam_selesai'].' ';
					$row[] = $dl['kegiatan'];
					$row[] = $dl['lokasi_kegiatan'];					
					$row[] = $status_agenda;						
					$data[] = $row;
				}

				$output = array(
					"draw" => $this->input->post('draw'),
					"recordsTotal" => $this->mag->count_all(),
					"recordsFiltered" => $this->mag->count_filtered($param),
					"data" => $data,
					);
			}
			//output to json format
			$this->output->set_content_type('application/json')->set_output(json_encode($output));
		}
	}
	
	public function review()
	{
		$this->breadcrumb->add('Dashboard', site_url('home'));
		$this->breadcrumb->add('Dokumen', '#');
		$this->breadcrumb->add('Data Agenda', site_url('dokumen/agenda'));
		$this->breadcrumb->add('Detail Agenda', '#');
		$this->session_info['page_name'] = "Detail Draft Agenda";

		$token = $this->uri->segment(4,0);				
		$this->session_info['detail']  = $this->mag->getDetailAgenda($token);
		$this->template->build('form_agenda/detail_agenda', $this->session_info);
		
	}

	

	
}

// This is the end of home clas
