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

        public function getStatusAgenda($id_status)
        {
                $this->db->select('nm_status');
                $this->db->from('master_status');
                $this->db->where('id_status', $id_status);
                $query = $this->db->get();

                return $query->row_array()['nm_status'];
        }

        public function getListDataAgenda($tanggal, $status_agenda, $penerima, $jenis_agenda)
        {	
            $stats =array('SH', 'SW');
                $this->db->select('a.id_agenda, a.token,a.jenis_agenda, a.nama_agenda,a.status_disposisi, a.tanggal,
                   a.penerima,a.id_status, a.status_verifikasi, a.jam_mulai, a.jam_selesai, 
                   a.kegiatan, a.lokasi_kegiatan, a.dokumen, a.keterangan, a.create_date,
                   a.penyelenggara, a.cp, b.nm_status');
                $this->db->from('data_agenda a');
                $this->db->join('master_status b',    'b.id_status = a.status_verifikasi', 'INNER');                
                $this->db->where('a.jenis_agenda',  $jenis_agenda);
                $this->db->where_in('a.id_status', $stats);

                if ($penerima!='') {
                        $this->db->where('a.penerima',  $penerima);
                }
                if ($status_agenda!='') {
                        $this->db->where('a.id_status', $status_agenda);
                }
                if ($tanggal!='') {
                        $this->db->where('a.tanggal', $tanggal);
                }
                $this->db->group_by('a.id_agenda');
                $this->db->order_by('a.id_agenda DESC');
                $data = $this->db->get();
                return $data->result_array();
        }

        public function getDetailAgenda($token)
        {       
                $status_agenda=array('SH', 'SW');

                $this->db->select('id_agenda,token,jenis_agenda,nama_agenda,status_disposisi, tanggal,
                 penerima,id_status,status_verifikasi, jam_mulai, jam_selesai, 
                 kegiatan, lokasi_kegiatan, dokumen, keterangan,create_date, penyelenggara, cp');
                $this->db->from('data_agenda');                
                $this->db->where('token', $token);
                $this->db->where_in('id_status', $status_agenda);

                $data = $this->db->get();
                return $data->row_array();
        }

	
}

// This is the end of agenda model
