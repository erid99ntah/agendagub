<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of kontrol model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_kontrol extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

  public function validasiDataValue($role)
	{
		$rules = ($role == "add") ? '|is_unique[xi_sa_kontrol.nama_kontrol]' : '';
	  $this->form_validation->set_rules('nama_kontrol', 'Nama Kontrol', 'required|trim'.$rules);
    $this->form_validation->set_rules('label_kontrol', 'Label Kontrol', 'required|trim');
    $this->form_validation->set_rules('url_kontrol', 'URL Kontrol', 'required|trim');
    validation_message_setting();
    if ($this->form_validation->run() == FALSE)
      return false;
    else
      return true;
	}

  /*Fungsi Geta Data List*/
  public function getDataListKontrol()
  {
    $this->db->select('*');
    $this->db->from('xi_sa_kontrol');
    $this->db->order_by('id_kontrol', 'ASC');
    $query = $this->db->get();

    return $query->result();
  }

	//get data fungsi by id
	public function getDataKontrolWithId($id_kontrol)
	{
		$this->db->select('*');
    $this->db->from('xi_sa_kontrol');
    $this->db->where('id_kontrol', abs($id_kontrol));
    $query = $this->db->get();

    return $query;
	}

	/*Fungsi get data edit by id dan url*/
	public function editDataKontrol($id, $name)
	{
		$this->db->select('*');
    $this->db->from('xi_sa_kontrol');
		$this->db->where('id_kontrol', abs($id));
		$this->db->like('nama_kontrol', $this->db->escape_str($name));
    $query = $this->db->get();

    return $query;
	}

  /* Fungsi untuk insert data */
  public function insertDataKontrol()
  {
    //get data
    $create_by      		= $this->app_loader->current_account();
    $create_date    		= date('Y-m-d H:i:s');
    $create_ip      		= $this->input->ip_address();

    $nama_kontrol   		= html_escape($this->input->post('nama_kontrol', TRUE));
    $label_kontrol  		= html_escape($this->input->post('label_kontrol', TRUE));
    $url_kontrol    		= html_escape($this->input->post('url_kontrol', TRUE));
		$deskripsi_kontrol 	= html_escape($this->input->post('deskripsi_kontrol', TRUE));
    $status         		= html_escape($this->input->post('status', TRUE));

    $data = array(
      'nama_kontrol' => $this->db->escape_str($nama_kontrol),
      'label_kontrol' => $this->db->escape_str($label_kontrol),
      'url_kontrol' => $this->db->escape_str($url_kontrol),
			'deskripsi_kontrol' => $this->db->escape_str($deskripsi_kontrol),
      'create_by' => $this->db->escape_str($create_by),
      'create_date' => $this->db->escape_str($create_date),
      'create_ip' => $this->db->escape_str($create_ip),
      'mod_by' => $this->db->escape_str($create_by),
      'mod_date' => $this->db->escape_str($create_date),
      'mod_ip' => $this->db->escape_str($create_ip),
      'id_status' => $this->db->escape_str($status),
    );

    /*query insert*/
    $this->db->insert('xi_sa_kontrol', $data);
    return TRUE;
  }

	/* Fungsi untuk update data */
  public function updateDataKontrol()
  {
    //get data
    $create_by      		= $this->app_loader->current_account();
    $create_date    		= date('Y-m-d H:i:s');
    $create_ip      		= $this->input->ip_address();

		$id_kontrol					= html_escape($this->input->post('kontrol', TRUE));
    $nama_kontrol				= html_escape($this->input->post('nama_kontrol', TRUE));
    $label_kontrol  		= html_escape($this->input->post('label_kontrol', TRUE));
    $url_kontrol    		= html_escape($this->input->post('url_kontrol', TRUE));
		$deskripsi_kontrol 	= html_escape($this->input->post('deskripsi_kontrol', TRUE));
    $status         		= html_escape($this->input->post('status', TRUE));

    $data = array(
      'nama_kontrol' => $this->db->escape_str($nama_kontrol),
      'label_kontrol' => $this->db->escape_str($label_kontrol),
      'url_kontrol' => $this->db->escape_str($url_kontrol),
			'deskripsi_kontrol' => $this->db->escape_str($deskripsi_kontrol),
      'mod_by' => $this->db->escape_str($create_by),
      'mod_date' => $this->db->escape_str($create_date),
      'mod_ip' => $this->db->escape_str($create_ip),
      'id_status' => $this->db->escape_str($status),
    );

		//cek nama fungsi biar tidak terjadi duplikat data
		$this->db->where('id_kontrol <>', abs($id_kontrol));
		$this->db->where('nama_kontrol', $this->db->escape_str($nama_kontrol));
		$count = $this->db->count_all_results('xi_sa_kontrol');
		if($count > 0)
			return FALSE;
		else {
			/*query update*/
			$this->db->where('id_kontrol', abs($id_kontrol));
			$this->db->update('xi_sa_kontrol', $data);
			return TRUE;
		}
  }

	public function deleteDataKontrol()
	{
		$kontrol = $this->input->post('checkid', TRUE);
		//jika ingin menghapus data lakukan looping
		$i=0;$j=0;
		foreach ($kontrol as $key => $id) {
			//cek jika kontrol digunakan atau tidak
			$this->db->where('id_kontrol', abs($id));
			$count = $this->db->count_all_results('xi_sa_rules');
			if($count == 0) {
				/*query delete*/
				$this->db->where('id_kontrol', abs($id));
				$this->db->delete('xi_sa_kontrol');
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
}

// This is the end of auth signin model
