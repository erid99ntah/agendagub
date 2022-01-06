<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of model agenda
 *
 * @author Diskominfo Sumbar
 */

class Model_disposisi extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}
	
	public function getListDisposisiKeluar($id_group)
	{
		$this->db->select('a.id_disposisi, a.token, a.id_agenda, a.isi_disposisi, a.tgl_disposisi, a.id_pengirim,
						   a.id_opd,b.nama_agenda, b.tanggal');
        $this->db->from('data_disposisi a'); 
        $this->db->join('data_agenda b', 'b.id_agenda = a.id_agenda', 'INNER');
        if ($id_group!=='') {
        	if ($id_group=='PIM')
        		$this->db->where('b.jenis_agenda', 'P');
        	else
        		$this->db->where('b.jenis_agenda', 'S');
        }
       
        $data = $this->db->get();
        return $data->result_array();
	}

	public function getDetailDraft($token)
	{
		$this->db->select('a.id_agenda, a.token,a.jenis_agenda, a.nama_agenda,a.status_disposisi, a.tanggal,
						   a.penerima,a.id_status, a.status_verifikasi, a.jam_mulai, a.jam_selesai, 
						   a.kegiatan, a.lokasi_kegiatan, a.dokumen, a.keterangan, a.create_date, b.nm_status');
        $this->db->from('data_agenda a');
        $this->db->join('master_status b',      'b.id_status 	= a.status_verifikasi');
       // $this->db->where('a.status_verifikasi', 'SM');
        $this->db->where('a.token', $token);

        $data = $this->db->get();
        return $data->row_array();
	}

	
	public function getIdOpdByUserid($userid)
    {
        $this->db->select('id_opd, sub_opd');
        $this->db->from('xi_sa_users');
        $this->db->where('token', $userid);
        $data = $this->db->get();

        return $data->row_array();
    }

    public function cekUserByUserID($userid)
    {
        $this->db->select('id_users');
        $this->db->from('xi_sa_users');
        $this->db->where('token', $userid);
        $data = $this->db->get();

        return $data->row_array();
    }

    public function getListDisposisiMasukUserID($userid)
    {
		$this->db->select('a.id_disposisi_masuk, a.token, a.id_disposisi, a.id_penerima, a.tgl_terima, a.status_penerima,
						  a.pesan_penerima, b.id_agenda, b.tgl_disposisi, b.isi_disposisi, a.id_opd, b.id_pengirim,
						  b.jenis_disposisi, c.fullname ');
		$this->db->from('data_disposisi_masuk a');
		$this->db->join('data_disposisi b', 'b.id_disposisi = a.id_disposisi', 'INNER');
		$this->db->join('xi_sa_users c', 'b.token = b.id_pengirim', 'LEFT');
		$this->db->where('a.id_penerima', $userid);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getDetailDisposisiMasuk($token)
    {
		$this->db->select('a.id_disposisi_masuk, a.token, a.id_disposisi, a.id_penerima, a.tgl_terima, a.status_penerima,
						  a.pesan_penerima, b.id_agenda, b.tgl_disposisi, b.isi_disposisi, a.id_opd, b.id_pengirim,
						  b.jenis_disposisi, c.fullname ');
		$this->db->from('data_disposisi_masuk a');
		$this->db->join('data_disposisi b', 'b.id_disposisi = a.id_disposisi', 'INNER');
		$this->db->join('xi_sa_users c', 'b.token = b.id_pengirim', 'LEFT');
		$this->db->where('a.token', $token);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function updateDisposisiMasuk($token)
	{
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

// This is the end of agenda model
