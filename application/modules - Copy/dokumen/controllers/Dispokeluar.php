<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Disposisi Keluar
 *
 * @author Diskominfo Sumbar
 */

class Dispokeluar extends SLP_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('model_dispokeluar' => 'mkeluar', 'model_master' => 'mmas'));
	}

	public function index()
	{
		$this->breadcrumb->add('Dashboard', site_url('home'));
		$this->breadcrumb->add('Dokumen', '#');
		$this->breadcrumb->add('Data Disposisi', '#');
		
		$this->session_info['page_name'] = "Data Disposisi";		
		$this->template->build('form_dispokeluar/list_dispokeluar', $this->session_info);
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
				$dataList = $this->mkeluar->get_datatables($param);
				$no = $this->input->post('start');

				foreach ($dataList as $key => $dl) 
				{					
					$nm_pengirim = $this->mkeluar->getUserFullname($dl['id_pengirim']);
					$cek = $this->mkeluar->getIDPenerimaDisposisi($dl['id_disposisi']);
					$no++;
					$row = array();
					$row[] = $no;
					$row[] = '<a data-toggle="tooltip" data-placement="left" title="Detail Disposisi" href="'.site_url('dokumen/dispokeluar/review/'.$dl['token']).'/'.create_url($dl['nama_agenda']).'" 
							  class="tooltips"><i class="fa fa-edit"></i> '.$dl['nama_agenda'].'</a>';
					$row[] = '<a data-toggle="tooltip" data-placement="left" title="Detail Disposisi" href="'.site_url('dokumen/dispokeluar/review/'.$dl['token']).'/'.create_url($dl['nama_agenda']).'" 
							  class="tooltips"><i class="fa fa-edit"></i> '.$nm_pengirim.'</a>';										
					$row[] = $dl['isi_disposisi'];
					$row[] = tgl_indo_time($dl['tgl_disposisi']);					
					$row[] = $cek;
					$row[] = '';
					$data[] = $row;
				}

				$output = array(
					"draw" => $this->input->post('draw'),
					"recordsTotal" => $this->mkeluar->count_all(),
					"recordsFiltered" => $this->mkeluar->count_filtered($param),
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
		$this->breadcrumb->add('Data Disposisi', site_url('dokumen/agenda'));
		$this->breadcrumb->add('Detail Draft Agenda', '#');
		$this->session_info['page_name'] = "Detail Draft Agenda";

		$token = $this->uri->segment(4,0);				
		$this->session_info['detail']  = $this->mkeluar->getDetailDisposisi($token);
		$this->template->build('form_dispokeluar/detail_dispokeluar', $this->session_info);
		
	}

	

	
}

// This is the end of disposisi keluar clas
