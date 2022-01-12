<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of identitas model
 *
 * @author kominfo
 */

class Model_identitas extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

  public function validasiDataValue($role)
	{
		
	  $this->form_validation->set_rules('pengelola',       'Nama pengelola',  'required|trim');
    $this->form_validation->set_rules('judul',           'Judul',           'required|trim');
    $this->form_validation->set_rules('subjudul',        'Sub Judul',       'required|trim');
    $this->form_validation->set_rules('renstra_tahun',   'Renstra Tahun',   'required|trim');
    $this->form_validation->set_rules('renstra_tahun_sd',   'Renstra Tahun SD',   'required|trim');
    $this->form_validation->set_rules('tw1',             'TW1',   'required|trim');
    $this->form_validation->set_rules('tw2',             'TW2',   'required|trim');
    $this->form_validation->set_rules('tw3',             'TW3',   'required|trim');
    $this->form_validation->set_rules('tw4',             'TW4',   'required|trim');

    validation_message_setting();
    if ($this->form_validation->run() == FALSE)
      return false;
    else
      return true;
	}


	/*Fungsi get data edit by id dan url*/
	public function editDataidentitas()
	{
		$this->db->select('*');
    $this->db->from('identitas');
    $this->db->where('id_identitas', abs(1));
		$this->db->limit(1);

    $query = $this->db->get();

    return $query;
	}
  
	/* Fungsi untuk update data */
  public function updateDataidentitas()
  {
    //get data
    $create_by      		= $this->app_loader->current_account();
    $create_date    		= date('Y-m-d H:i:s');
    $create_ip      		= $this->input->ip_address();

		$id_identitas				= html_escape($this->input->post('identitas', TRUE));
    $pengelola				  = html_escape($this->input->post('pengelola', TRUE));
    $judul  		        = html_escape($this->input->post('judul', TRUE));
    $subjudul    		    = html_escape($this->input->post('subjudul', TRUE));
		$phone 	            = html_escape($this->input->post('phone', TRUE));
    $email              = html_escape($this->input->post('email', TRUE));
    $renstra_tahun      = html_escape($this->input->post('renstra_tahun', TRUE));
    $renstra_tahun_sd   = html_escape($this->input->post('renstra_tahun_sd', TRUE));
    $tw1                = html_escape($this->input->post('tw1', TRUE));
    $tw2                = html_escape($this->input->post('tw2', TRUE));
    $tw3                = html_escape($this->input->post('tw3', TRUE));
    $tw4         		    = html_escape($this->input->post('tw4', TRUE));

    $data = array(
      'pengelola'  => $this->db->escape_str($pengelola),
      'judul'      => $this->db->escape_str($judul),
      'subjudul'   => $this->db->escape_str($subjudul),
			'phone'      => $this->db->escape_str($phone),
      'email'      => $this->db->escape_str($email),
      'renstra_tahun' => $this->db->escape_str($renstra_tahun),
      'renstra_tahun_sd' => $this->db->escape_str($renstra_tahun_sd),
      'tw1' => $this->db->escape_str($tw1),
      'tw2' => $this->db->escape_str($tw2),
      'tw3' => $this->db->escape_str($tw3),
      'tw4' => $this->db->escape_str($tw4),
      'mod_by'    => $this->db->escape_str($create_by),
      'mod_date'  => $this->db->escape_str($create_date),
      'mod_ip'    => $this->db->escape_str($create_ip)
    );

		//cek nama fungsi biar tidak terjadi duplikat data
		$this->db->where('id_identitas <>', abs($id_identitas));
		$count = $this->db->count_all_results('identitas');
		if($count > 0)
			return FALSE;
		else {
			/*query update*/
			$this->db->where('id_identitas', abs($id_identitas));
			$this->db->update('identitas', $data);
			return TRUE;
		}
  }

	
}

// This is the end of auth signin model
