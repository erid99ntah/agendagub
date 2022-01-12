<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of fungsi model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_fungsi extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

  public function validasiDataValue($role)
	{
		$rules = ($role == "add") ? '|is_unique[xi_sa_fungsi.nama_fungsi]' : '';
	  $this->form_validation->set_rules('nama_fungsi', 'Nama Fungsi', 'required|trim'.$rules);
    $this->form_validation->set_rules('label_fungsi', 'Label Fungsi', 'required|trim');
    $this->form_validation->set_rules('url_fungsi', 'URL Fungsi', 'required|trim');
    $this->form_validation->set_rules('jenis_fungsi', 'Jenis Fungsi', 'required');
    validation_message_setting();
    if ($this->form_validation->run() == FALSE)
      return false;
    else
      return true;
	}

  public function getDataJenisFungsi()
  {
    $this->db->where('id_status', 1);
    $this->db->order_by('id_jenis_fungsi', 'ASC');
    $query = $this->db->get('xi_sa_jenis_fungsi');

		$dd_fungsi[''] = 'Pilih Data';
    if ($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        $dd_fungsi[$row->id_jenis_fungsi] = $row->jenis_fungsi;
      }
    }
    return $dd_fungsi;
  }

  public function getDataLevelAkses()
  {
    $this->db->select('*');
    $this->db->from('xi_sa_level_akses');
    $this->db->where('id_status', 1);
    $this->db->order_by('id_level_akses', 'ASC');
    $query = $this->db->get();

    return $query->result();
  }

  /*Fungsi Get Data List*/
  public function getDataListFungsi()
  {
    $this->db->select('*');
    $this->db->from('xi_sa_fungsi');
    $this->db->order_by('id_fungsi', 'ASC');
    $query = $this->db->get();

    return $query->result();
  }

	//get data fungsi by id
	public function getDataFungsiWithId($id_fungsi)
	{
		$this->db->select('*');
    $this->db->from('xi_sa_fungsi');
    $this->db->where('id_fungsi', abs($id_fungsi));
    $query = $this->db->get();

    return $query;
	}

	/*Fungsi get data edit by id dan url*/
	public function editDataFungsi($id, $name)
	{
		$this->db->select('*');
    $this->db->from('xi_sa_fungsi');
		$this->db->where('id_fungsi', abs($id));
		$this->db->where('nama_fungsi', $this->db->escape_str($name));
    $query = $this->db->get();

    return $query;
	}

  /* Fungsi untuk insert data */
  public function insertDataFungsi()
  {
    //get data
    $create_by        = $this->app_loader->current_account();
    $create_date      = date('Y-m-d H:i:s');
    $create_ip        = $this->input->ip_address();

    $nama_fungsi      = html_escape($this->input->post('nama_fungsi', TRUE));
    $label_fungsi     = html_escape($this->input->post('label_fungsi', TRUE));
    $url_fungsi       = html_escape($this->input->post('url_fungsi', TRUE));
    $deskripsi_fungsi = html_escape($this->input->post('deskripsi_fungsi', TRUE));
    $jenis_fungsi     = html_escape($this->input->post('jenis_fungsi', TRUE));
    $status           = html_escape($this->input->post('status', TRUE));

    $data = array(
      'nama_fungsi' => $this->db->escape_str($nama_fungsi),
      'label_fungsi' => $this->db->escape_str($label_fungsi),
      'url_fungsi' => $this->db->escape_str($url_fungsi),
      'deskripsi_fungsi' => $this->db->escape_str($deskripsi_fungsi),
      'id_jenis_fungsi' => $this->db->escape_str($jenis_fungsi),
      'create_by' => $this->db->escape_str($create_by),
      'create_date' => $this->db->escape_str($create_date),
      'create_ip' => $this->db->escape_str($create_ip),
      'mod_by' => $this->db->escape_str($create_by),
      'mod_date' => $this->db->escape_str($create_date),
      'mod_ip' => $this->db->escape_str($create_ip),
      'id_status' => $this->db->escape_str($status),
    );

    /*query insert*/
    $this->db->insert('xi_sa_fungsi', $data);
    return TRUE;
  }

	/* Fungsi untuk update data */
  public function updateDataFungsi()
  {
    //get data
    $create_by        = $this->app_loader->current_account();
    $create_date      = date('Y-m-d H:i:s');
    $create_ip        = $this->input->ip_address();

		$id_fungsi				= html_escape($this->input->post('fungsi', TRUE));
    $nama_fungsi      = html_escape($this->input->post('nama_fungsi', TRUE));
    $label_fungsi     = html_escape($this->input->post('label_fungsi', TRUE));
    $url_fungsi       = html_escape($this->input->post('url_fungsi', TRUE));
    $deskripsi_fungsi = html_escape($this->input->post('deskripsi_fungsi', TRUE));
    $jenis_fungsi     = html_escape($this->input->post('jenis_fungsi', TRUE));
    $status           = html_escape($this->input->post('status', TRUE));

    $data = array(
	    'nama_fungsi' => $this->db->escape_str($nama_fungsi),
	    'label_fungsi' => $this->db->escape_str($label_fungsi),
	    'url_fungsi' => $this->db->escape_str($url_fungsi),
	    'deskripsi_fungsi' => $this->db->escape_str($deskripsi_fungsi),
	    'id_jenis_fungsi' => $this->db->escape_str($jenis_fungsi),
	    'mod_by' => $this->db->escape_str($create_by),
	    'mod_date' => $this->db->escape_str($create_date),
	    'mod_ip' => $this->db->escape_str($create_ip),
	    'id_status' => $this->db->escape_str($status),
	  );

		//cek nama fungsi biar tidak terjadi duplikat data
		$this->db->where('id_fungsi <>', abs($id_fungsi));
		$this->db->where('nama_fungsi', $this->db->escape_str($nama_fungsi));
		$count = $this->db->count_all_results('xi_sa_fungsi');
		if($count > 0)
			return FALSE;
		else {
			/*query update*/
			$this->db->where('id_fungsi', abs($id_fungsi));
			$this->db->update('xi_sa_fungsi', $data);
			return TRUE;
		}
  }

	public function deleteDataFungsi()
	{
		$fungsi = $this->input->post('checkid', TRUE);
		//jika ingin menghapus data lakukan looping
		$i=0; $j=0;
		foreach ($fungsi as $key => $id) {
			//cek jika fungsi digunakan atau tidak
			$this->db->where('id_fungsi', abs($id));
			$count = $this->db->count_all_results('xi_sa_rules');
			if($count == 0) {
				/*query delete*/
				$this->db->where('id_fungsi', abs($id));
				$this->db->delete('xi_sa_fungsi');
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
