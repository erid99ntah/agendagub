<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of model agenda
 *
 * @author Diskominfo Sumbar
 */

class Model_agenda extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue()
	{
		$this->form_validation->set_rules('nama_agenda',   'Nama Agenda',  'trim|required|min_length[3]');
		$this->form_validation->set_rules('jenis_agenda',   'Jenis Agenda', 'required|trim');
		$this->form_validation->set_rules('penerima', 		'Penerima', 	'required|trim');
		$this->form_validation->set_rules('tanggal', 	    'Tanggal',      'required|valid_date');
		$this->form_validation->set_rules('jam_mulai', 	    'Jam Mulai',    'required');
		$this->form_validation->set_rules('jam_selesai', 	'Jam Selesai',  'required');
		$this->form_validation->set_rules('kegiatan',       'Kegiatan',      'required|trim');
		$this->form_validation->set_rules('lokasi_kegiatan','Lokasi Kegiatan',      'required|trim');
		validation_message_setting();
		if ($this->form_validation->run() == FALSE)
			return false;
		else
			return true;
	}

	var $search = array('a.nama_agenda', 'a.tanggal', 'a.kegiatan', 'a.lokasi_kegiatan');
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
		$hadir=array('SH', 'SW');
		$this->db->where('a.status_verifikasi', 'CC');
		$this->db->where_in('a.id_status', $hadir);
		
		return $this->db->count_all_results('data_agenda a');
	}

	private function _get_datatables_query($param)
	{	  		
		$token = $this->app_loader->current_user();
		$hadir=array('SH', 'SW');
		$post = array();
		if (is_array($param)) {
			foreach ($param as $v) {
				$post[$v['name']] = $v['value'];
			}
		}

		$this->db->select('a.id_agenda, a.token,a.jenis_agenda, a.nama_agenda,a.status_disposisi, a.tanggal,
			a.penerima, a.status_verifikasi,a.id_status, a.jam_mulai, a.jam_selesai, a.kegiatan, a.lokasi_kegiatan, b.nm_status');
		$this->db->from('data_agenda a');        
		$this->db->join('master_status b',      'b.id_status = a.status_verifikasi', 'INNER');
		
		$this->db->where_in('a.id_status', $hadir);
	        //$this->db->where('a.penerima', $token);
		if ($this->app_loader->is_pimpinan() || $this->app_loader->is_ajudan()) {
			$this->db->where('a.jenis_agenda', 'P');
		}

		if ($this->app_loader->is_sekretaris()) {
			$this->db->where('a.jenis_agenda', 'S');
		}

		if(isset($post['jenis_agenda']) AND $post['jenis_agenda'] != '')
			$this->db->where('a.jenis_agenda', $post['jenis_agenda']);

		if(isset($post['status']) AND $post['status'] != '')
			$this->db->where('a.id_status', $post['status']);

		if(isset($post['tanggal']) AND $post['tanggal'] != '')
			$this->db->where('a.tanggal', $post['tanggal']);
		
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
	  $this->db->group_by('a.id_agenda');
	  $this->db->order_by('a.tanggal DESC');
	}

	public function getDetailAgenda($token)
	{
		$this->db->select('a.id_agenda, a.token,a.jenis_agenda, a.nama_agenda,a.status_disposisi, a.tanggal,
			a.penerima, a.dokumen, a.jam_mulai, a.jam_selesai, a.kegiatan, a.lokasi_kegiatan,
			a.keterangan, a.create_date,a.id_status, b.nm_status');
		$this->db->from('data_agenda a');
		$this->db->join('master_status b',  'b.id_status = a.id_status', 'INNER');
		$this->db->where('token', escape($token));
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function getStatusAgenda($id_status)
	{
		$this->db->select('nm_status');
		$this->db->from('master_status');
		$this->db->where('id_status', $id_status);
		$query = $this->db->get();

		return $query->row_array()['nm_status'];
	}

	public function getDisposisiByAgenda($id_agenda){
		$this->db->select('a.id_disposisi, a.token, a.tgl_disposisi, isi_disposisi, a.id_pengirim, b.fullname');
		$this->db->from('data_disposisi a');
		$this->db->join('xi_sa_users b', 'b.token = a.id_pengirim', 'INNER');
		$this->db->where('a.id_agenda', $id_agenda);
		$query = $this->db->get();
		return $query->result_array();
	}

	
}

// This is the end of agenda model
