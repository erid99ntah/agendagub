<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of tentang class
 *
 * @author Diskominfo
 */

class Model_tentang extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue()
	{
		$this->form_validation->set_rules('judul',      'Judul',  'required|trim|min_length[4]|max_length[300]');
		$this->form_validation->set_rules('isi',      	'isi',  'required|trim|min_length[4]');
		$this->form_validation->set_rules('status', 	'Status', 	  'required|trim');

	  	validation_message_setting();
	    if ($this->form_validation->run() == FALSE)
	      return false;
	    else
	      return true;
	}

	var $search = array('nm_kategori');
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
    	return $this->db->count_all_results('tentang');
    }

    private function _get_datatables_query($param)
    {
		$post = array();
		if (is_array($param)) {
	      foreach ($param as $v) {
	        $post[$v['name']] = $v['value'];
	      }
    	}

		$this->db->select('*');
		$this->db->from('tentang');
		
		if(isset($post['judul']) AND $post['judul'] != '')
			$this->db->where('judul', $post['judul']);
		
		//status
		if(isset($post['status']) AND $post['status'] != '')
			$this->db->where('id_status', $post['status']);

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

		$this->db->order_by('id_tentang DESC');
    }

   	public function getDataDetailTentang($token)
	{
		$this->db->select('*');
		$this->db->from('tentang');
		$this->db->where('token', $token);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function insertDataTentang()
	{
		$create_by     = $this->app_loader->current_account();
		$create_date   = gmdate('Y-m-d H:i:s', time()+60*60*7);
		$create_ip     = $this->input->ip_address();
		$judul 		   = escape($this->input->post('judul', TRUE));		
		$token		   = generateToken($create_by.''.$create_date, $judul);

        $file_name          = $_FILES['img']['name'];
        if ($file_name=='')
        {
        	error_message('danger', 'Peringatan!', 'Gambar wajib Diupload...');
        	redirect('master/tentang/create');
        }
        else
        {	

        	  $config = array(
                             'allowed_types' => 'jpg|jpeg|gif|png',
                             'upload_path' => realpath('./images/tentang/'.date('Y').'/'.date('m').'/'),
                             'max_size' => 10000,
                             'remove_spaces' => TRUE
                          );                  
                      
	          $this->load->library('upload', $config);
	          $this->upload->do_upload();

	          $file = $this->upload->file_name;

	          if($this->upload->do_upload('img'))
	          {

	              $file1 = $this->upload->data();
	              $file2 = $file1['file_name'];
	              $gambar = $file2;  
	              $this->createThumbnailFoto($gambar); 

	              $data = array(
					'token'			    => escape($token),
					'judul'				=> $judul,
					'ket'				=> escape($this->input->post('keterangan', TRUE)),
					'isi'				=> $this->input->post('isi', TRUE),										
					'gambar'			=> $gambar,					

					'create_by'			=> $create_by,
					'create_date'		=> $create_date,
					'create_ip'			=> $create_ip,
					'id_status'			=> escape($this->input->post('status', TRUE)),
					);

					$this->db->insert('tentang', $data);
					return TRUE;
	          }
	          else 
	          {
	               error_message('danger', 'Peringatan!', 'Dokumen wajib Diupload...');
	               redirect('master/tentang/create');
	          }                     
        	
        }   		
		
	}

	public function updateDataTentang()
	{
		$create_by    = $this->app_loader->current_account();
		$create_date  = gmdate('Y-m-d H:i:s', time()+60*60*7);
		$create_ip    = $this->input->ip_address();
		
		$token   = escape($this->input->post('token', TRUE));
		$judul = escape($this->input->post('judul', TRUE));
		
		$status  	   = escape($this->input->post('status', TRUE));


		//cek data by id
		$dataDetail = $this->getDataDetailTentang($token);
		$year  = substr($dataDetail['create_date'],0,4);
        $month = substr($dataDetail['create_date'],5,2); 
        $foto  = $dataDetail['gambar']; 

		if(count($dataDetail) <= 0){
			error_message('danger', 'Peringatan!', 'Data Tidak Ditemukan...');
			redirect('master/tentang');
		}
		else 
		{
			

			$config = array(
                     'allowed_types'  => 'jpg|jpeg|png',
                     'upload_path'    => realpath('./images/tentang/'.$year.'/'.$month.'/'),
                     'max_size'       => 1000000,
                     'remove_spaces'  => TRUE
                     );

	        $this->load->library('upload', $config);
	        $this->upload->do_upload();

	        if($this->upload->do_upload('update_gambar'))
	        {	            
	            if ($foto != "" || $foto != NULL)
	            {
	                $path = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']);
	                $direktori    = $path.'images/tentang/'.$year.'/'.$month.'/';
	                $direktori1    = $path.'images/tentang/'.$year.'/'.$month.'/thumbnail/';

	                if(file_exists($direktori.'/'.$foto))
	                unlink($direktori.'/'.$foto);   

	                if(file_exists($direktori1.'/'.$foto))
                	unlink($direktori1.'/'.$foto);             
	            }

	            $file1 = $this->upload->data();
	            $file2 = $file1['file_name'];
	            $update_gambar = $file2;
	            $gambar = $update_gambar;
	            $this->createThumbnailFoto($gambar);

	             $data = array(
					'token'			    => escape($token),
					'judul'				=> $judul,
					'ket'				=> escape($this->input->post('keterangan', TRUE)),
					'isi'				=> $this->input->post('isi', TRUE),										
					'gambar'			=> $update_gambar,

					'mod_by'			=> $create_by,
					'mod_date'		=> $create_date,
					'mod_ip'			=> $create_ip,
					'id_status'			=> escape($this->input->post('status', TRUE)),
					);

					 $this->db->where('token', $token);
					 $this->db->update('tentang', $data);
					return TRUE;
	        }
	        else
	        {
	        	 $data = array(
					'token'			    => escape($token),
					'judul'				=> $judul,
					'ket'				=> escape($this->input->post('keterangan', TRUE)),
					'isi'				=> $this->input->post('isi', TRUE),	

					'mod_by'			=> $create_by,
					'mod_date'		=> $create_date,
					'mod_ip'			=> $create_ip,
					'id_status'			=> escape($this->input->post('status', TRUE)),
					);

				$this->db->where('token', $token);
				$this->db->update('tentang', $data);
				return TRUE;
	        }
	       
		}
	}

	public function deleteDataTentang($token)
	{
		$detail = $this->getDataDetailTentang($token); 
		if(count($detail) <= 0)
		{
			error_message('danger', 'Peringatan!', 'Data Tidak Ditemukan...');
			redirect('master/tentang');
		}
		else{

			$year = substr($detail['create_date'],0,4);
	        $month = substr($detail['create_date'],5,2);  
	        $cek = realpath('./images/tentang/'.$year.'/'.$month.'/'.$detail['gambar']);
	        $cekThumb = realpath('./images/tentang/'.$year.'/'.$month.'/thumbnail/'.$detail['gambar']);

	        if (file_exists($cek)){
	        	unlink('./images/tentang/'.$year.'/'.$month.'/'.$detail['gambar']);
			}

			if (file_exists($cekThumb)){
	        	unlink('./images/tentang/'.$year.'/'.$month.'/thumbnail/'.$detail['gambar']);
			} 

			$this->db->where('token', $token);
			$this->db->delete('tentang');
			return TRUE;
		}
	}

	public function updateToken(){
		$this->db->select('*');
	    $this->db->from('tentang');
	    $cek = $this->db->get();

	    foreach ($cek->result_array() as $key => $value) {
	    	$id_tentang = $value['id_tentang'];
	    	$judul = $value['judul'];
	    	$create_by     = $this->app_loader->current_account();
	    	$create_date   = gmdate('Y-m-d H:i:s', time()+60*60*7);

	    	$token	= generateToken($create_by.''.$create_date, $judul);

	    	$data = array(
				'token'	=> $token,
			);
			$this->db->where('id_tentang', $id_tentang);
			$this->db->update('tentang', $data);

	    }
	}

	 public function createThumbnailFoto($gambar) 
	 {
        $tahun = date('Y');
        $bulan = date('m');
        $folderThumb = './images/tentang/'.$tahun.'/'.$bulan.'/thumbnail/';
        if (is_dir($folderThumb)==false) {
        	mkdir($folderThumb);
        }
        $config['source_image'] = './images/tentang/'.$tahun.'/'.$bulan.'/'.$gambar;
        $config['new_image'] = './images/tentang/'.$tahun.'/'.$bulan.'/thumbnail/'.$gambar;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 150;
        $config['height'] = 90;
        $this->load->library('image_lib', $config);
        if (!$this->image_lib->resize()) {
            echo 'create thumbnail foto gagal' . $this->image_lib->display_errors();
        }
    }
}

// This is the end of tentang model
