<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of kontrol model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_module extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

  public function validasiDataValue($role)
	{
		$rules = ($role == "add") ? '|is_unique[xi_sa_module.nama_module]' : '';
	  $this->form_validation->set_rules('nama_module', 'Nama Module', 'required|trim'.$rules);
    $this->form_validation->set_rules('label_module', 'Label Module', 'required|trim');
    $this->form_validation->set_rules('url_module', 'URL Module', 'required|trim');
    validation_message_setting();
    if ($this->form_validation->run() == FALSE)
      return false;
    else
      return true;
	}

	public function validasiDataRulesValue()
	{
	  $this->form_validation->set_rules('nama_kontrol', 'Nama Kontrol', 'required|trim');
    $this->form_validation->set_rules('nama_fungsi[]', 'Nama Fungsi', 'required|trim');
    validation_message_setting();
    if ($this->form_validation->run() == FALSE)
      return false;
    else
      return true;
	}

  /*Fungsi Geta Data List*/
  public function getDataListModule()
  {
    $this->db->select('*');
    $this->db->from('xi_sa_module');
    $this->db->order_by('id_module', 'ASC');
    $query = $this->db->get();

    return $query->result();
  }

	//get data fungsi by id
	public function getDataModuleWithId($id_module)
	{
		$this->db->select('*');
    $this->db->from('xi_sa_module');
    $this->db->where('id_module', abs($id_module));
    $query = $this->db->get();

    return $query;
	}

	/*Fungsi get data edit by id dan url*/
	public function editDataModule($id, $name)
	{
		$this->db->select('*');
    $this->db->from('xi_sa_module');
		$this->db->where('id_module', abs($id));
		$this->db->where('nama_module', $this->db->escape_str($name));
    $query = $this->db->get();

    return $query;
	}

  /* Fungsi untuk insert data */
  public function insertDataModule()
  {
    //get data
    $create_by      		= $this->app_loader->current_account();
    $create_date    		= date('Y-m-d H:i:s');
    $create_ip      		= $this->input->ip_address();

		$nama_module   			= html_escape($this->input->post('nama_module', TRUE));
    $label_module  			= html_escape($this->input->post('label_module', TRUE));
    $url_module    			= html_escape($this->input->post('url_module', TRUE));
		$deskripsi_module 	= html_escape($this->input->post('deskripsi_module', TRUE));
    $status         		= html_escape($this->input->post('status', TRUE));

    $data = array(
      'nama_module' => $this->db->escape_str($nama_module),
      'label_module' => $this->db->escape_str($label_module),
      'url_module' => $this->db->escape_str($url_module),
			'deskripsi_module' => $this->db->escape_str($deskripsi_module),
      'create_by' => $this->db->escape_str($create_by),
      'create_date' => $this->db->escape_str($create_date),
      'create_ip' => $this->db->escape_str($create_ip),
      'mod_by' => $this->db->escape_str($create_by),
      'mod_date' => $this->db->escape_str($create_date),
      'mod_ip' => $this->db->escape_str($create_ip),
      'id_status' => $this->db->escape_str($status),
    );

    /*query insert*/
    $this->db->insert('xi_sa_module', $data);
    return TRUE;
  }

	/* Fungsi untuk update data */
  public function updateDataModule()
  {
    //get data
    $create_by      		= $this->app_loader->current_account();
    $create_date    		= date('Y-m-d H:i:s');
    $create_ip      		= $this->input->ip_address();

		$id_module					= html_escape($this->input->post('module', TRUE));
    $nama_module				= html_escape($this->input->post('nama_module', TRUE));
    $label_module  			= html_escape($this->input->post('label_module', TRUE));
    $url_module    			= html_escape($this->input->post('url_module', TRUE));
		$deskripsi_module 	= html_escape($this->input->post('deskripsi_module', TRUE));
    $status         		= html_escape($this->input->post('status', TRUE));

		$data = array(
      'nama_module' => $this->db->escape_str($nama_module),
      'label_module' => $this->db->escape_str($label_module),
      'url_module' => $this->db->escape_str($url_module),
			'deskripsi_module' => $this->db->escape_str($deskripsi_module),
      'mod_by' => $this->db->escape_str($create_by),
      'mod_date' => $this->db->escape_str($create_date),
      'mod_ip' => $this->db->escape_str($create_ip),
      'id_status' => $this->db->escape_str($status),
    );

		//cek nama fungsi biar tidak terjadi duplikat data
		$this->db->where('id_module <>', abs($id_module));
		$this->db->where('nama_module', $this->db->escape_str($nama_module));
		$count = $this->db->count_all_results('xi_sa_module');
		if($count > 0)
			return FALSE;
		else{
			/*query update*/
			$this->db->where('id_module', abs($id_module));
			$this->db->update('xi_sa_module', $data);
			return TRUE;
		}
  }

	public function deleteDataModule()
	{
		$module = $this->input->post('checkid', TRUE);
		//jika ingin menghapus data lakukan looping
		$i=0;$j=0;
		foreach ($module as $key => $id) {
			//cek jika module digunakan atau tidak
			$this->db->where('id_module', abs($id));
			$count = $this->db->count_all_results('xi_sa_rules');
			if($count == 0){
				/*query delete*/
				$this->db->where('id_module', abs($id));
				$this->db->delete('xi_sa_module');
				$i+=1;
			}else
				$j+=1;
		}

		if($i > 0 && $j > 0)
			return "ONLYNOTUSE";
		elseif($i==0 && $j > 0)
			return "ONUSE";
		else
			return "NOTUSE";
	}

	/* get data rules module*/
	public function getDataRulesModule($id_module)
	{
		$this->db->select('xi_sa_rules.id_rules,
											xi_sa_rules.id_module,
											xi_sa_rules.id_kontrol,
											xi_sa_rules.id_fungsi,
											xi_sa_rules.id_status,
											xi_sa_kontrol.nama_kontrol,
											xi_sa_kontrol.label_kontrol,
											xi_sa_fungsi.nama_fungsi,
											xi_sa_fungsi.label_fungsi');
		$this->db->from('xi_sa_rules');
		$this->db->join('xi_sa_kontrol', 'xi_sa_rules.id_kontrol = xi_sa_kontrol.id_kontrol', 'inner');
		$this->db->join('xi_sa_fungsi', 'xi_sa_rules.id_fungsi = xi_sa_fungsi.id_fungsi', 'inner');
		$this->db->where('xi_sa_rules.id_module', abs($id_module));
		$this->db->where('xi_sa_kontrol.id_status', 1);
		$this->db->where('xi_sa_fungsi.id_status', 1);
		$this->db->where_in('xi_sa_fungsi.id_jenis_fungsi', array(1,2));
		$this->db->order_by('xi_sa_kontrol.id_kontrol', 'ASC');
		$this->db->order_by('xi_sa_fungsi.id_fungsi', 'ASC');
		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return false;
	}

	public function getDataKontrolAll()
	{
		$this->db->where('id_status', 1);
		$this->db->order_by('id_kontrol', 'ASC');
		$query = $this->db->get('xi_sa_kontrol');

		$dd_kontrol[''] = 'Pilih Data';
    if ($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        $dd_kontrol[$row->id_kontrol] = $row->label_kontrol;
      }
    }
    return $dd_kontrol;
	}

	public function getDataFungsiAll()
	{
		$this->db->where('id_status', 1);
		$this->db->where_in('xi_sa_fungsi.id_jenis_fungsi', array(1,2));
		$this->db->order_by('id_fungsi', 'ASC');
		$query = $this->db->get('xi_sa_fungsi');

		$dd_fungsi = array();
    if ($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        $dd_fungsi[$row->id_fungsi] = $row->label_fungsi;
      }
    }
    return $dd_fungsi;
	}

	/* Fungsi untuk insert data */
  public function insertDataModuleRules($id)
  {
    //get data
		$id_module	= html_escape($id);
		$id_kontrol = html_escape($this->input->post('nama_kontrol', TRUE));
    $id_fungsi 	= html_escape($this->input->post('nama_fungsi', TRUE));
    $status     = html_escape($this->input->post('status', TRUE));

		/*query insert*/
		foreach ($id_fungsi as $key => $fungsi) {
			/*cek data kontrol*/
			$this->db->where('id_module', abs($id_module));
			$this->db->where('id_kontrol', abs($id_kontrol));
			$this->db->where('id_fungsi', abs($fungsi));
			$qfungsi = $this->db->count_all_results('xi_sa_rules');
			if($qfungsi > 0)
				return FALSE;
			else{
				$data = array(
	        'id_module' => $this->db->escape_str($id_module),
	        'id_kontrol' => $this->db->escape_str($id_kontrol),
	        'id_fungsi' => $this->db->escape_str($fungsi),
	        'id_status' => $this->db->escape_str($status),
	      );
				$this->db->insert('xi_sa_rules', $data);
			}
		}
    return TRUE;
  }

	public function updateDataModuleRules($id)
	{
		//get data
		$id_module	= html_escape($id);
    $id_rules  	= html_escape($this->input->post('checkid', TRUE));
    $proses     = html_escape($this->input->post('update', TRUE));

		foreach ($id_rules as $key => $rules) {
			$this->db->where('id_rules', abs($rules));
			$this->db->where('id_module', abs($id_module));
			if($proses == "AR")
				$this->db->update('xi_sa_rules', array('id_status' => 1));
		 	elseif($proses == "NR")
				$this->db->update('xi_sa_rules', array('id_status' => 0));
			elseif($proses == "DR")
				$this->db->delete('xi_sa_rules');
		}
    return $proses;
	}
}

// This is the end of auth signin model
