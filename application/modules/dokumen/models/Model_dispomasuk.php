<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of model disposisi masuk
 *
 * @author Diskominfo Sumbar
 */

class Model_dispomasuk extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
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
		$token = $this->app_loader->current_user();
		if (!$this->app_loader->is_admin()) {
			$this->db->where('id_penerima', $token);
		}
		return $this->db->count_all_results('data_disposisi_masuk');
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

		$this->db->select('a.id_disposisi,a.id_agenda, a.isi_disposisi, a.tgl_disposisi, a.id_pengirim,
		                   a.jenis_disposisi, b.id_penerima, b.tgl_terima, b.status_penerima, b.status_disposisi, b.token');
		$this->db->from('data_disposisi a');        
		$this->db->join('data_disposisi_masuk b', 'b.id_disposisi = a.id_disposisi', 'INNER');
		if (!$this->app_loader->is_admin()) {
			$this->db->where('b.id_penerima', $token);
		}

		if(isset($post['status']) AND $post['status'] != '')
			$this->db->where('b.status_penerima', $post['status']);

		if(isset($post['tanggal']) AND $post['tanggal'] != '')
			$this->db->where('a.tgl_disposisi', $post['tanggal']);


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
	  $this->db->order_by('id_disposisi DESC');
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

	public function getDisposisiByAgenda($id_agenda)
	{
		$this->db->select('a.*, b.fullname');
		$this->db->from('data_disposisi a');
		$this->db->join('xi_sa_users b', 'b.token = a.id_penerima', 'INNER');
		$this->db->where('a.id_agenda', $id_agenda);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getUserFullname($token){
		$this->db->select('fullname');
		$this->db->from('xi_sa_users');
		$this->db->where('token', $token);
		$query = $this->db->get();

		return $query->row_array()['fullname'];
	}

	public function getDetailDisposisiMasuk($token)
	{
		$this->db->select('a.id_disposisi_masuk, a.token, a.id_disposisi, a.id_penerima, a.tgl_terima, a.status_penerima,
						  a.pesan_penerima, b.id_agenda, b.tgl_disposisi, b.isi_disposisi, a.id_opd, b.id_pengirim,
						  b.jenis_disposisi, c.fullname ');
		$this->db->from('data_disposisi_masuk a');
		$this->db->join('data_disposisi b', 'b.id_disposisi = a.id_disposisi', 'INNER');
		$this->db->join('xi_sa_users c', 'c.token = b.id_pengirim', 'LEFT');
		$this->db->where('a.token', $token);
		$query = $this->db->get();

		if ($query->row_array()['tgl_terima']=='0000-00-00 00:00:00') {
			$this->updateDisposisiMasuk($token);	
		}

		return $query->row_array();	
	}

	public function updateDisposisiMasuk($token)
	{
		$create_by    = $this->app_loader->current_account();
		$create_date  = gmdate('Y-m-d H:i:s', time()+60*60*7);
		$create_ip    = $this->input->ip_address();

		$terima="Siap";
		$status_penerima='SD';
		$data = array(				
					'tgl_terima'	  => escape($create_date),				
					'status_penerima' => escape($status_penerima),
					'pesan_penerima'  => escape($terima)
					);
	         
		$this->db->where('token', $token);
		$this->db->update('data_disposisi_masuk', $data);
	}
}

// This is the end of disposisi masuk model
