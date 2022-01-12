<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of tentang class
 *
 * @author Diskominfo
 */

class Tentang extends SLP_Controller {

  public function __construct()
  {
    parent::__construct();
		$this->load->model(array('model_tentang' => 'mtentang', 'model_master' => 'mmas'));
  }

	public function index()
	{
	    $this->breadcrumb->add('Dashboard', site_url('home'));
	    $this->breadcrumb->add('Dokumen', '#');
		$this->breadcrumb->add('Data Tentang', '#');

		$this->session_info['page_name'] 	= "Data Tentang";
	    $this->template->build('form_tentang/list_tentang', $this->session_info);
	    $this->mtentang->updateToken();
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
		    $dataList = $this->mtentang->get_datatables($param);
				$no = $this->input->post('start');
				foreach ($dataList as $key => $dl) {
					$no++;
	        $row = array();
	        $row[] = $no;																			
					$row[] = '<a href="'.site_url('master/tentang/update/'.$dl['token'].'/'.create_url($dl['judul'])).'" class="confirm-edit">
							  <i class="fa fa-pencil"></i> '.$dl['judul'].' </a>';
					$row[] = $dl['ket'];
					$row[] = substr($dl['isi'],0,200);
					$row[] = '<p><a href=""><i class="fa fa-calendar"></i>"'.tgl_indo_time($dl['create_date']).'" </a></p>
                              <hr style="margin:0px; border-color:#c9c9c9;">
                              <span style="font-size:10px;"><i class="fa fa-user"> By : </i> <p>"'.$dl['create_by'].'"</p></span>';
					$row[] = '<a href="'.site_url('master/tentang/download/'.$dl['token'].'/'.create_url($dl['judul'])).'" 
							  class=""><i class="fa fa-download"></i> '.$dl['gambar'].'</a>';
					$row[] = convert_status($dl['id_status']);
	        $row[] = '<a href="'.site_url('master/tentang/update/'.$dl['token'].'/'.create_url($dl['judul'])).'" class="btn btn-orange btn-xs confirm-edit"><i class="fa fa-pencil"></i> </a>
					  <a href="'.site_url('master/tentang/delete/'.$dl['token'].'/'.create_url($dl['judul'])).'" class="btn btn-danger btn-xs confirm-hapus"><i class="fa fa-trash-o"></i> </a>';
	        $data[] = $row;
				}

				$output = array(
	        "draw" => $this->input->post('draw'),
	        "recordsTotal" => $this->mtentang->count_all(),
	        "recordsFiltered" => $this->mtentang->count_filtered($param),
	        "data" => $data,
	      );
			}
			//output to json format
			$this->output->set_content_type('application/json')->set_output(json_encode($output));
		}
	}

	public function create()
  	{
		if($this->input->post('save', TRUE))
      		$this->createData();
    	else
      	$this->createForm();
  	}

	private function createForm()
	{
		$this->breadcrumb->add('Dashboard', site_url('home'));
	    $this->breadcrumb->add('Dokumen', '#');
	    $this->breadcrumb->add('Data Tentang', site_url('master/tentang'));
	    $this->breadcrumb->add('Entri Baru', site_url('master/tentang/create'));

		$this->session_info['page_name'] 	= "Data Tentang - Entri Baru";
		$this->session_info['urlform']		= "master/tentang/create";
    	$this->template->build('form_tentang/add_tentang', $this->session_info);
    
	}

	private function createData()
	{
		if($this->mtentang->validasiDataValue('save') == FALSE) {
			error_message('danger', 'Peringatan!', 'Tolong dilengkapi form inputan dibawah...');			
      	$this->createForm();
    } else {
			$data = $this->mtentang->insertDataTentang();
			if($data) {
				error_message('success', 'Sukses!', 'Data berhasil disimpan.');
				redirect('master/tentang');
			}
		}
	}

	public function update($id, $name)
	{
		if(!isset($id) OR !isset($name))
	      redirect('master/tentang');

		if($this->input->post('save', TRUE))
	      $this->updateData($id, $name);
	    else
	      $this->updateForm($id, $name);
	}

	private function updateForm($id, $name)
	{
	    $data_edit = $this->mtentang->getDataDetailTentang($id);

	    if(count($data_edit) == 0)
	      redirect('master/tentang/create');

		$this->breadcrumb->add('Dashboard', site_url('home'));
	    $this->breadcrumb->add('Dokumen', '#');
	    $this->breadcrumb->add('Data Tentang', site_url('master/tentang'));
	    $this->breadcrumb->add('Edit Data', site_url('master/tentang/update'));

		$this->session_info['page_name'] 	= "Data Tentang - Edit Data";
		$this->session_info['detail'] 		= $data_edit;
		$this->session_info['urlform']		= "master/tentang/update/".$id."/".$name;

	    $this->template->build('form_tentang/edit_tentang', $this->session_info);
	}

	private function updateData($id, $name)
	{
		if($this->mtentang->validasiDataValue('edit') == FALSE) {
			error_message('danger', 'Peringatan!', 'Tolong dilengkapi form inputan dibawah...');
      	$this->updateForm($id, $name);
    } else {
			$data = $this->mtentang->updateDataTentang();
			if($data) {
				error_message('success', 'Sukses!', 'Data berhasil disimpan.');
				redirect('master/tentang');
			}
		}
	}

	public function delete()
	{
		$token= escape($this->uri->segment(4,0));
		if(empty($token)) {
			error_message('danger', 'Peringatan!', 'Data harus dipilih terlebih dahulu jika ingin dihapus..');
			redirect('master/tentang');
		}
		else{
			$data = $this->mtentang->deleteDataTentang($token);
			if($data) {
				error_message('success', 'Sukses!', 'Data berhasil dihapus.');
				redirect('master/tentang');
			}
		}      
	}
	
	public function download()
	{	

	      $token= escape($this->uri->segment(4,0)); 
	      if(!empty($token))
	      {	        
	        $this->load->helper('download');

	        $data = $this->mtentang->getDataDetailTentang($token);  
	        $year = substr($data['create_date'],0,4);
	        $month = substr($data['create_date'],5,2);  
	        $cek = realpath('./album/tentang/'.$year.'/'.$month.'/'.$data['gambar']);

	        if (file_exists($cek)){
	        	$isi = file_get_contents(realpath('./album/tentang/'.$year.'/'.$month.'/'.$data['gambar']));	        
	        	$nama  = $data['gambar'];
			    force_download($nama,$isi);
			} else {
			    error_message('danger', 'Gagal!', 'Dokumen Tidak Ditemukan 	');
			    redirect('master/tentang');
			}
	      }
	      else
	      {
	        redirect('master/tentang');
	      }   
	}
	
}

// This is the end of tentang clas
