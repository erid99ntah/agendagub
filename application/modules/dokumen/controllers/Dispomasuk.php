<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Disposisi Masuk
 *
 * @author Diskominfo Sumbar
 */

class Dispomasuk extends SLP_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('model_dispomasuk' => 'm_masuk', 'model_master' => 'mmas'));
	}

	public function index()
	{
		$this->breadcrumb->add('Dashboard', site_url('home'));
		$this->breadcrumb->add('Dokumen', '#');
		$this->breadcrumb->add('Data Disposisi Masuk', '#');
		
		$this->session_info['page_name'] = "Data Disposisi Masuk";		
		$this->template->build('form_dispomasuk/list_dispomasuk', $this->session_info);
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
				$dataList = $this->m_masuk->get_datatables($param);
				$no = $this->input->post('start');
				foreach ($dataList as $key => $dl) 
				{	

					$nm_pengirim  = $this->m_masuk->getUserFullname($dl['id_pengirim']);
					$nm_penerima  = $this->m_masuk->getUserFullname($dl['id_penerima']);
					if ($dl['status_penerima']=='SD') {
						$stats='<label class="label label-success">Sudah Dibaca</label>';
					}else{
						$stats='<label class="label label-danger">Belum Dibaca</label>';
					}

					$no++;
					$row = array();
					$row[] = $no;
					$row[] = '<a data-toggle="tooltip" data-placement="left" title="Detail Disposisi" href="'.site_url('dokumen/dispomasuk/review/'.$dl['token']).'/'.create_url($nm_pengirim).'" 
							  class="tooltips"><i class="fa fa-edit"></i> '.$dl['isi_disposisi'].'</a>';
					$row[] = '<a data-toggle="tooltip" data-placement="left" title="Detail Disposisi" href="'.site_url('dokumen/dispomasuk/review/'.$dl['token']).'/'.create_url($nm_pengirim).'" 
							  class="tooltips"><i class="fa fa-edit"></i> '.$nm_pengirim.'</a>';
					$row[] = tgl_indo_time($dl['tgl_disposisi']);
					$row[] = $nm_penerima;					
					$row[] = $stats;					
					$row[] = '<a data-toggle="tooltip" data-placement="left" title="Detail Disposisi" href="'.site_url('dokumen/dispomasuk/review/'.$dl['token']).'/'.create_url($nm_pengirim).'" 
							  class="btn btn-xs btn-warning tooltips"><i class="fa fa-edit"></i> Detail</a>';					
					$data[] = $row;
				}

				$output = array(
					"draw" => $this->input->post('draw'),
					"recordsTotal" => $this->m_masuk->count_all(),
					"recordsFiltered" => $this->m_masuk->count_filtered($param),
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
		$this->breadcrumb->add('Data Disposisi Masuk', site_url('dokumen/dispomasuk'));
		$this->breadcrumb->add('Detail Disposisi Masuk', '#');
		$this->session_info['page_name'] = "Detail Disposisi Masuk";

		$token = $this->uri->segment(4,0);				
		$this->session_info['detail']  = $this->m_masuk->getDetailDisposisiMasuk($token);
		$this->template->build('form_dispomasuk/detail_dispomasuk', $this->session_info);
		
	}

	

	
}

// This is the end of home clas
