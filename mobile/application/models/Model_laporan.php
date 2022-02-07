<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of model laporan
 *
 * @author Diskominfo Sumbar
 */

class Model_laporan extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue()
	{
		$this->form_validation->set_rules('tanggal', 	    'Tanggal',      'required');
		$this->form_validation->set_rules('jenis_agenda', 	    'Jenis Agenda',      'required');
		$this->form_validation->set_rules('penerima', 	    'Penerima',      'required');
		validation_message_setting();
		if ($this->form_validation->run() == FALSE)
			return false;
		else
			return true;
	}

	public function getDataPenerimaNew()
	{	
		$arr=array(1, 88);
			$this->db->where('id_opd ', 1);
			$this->db->where_not_in('id_users ', $arr);
			$this->db->order_by('id_users ASC');
			$query = $this->db->get('xi_sa_users');
	    
	    if ($query->num_rows() > 0) {
	      foreach ($query->result_array() as $row) {
	        $dd_prov[$row['token']] = $row['fullname'];
	      }
	    }
	    return $dd_prov;
	}
	
	public function cekAgenda($tanggal, $jenis_agenda, $penerima)
	{
		//$this->db->where('tanggal', $tanggal);
		$this->db->where('jenis_agenda', $jenis_agenda);		
		$this->db->where('penerima', $penerima);		
		$this->db->where('id_status', 'SH');
		
		return $this->db->count_all_results('data_agenda');
	}

	
	public function getDataAgenda($tanggal, $jenis_agenda, $penerima)
	{	
		$stats= array('SH', 'SW');

		$this->db->select('a.id_agenda, a.token,a.jenis_agenda, a.nama_agenda,a.status_disposisi, a.tanggal,
			a.penerima, a.dokumen, a.jam_mulai, a.jam_selesai, a.kegiatan, a.lokasi_kegiatan, a.penyelenggara, a.cp,
			a.keterangan, a.create_date,a.id_status, a.create_by, b.nm_status');
		$this->db->from('data_agenda a');
		$this->db->join('master_status b',  'b.id_status = a.id_status', 'INNER');
		$this->db->where('a.tanggal', escape($tanggal));
		$this->db->where('a.jenis_agenda', escape($jenis_agenda));
		$this->db->where('a.penerima', escape($penerima));		
		$this->db->where_in('a.id_status', $stats);	
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getStatusAgenda($id_status)
	{
		$this->db->select('nm_status');
		$this->db->from('master_status');
		$this->db->where('id_status', $id_status);
		$query = $this->db->get();

		return $query->row_array()['nm_status'];
	}

	public function getNamaUserByToken($token)
	{
		$this->db->select('fullname');
		$this->db->from('xi_sa_users');
		$this->db->where('token', $token);
		$this->db->limit(1);
		$query = $this->db->get();

		return $query->row_array()['fullname'];
	}
	
}

// This is the end of agenda model
