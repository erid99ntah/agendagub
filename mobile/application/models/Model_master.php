<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of model agenda
 *
 * @author Diskominfo Sumbar
 */

class Model_master extends CI_Model
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

	public function getIdOpdByUserid($userid)
    {
        $this->db->select('id_opd, sub_opd');
        $this->db->from('xi_sa_users');
        $this->db->where('token', $userid);
        $data = $this->db->get();

        return $data->row_array();
    }

    public function getDetailAgendaById($id_agenda)
    {
    	$this->db->select('a.id_agenda, a.token,a.jenis_agenda, a.nama_agenda,a.status_disposisi, a.tanggal,
						   a.penerima, a.dokumen, a.jam_mulai, a.jam_selesai, a.kegiatan, a.lokasi_kegiatan,
						   a.keterangan, a.status_verifikasi, a.create_date,a.id_status, b.nm_status');
        $this->db->from('data_agenda a');
        $this->db->join('master_status b',  'b.id_status = a.id_status', 'INNER');
        $this->db->where('a.id_agenda', escape($id_agenda));
        $this->db->limit(1);
        $detail = $this->db->get();
        return $detail->row_array();
	}

	public function arrayDetailAgenda($id_agenda)
	{
		$detail = $this->getDetailAgendaById($id_agenda);
		$out='';

		  	 if ($detail['status_verifikasi']=='SM')
             	$status_verifikasi=$detail['nm_status'];
             elseif($detail['status_verifikasi']=='CC')
                $status_verifikasi=$detail['nm_status'];
             else
                    $status_verifikasi=$detail['nm_status'];

            $cekStatusAgenda = $this->getStatusAgenda($detail['id_status']);

           $year = substr($detail['create_date'],0,4);
           $month = substr($detail['create_date'],5,2); 
           $fileDokumen =base_url('./../images/agenda/'.$year.'/'.$month.'/'.$detail['dokumen']);

           //if($detail['dokumen']!='' && file_exists($fileDokumen)){
           if($detail['dokumen']!=''){
                $url=$fileDokumen;
           }
           else{
                $url='File Not Found';
           }

           $out=array('token'           =>$detail['token'],
                    'nama_agenda'       =>$detail['nama_agenda'],
                    'jenis_agenda'      =>$detail['jenis_agenda'],
                    'tanggal'           =>$detail['tanggal'],
                    'jam_mulai'         =>$detail['jam_mulai'],
                    'jam_selesai'       =>$detail['jam_selesai'],
                    'kegiatan'          =>$detail['kegiatan'],
                    'lokasi_kegiatan'   =>$detail['lokasi_kegiatan'],
                    'status_verifikasi' =>$detail['status_verifikasi'],
                    'nm_status_verifikasi' =>$status_verifikasi,
                    'id_status'         =>$detail['id_status'],
                    'status_agenda'     =>$cekStatusAgenda,
                    'dokumen'           =>$url,
                    'keterangan'        =>$detail['keterangan']
                    );
		return $out;
    }	

    public function  arrayPenerimaDisposisi($id_disposisi)
    {
    	$this->db->select('a.id_disposisi_masuk, a.token,a.id_disposisi, a.id_penerima, a.id_opd, a.tgl_terima, 
    					   a.status_penerima, a.pesan_penerima,
    					   a.status_disposisi,
    				       b.fullname as nama');
		$this->db->from('data_disposisi_masuk a');
		$this->db->join('xi_sa_users b', 'b.token = a.id_penerima', 'LEFT');
		$this->db->where('a.id_disposisi', $id_disposisi);
		$data = $this->db->get();

		$list=array();

		foreach ($data->result_array() as $key => $dp) 
		{
            if ($dp['status_penerima']=='BD') {
                $status_baca='Belum Dibaca';
            }
            else{
                   $status_baca='Sudah Dibaca';   
            }
			$i=array('id_disposisi_masuk'=>$dp['id_disposisi_masuk'],
                    'token'       =>$dp['token'],
                    'id_disposisi'       =>$dp['id_disposisi'],
                    'id_penerima'        =>$dp['id_penerima'],
                    'nama_penerima'      =>$dp['nama'],
                    'id_opd'       		 =>$dp['id_opd'],
                    'tgl_terima'         =>$dp['tgl_terima'],
                    'status_penerima'    =>$dp['status_penerima'],
                    'pesan_penerima'     =>$dp['pesan_penerima'],
                    'status_baca'     =>$status_baca,
                    'status_disposisi'   =>$dp['status_disposisi']
                    );	
             array_push($list, $i);	
		}

		return $list;
    }

    public function cekDisposisiByAgendaID($id_agenda)
    {
        $this->db->select('id_disposisi');
        $this->db->from('data_disposisi');
        $this->db->where('id_agenda', $id_agenda);

        $data = $this->db->get();
        return $data->row_array();
    }

    public function getUsersProfileByToken($token)
    {
        $this->db->select('token,fullname, id_opd,nm_opd, sub_opd, nm_sub_opd');
        $this->db->from('xi_sa_users');
        $this->db->where('token', $token);

        $data = $this->db->get();
        return $data->row_array();      
    }

    public function getUsersProfileByUsername($username)
    {
        $this->db->select('token, fullname, id_opd,nm_opd, sub_opd, nm_sub_opd');
        $this->db->from('xi_sa_users');
        $this->db->where('username', $username);

        $data = $this->db->get();
        return $data->row_array();      
    }

    public function insertNotification($token_agenda, $token_disposisi, $id_user, $id_penerima, $tipe_notifikasi, $pesan_notifikasi)
    { 
        $create_by    = $this->getUserUsernameByID($id_user);
        $create_date  = gmdate('Y-m-d H:i:s', time()+60*60*7);
        $create_ip    = $this->input->ip_address();
        $id_status='0';
        $token_notifikasi = generateToken($token_agenda, $create_date);
        
        $data = array(
          'token_notifikasi' => $token_notifikasi,
          'token_agenda'     => escape($token_agenda),
          'token_disposisi'  => $token_disposisi,
          'id_pengirim'      => $id_user,
          'id_penerima'      => $id_penerima,
          'tipe_notifikasi'  => $tipe_notifikasi,
          'pesan_notifikasi' => $pesan_notifikasi,
          'id_status'        => $id_status,
          'create_by'        => $create_by,
          'create_date'      => $create_date,
          'create_ip'        => $create_ip,
          'mod_by'           => '',
          'mod_date'         => '',
          'mod_ip'           => ''
        );
        $this->db->insert('data_notifikasi', $data);
        return TRUE;
   }

   public function getDeviceIdUser($id_user)
   {
      $this->db->select('device_id');
      $this->db->from('xi_sa_log_mobile');
      $this->db->where('id_user', $id_user);
      $this->db->where('status', '1');
      $this->db->limit(1);

      $data = $this->db->get();

      return $data->row_array()['device_id'];
   }

   public function getDeviceIdAllUsers($id_user)
   {
      $this->db->select('GROUP_CONCAT(device_id SEPARATOR ";;") as regid');
      $this->db->from('xi_sa_log_mobile');
      $this->db->where_in('id_user', $id_user);
      $this->db->where('status', '1');
      $this->db->limit(1);

      $data = $this->db->get();

      return $data->row_array()['regid'];
   }


   public function sendNotification($reg_ids, $items=array()) {
        
        $regIds = ($reg_ids != '') ? explode(';;', $reg_ids) : array();

        $fields = array(
            'registration_ids' => $regIds,
            'data' => $items,
        );
        return $this->sendPushNotification($fields);
    }
    
   
    private function sendPushNotification($fields) 
    {
      //define("FCM_KEY_APISS", "AAAAJsjGhF4:APA91bFGj9JPtESFyIjLqbIjknRKD3ty6lU_TpbntdWj1tgr4LFjkNTitohOKVvczg9jNJvdlfSQhI9aJufut6RFMoo7hURtykytvwC3SfmFbVu9b7Nx7iGXrJUDIng-no7BAxzebR1T"); //diisi key server fcm
      //define("FBS_API_URL", "https://fcm.googleapis.com/fcm/send");    
      $test='AAAAJsjGhF4:APA91bFGj9JPtESFyIjLqbIjknRKD3ty6lU_TpbntdWj1tgr4LFjkNTitohOKVvczg9jNJvdlfSQhI9aJufut6RFMoo7hURtykytvwC3SfmFbVu9b7Nx7iGXrJUDIng-no7BAxzebR1T';
        $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = array(
            'Authorization: key=' .$test,
            'Content-Type: application/json'
        );
 
      $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            //die('FCM Send Error : ' . curl_error($ch));
          $res=false;
        }else{
          $res=true;
        }
 
        curl_close($ch);
        return $res;
    }

    public function getUserFullname($token)
    {
      $this->db->select('fullname');
      $this->db->from('xi_sa_users');
      $this->db->where('token', $token);
      $query = $this->db->get();

      return $query->row_array()['fullname'];
    }

    public function getUserFullnameByUsername($username)
    {
      $this->db->select('fullname');
      $this->db->from('xi_sa_users');
      $this->db->where('username', $username);
      $query = $this->db->get();

      return $query->row_array()['fullname'];
    }

    public function getUserUsernameByID($id_user)
    {
      $this->db->select('username');
      $this->db->from('xi_sa_users');
      $this->db->where('token', $id_user);
      $query = $this->db->get();

      return $query->row_array()['username'];
    }
}

// This is the end of agenda model
