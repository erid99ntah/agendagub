<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of home model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_home extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getDataListNotification($limit, $offset)
	{
		$this->db->select('a.token,
											 a.sender_id,
											 a.recipient_id,
											 a.type,
											 a.parameters,
											 a.reference,
											 a.unread,
											 DATE_FORMAT(a.create_date, "%d/%m/%Y %h:%i %p") AS create_date,
											 b.fullname,
											 (CASE a.type
											 	WHEN "otg.new" THEN "verifikasi-kasus/kasus-otg"
												WHEN "odp.new" THEN "verifikasi-kasus/kasus-odp"
												WHEN "otg.verified" THEN "otg"
												WHEN "odp.verified" THEN "odp"
												WHEN "case.new" THEN "verifikasi-kasus/kasus"
												WHEN "case.ref" THEN CONCAT("konfirmasi-kasus/identifikasi/review/", a.parameters)
												WHEN "swab.new" THEN "spesimen/pengujian"
												WHEN "swab.result" THEN "konfirmasi-kasus/spesimen"
												WHEN "case.verified" THEN CONCAT("konfirmasi-kasus/identifikasi/review/", a.parameters)
												WHEN "data.new" THEN "rekapitulasi/daily"
												ELSE "home"
											 END) AS url');
		$this->db->from('ta_notification a');
		$this->db->join('xi_sa_users b', 'a.sender_id = b.username', 'inner');
		if(!$this->app_loader->is_admin()) {
			$this->db->where('a.recipient_id', $this->app_loader->current_account());
		}
		$this->db->order_by('a.create_date DESC');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getCountAllNotification()
	{
		if(!$this->app_loader->is_admin()) {
			$this->db->where('recipient_id', $this->app_loader->current_account());
		}
		return $this->db->count_all_results('ta_notification');
	}

	public function updateDataNotificationAll()
	{
		$create_by    = $this->app_loader->current_account();
		$create_date 	= gmdate('Y-m-d H:i:s', time()+60*60*7);
		$create_ip    = $this->input->ip_address();
		//update notifikasi
		$this->db->set('unread', 2);
		$this->db->set('mod_by', $create_by);
		$this->db->set('mod_date', $create_date);
		$this->db->set('mod_ip', $create_ip);
		$this->db->where('unread', 1);
		if(!$this->app_loader->is_admin()) {
			$this->db->where('recipient_id', $this->app_loader->current_account());
		}
		$this->db->update('ta_notification');
		return TRUE;
	}

	public function updateDataNotificationByToken($token)
	{
		$create_by    = $this->app_loader->current_account();
		$create_date 	= gmdate('Y-m-d H:i:s', time()+60*60*7);
		$create_ip    = $this->input->ip_address();
		//update notifikasi
		$this->db->set('unread', 2);
		$this->db->set('mod_by', $create_by);
		$this->db->set('mod_date', $create_date);
		$this->db->set('mod_ip', $create_ip);
		$this->db->where('token', $token);
		$this->db->where('unread', 1);
		if(!$this->app_loader->is_admin()) {
			$this->db->where('recipient_id', $this->app_loader->current_account());
		}
		$this->db->update('ta_notification');
		return TRUE;
	}

	public function deleteDataNotification()
	{
		$token = $this->input->post('checkid');
		foreach ($token as $key => $t) {
			$this->db->where('token', $t);
			$this->db->delete('ta_notification');
		}
		return TRUE;
	}


	public function countUsers(){
		$this->db->select('count(id_users) as jml');
		$this->db->from('xi_sa_users');		
		$this->db->limit(1);
		$data = $this->db->get();
		return $data->row_array()['jml'];
	}

	public function countCascading(){		 
	   return 0;	
	}

	public function countRenstra(){
		

		return 0;
	}


	/*public function getAgendaKetuaDprd($tgl){
		$this->db->select('a.id_agenda, a.token,a.jenis_agenda, a.nama_agenda,a.status_disposisi, a.tanggal,
							   a.penerima, a.status_verifikasi,a.id_status, a.jam_mulai, a.jam_selesai, a.kegiatan, a.lokasi_kegiatan, b.nm_status');
        $this->db->from('data_agenda a');        
        $this->db->join('master_status b',      'b.id_status = a.status_verifikasi', 'INNER');
        $this->db->where('a.jenis_agenda', 'P');
        $this->db->where_in('a.id_status', 'SH');
        $data = $this->db->get();

        $out='';
        $i=0;
        foreach ($data->result_array() as $key => $dl) {
        $i++;
        	$out .='<tr>';
        		$out.='<td>'.$i.'</td>';
        		$out.='<td><a data-toggle="tooltip" data-placement="left" title="Detail Draft Agenda" href="'.site_url('dokumen/agenda/review/'.$dl['token']).'/'.create_url($dl['nama_agenda']).'" 
							  class="tooltips"><i class="fa fa-edit"></i> '.$dl['nama_agenda'].'</a></td>';
        		$out.='<td>'.$dl['kegiatan'].'</td>';
        		$out.='<td>'.$dl['jam_mulai'].'</td>';
        		$out.='<td>'.$dl['jam_selesai'].'</td>';
        		$out.='<td>'.$dl['lokasi_kegiatan'].'</td>';
        	$out .='</tr>';
        }
        return $out;
	}

	public function getAgendaSekretaris($tgl){
		$this->db->select('a.id_agenda, a.token,a.jenis_agenda, a.nama_agenda,a.status_disposisi, a.tanggal,
							   a.penerima, a.status_verifikasi,a.id_status, a.jam_mulai, a.jam_selesai, a.kegiatan, a.lokasi_kegiatan, b.nm_status');
        $this->db->from('data_agenda a');        
        $this->db->join('master_status b',      'b.id_status = a.status_verifikasi', 'INNER');
        $this->db->where('a.jenis_agenda', 'S');
        $this->db->where_in('a.id_status', 'SH');
        $data = $this->db->get();

        $out='';
        $i=0;
        foreach ($data->result_array() as $key => $dl) {
        $i++;
        	$out .='<tr>';
        		$out.='<td>'.$i.'</td>';
        		$out.='<td><a data-toggle="tooltip" data-placement="left" title="Detail Draft Agenda" href="'.site_url('dokumen/agenda/review/'.$dl['token']).'/'.create_url($dl['nama_agenda']).'" 
							  class="tooltips"><i class="fa fa-edit"></i> '.$dl['nama_agenda'].'</a></td>';
        		$out.='<td>'.$dl['kegiatan'].'</td>';
        		$out.='<td>'.$dl['jam_mulai'].'</td>';
        		$out.='<td>'.$dl['jam_selesai'].'</td>';
        		$out.='<td>'.$dl['lokasi_kegiatan'].'</td>';
        	$out .='</tr>';
        }
        return $out;
	}*/

	public function getStatusAgenda($id_status)
    {
            $this->db->select('nm_status');
            $this->db->from('master_status');
            $this->db->where('id_status', $id_status);
            $query = $this->db->get();

            return $query->row_array()['nm_status'];
    }

	public function getDataListAgendaPimpinan($tgl)
	{	
		$list=array();
		$status=array('SH', 'SW');
		$this->db->select('a.id_agenda, a.token,a.jenis_agenda, a.nama_agenda,a.status_disposisi, a.tanggal,
							   a.penerima, a.status_verifikasi,a.id_status, a.jam_mulai, a.jam_selesai, a.kegiatan, a.lokasi_kegiatan, b.nm_status');
        $this->db->from('data_agenda a');        
        $this->db->join('master_status b',      'b.id_status = a.status_verifikasi', 'INNER');
        $this->db->where('a.jenis_agenda', 'P');
        $this->db->where_in('a.tanggal', $tgl);
        $this->db->where_in('a.id_status', $status);
        $data = $this->db->get();

        foreach ($data->result_array() as $key => $dd) 
        {
        	   $cekStatusAgenda = $this->getStatusAgenda($dd['id_status']);

        	   $i=array('token'             =>$dd['token'],
                        'nama_agenda'       =>$dd['nama_agenda'],
                        'jenis_agenda'      =>$dd['jenis_agenda'],
                        'tanggal'           =>tgl_indo($dd['tanggal']),
                        'jam_mulai'         =>$dd['jam_mulai'],
                        'jam_selesai'       =>$dd['jam_selesai'],
                        'kegiatan'          =>$dd['kegiatan'],
                        'lokasi_kegiatan'   =>$dd['lokasi_kegiatan'],
                        'status_verifikasi' =>$dd['status_verifikasi'],
                        'id_status'         =>$dd['id_status'],
                        'status_agenda'     =>$cekStatusAgenda,
                        );
               array_push($list, $i);
        }
        return $list;
	}

	public function getDataListAgendaSekretaris($tgl)
	{	
		$list=array();
		$status=array('SH', 'SW');	
		$this->db->select('a.id_agenda, a.token,a.jenis_agenda, a.nama_agenda,a.status_disposisi, a.tanggal,
							   a.penerima, a.status_verifikasi,a.id_status, a.jam_mulai, a.jam_selesai, a.kegiatan, a.lokasi_kegiatan, b.nm_status');
        $this->db->from('data_agenda a');        
        $this->db->join('master_status b',      'b.id_status = a.status_verifikasi', 'INNER');
        $this->db->where('a.jenis_agenda', 'S');
        $this->db->where_in('a.tanggal', $tgl);
        $this->db->where_in('a.id_status', $status);
        $data = $this->db->get();

        foreach ($data->result_array() as $key => $dd) 
        {
        	   $cekStatusAgenda = $this->getStatusAgenda($dd['id_status']);
        	   if ($dd['id_status']=='SM')
						$status_agenda='<label class="label label-warning">'.$cekStatusAgenda.'</label>';
					elseif($dd['status_verifikasi']=='CC')
						$status_agenda='<label class="label label-success">'.$cekStatusAgenda.'</label>';
					else
						$status_agenda='<label class="label label-danger">'.$cekStatusAgenda.'</label>';

        	   $i=array('token'             =>$dd['token'],
                        'nama_agenda'       =>$dd['nama_agenda'],
                        'jenis_agenda'      =>$dd['jenis_agenda'],
                        'tanggal'           =>tgl_indo($dd['tanggal']),
                        'jam_mulai'         =>$dd['jam_mulai'],
                        'jam_selesai'       =>$dd['jam_selesai'],
                        'kegiatan'          =>$dd['kegiatan'],
                        'lokasi_kegiatan'   =>$dd['lokasi_kegiatan'],
                        'status_verifikasi' =>$dd['status_verifikasi'],
                        'id_status'         =>$dd['id_status'],
                        'status_agenda'     =>$status_agenda,
                        );
               array_push($list, $i);
        }
        return $list;
	}

	public function getDataDispomasuk($tgl)
	{	
		$list=array();
		$id_penerima = $this->app_loader->current_user();

		$this->db->select('a.id_disposisi,a.id_agenda, a.id_opd,a.isi_disposisi, a.tgl_disposisi, a.id_pengirim,
		                   a.jenis_disposisi,  b.token, b.id_penerima, b.tgl_terima, b.status_penerima, b.pesan_penerima, b.status_disposisi, 
		                   b.token, c.tanggal, c.nama_agenda');
		$this->db->from('data_disposisi a');        
		$this->db->join('data_disposisi_masuk b', 'b.id_disposisi = a.id_disposisi', 'INNER');
		$this->db->join('data_agenda c', 'c.id_agenda = a.id_agenda', 'INNER');
		if (!$this->app_loader->is_admin()) {
			$this->db->where('b.id_penerima', $token);
		}

		$this->db->where('c.tanggal', $tgl);

		$data=$this->db->get();
		foreach ($data->result_array() as $key => $dd) {
                   
           $detail_user   	= $this->getUsersProfileByToken($dd['id_pengirim']);
           $detail_penerima  = $this->getUsersProfileByToken($dd['id_penerima']);

           $i=array('id_disposisi'      =>$dd['id_disposisi'],
                    'id_agenda'         =>$dd['id_agenda'],
                    'nama_agenda'         =>$dd['nama_agenda'],
                    'tanggal'         	=>tgl_indo($dd['tanggal']),
                    'tgl_disposisi'     =>tgl_indo($dd['tgl_disposisi']),
                    'isi_disposisi'     =>$dd['isi_disposisi'],
                    'id_pengirim'       =>$dd['id_pengirim'],
                    'nm_pengirim'       =>$detail_user['fullname'],
                    'id_opd'            =>$dd['id_opd'],
                    'token'             =>$dd['token'],
                    'tgl_terima'        =>tgl_indo($dd['tgl_terima']),
                    'penerima_disposisi'=>$detail_penerima['fullname'],
                    'status_penerima'   =>$dd['status_penerima'],
                    'status_baca'       =>convert_status_penerima($dd['status_penerima']),
                    'pesan_penerima'    =>$dd['pesan_penerima']                            
                    );
           array_push($list, $i);
        }

        return $list;
	}

	public function getUsersProfileByToken($token)
    {
        $this->db->select('token,fullname, id_opd,nm_opd, sub_opd, nm_sub_opd,
                           jns_jbtn_id, jns_jbtn_nm,jabatan_id,jabatan_nm,eselon_id,eselon_nm');
        $this->db->from('xi_sa_users');
        $this->db->where('token', $token);

        $data = $this->db->get();
        return $data->row_array();      
    }
}

// This is the end of auth signin model
