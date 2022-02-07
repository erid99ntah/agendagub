<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of model odp
 *
 * @author Yogi "solop" Kaputra
 */

class Model_master extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

  public function getDataListInstansi()
  {
    $this->db->where('id_status', 1);
    if(!$this->app_loader->is_admin()) 
    {
      $id_opd = $this->app_loader->current_opd();
      $this->db->where('id_opd', $id_opd);
    }    
    $this->db->order_by('id_opd ASC');
    $query = $this->db->get('master_opd');

      $dd_instansi['']='Pilih OPD';
      if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
          $dd_instansi[$row->id_opd] = $row->nm_opd;
        }
      }
      return $dd_instansi;
  }

  public function getNamaOpd($id_opd)
  {
    $this->db->select('nm_opd');
    $this->db->from('master_opd');
    $this->db->where('id_opd', $id_opd);
    $this->db->limit(1);
    $query = $this->db->get();
    if ($query->num_rows() > 0) 
      return $query->row()->nm_opd;
    else
      return 0;
  }

  public function getInstansiAll()
  {     
        if(!$this->app_loader->is_admin()) 
        {
          $id_opd = $this->app_loader->current_opd();
          $child_ins   = $id_opd;
        } 
        else
        {
          $id_opd      = 0;
          $child_ins   = 1;  
        }
        
        return $this->getInstansiParent($id_opd, $child_ins);
  }

  public function getInstansiParent($id_opd, $child_ins)
  {
        $tampil = "";

        $this->db->where('id_status', 1);
        if(!$this->app_loader->is_admin()) 
        {
          $id_opd = $this->app_loader->current_opd();
          $this->db->where('id_opd', $id_opd);
        } 
        else
        {
          $this->db->where('parent_id', 0);
        }   
        
        $this->db->order_by('id_opd ASC');
        $data_parent = $this->db->get('master_opd');


        if($data_parent->num_rows() > 0)
        { 
            foreach ($data_parent->result() as $data_parent) 
            {
              if($data_parent->id_opd == $child_ins)
                  $pilih = "selected";
              else
                  $pilih = "";
              
              $tampil .= '<option value="'.$data_parent->id_opd.'" '.$pilih.'>&#8866; '.$data_parent->nm_opd.'</option>';

              $this->db->select('id_opd');
              $this->db->where('parent_id', $id_opd);
              $this->db->order_by('id_opd ASC');
              $cekChild = $this->db->get('master_opd');

              if($cekChild->num_rows() > 0)
                $tampil .= $this->getInstansiChild($data_parent->id_opd, $child_ins, 1);

            }
        }

        return $tampil;
    }

    public function getInstansiChild($parent_id, $child_id, $number)
    {
        $child = "";

        $this->db->where('id_status', 1);
        if(!$this->app_loader->is_admin()) 
        {
          $id_opd = $this->app_loader->current_opd();
          $this->db->where('id_opd', $id_opd);
        }    
        $this->db->where('parent_id', $parent_id);
        $this->db->order_by('id_opd ASC');
        $data_child = $this->db->get('master_opd');


        $spasi = "";
        $nomor = $number + 1;

        for ($i = 1; $i < $nomor; $i++) {
            $spasi .= "&mdash;";
        }

        foreach ($data_child->result() as $key) {
            if($key->id_opd == $child_id)
                $pilih = "selected";
            else
                $pilih = "";

            $child .= '<option value="'.$key->id_opd.'" '.$pilih.'>&#8866;'.$spasi.' '.$key->nm_opd.'</option>';

            $this->db->select('id_opd');
            $this->db->order_by('id_opd ASC');
            $cekChild = $this->db->get('master_opd');

            if($cekChild->num_rows() > 0)               
                $child .= $this->getInstansiChild($key->id_opd, $child_id, $nomor);
        }

        return $child;
    }

    public function getIdOpdByUserid($userid)
    {
        $this->db->select('id_opd, sub_opd');
        $this->db->from('xi_sa_users');
        $this->db->where('token', $userid);
        $data = $this->db->get();

        return $data->row_array();
    }

    public function getPenerimaDisposisi($id_disposisi)
    {
        $this->db->select('a.id_disposisi_masuk, a.token,a.id_disposisi, a.id_penerima, a.id_opd, a.tgl_terima, 
                           a.status_penerima, a.pesan_penerima,
                           a.status_disposisi,
                           b.fullname as nama');
        $this->db->from('data_disposisi_masuk a');
        $this->db->join('xi_sa_users b', 'b.token = a.id_penerima', 'LEFT');
        $this->db->where('a.id_disposisi', $id_disposisi);
        $data = $this->db->get();

        return $data->result_array();
    }

    public function getDisposisiByAgenda($id_agenda)
    {
      $this->db->select('a.id_disposisi, a.token, a.tgl_disposisi, isi_disposisi, a.id_pengirim, b.fullname');
      $this->db->from('data_disposisi a');
      $this->db->join('xi_sa_users b', 'b.token = a.id_pengirim', 'INNER');
      $this->db->where('a.id_agenda', $id_agenda);
      $query = $this->db->get();
      return $query->result_array();
    }

    public function getDetailAgendaByID($id_agenda)
    {
      $this->db->select('a.id_agenda, a.token,a.jenis_agenda, a.nama_agenda,a.status_disposisi, a.tanggal,
                 a.penerima, a.dokumen, a.jam_mulai, a.jam_selesai, a.kegiatan, a.lokasi_kegiatan,
                 a.keterangan, a.create_date,a.id_status, b.nm_status');
      $this->db->from('data_agenda a');
      $this->db->join('master_status b',  'b.id_status = a.id_status', 'INNER');
      $this->db->where('id_agenda', escape($id_agenda));
      $this->db->limit(1);
      $query = $this->db->get();
      return $query->row_array();
    }
    
    public function insertNotification($token_agenda, $token_disposisi, $id_pengirim, $id_penerima, $tipe_notifikasi, $pesan_notifikasi)
    { 
        $create_by    = $this->app_loader->current_account();
        $create_date  = gmdate('Y-m-d H:i:s', time()+60*60*7);
        $create_ip    = $this->input->ip_address();
        $id_status='0';
        $token_notifikasi = generateToken($token_agenda, $create_date);
        
        $data = array(
          'token_notifikasi' => $token_notifikasi,
          'token_agenda'     => escape($token_agenda),
          'token_disposisi'  => $token_disposisi,
          'id_pengirim'      => $id_pengirim,
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
    
   
    private function sendPushNotification($fields) {
        
        $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = array(
            'Authorization: key=' . FBS_API_KEY,
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

    public function getUserSekretaris()
    { 

      $this->db->select('id_users, token, fullname'); 
      
      $this->db->from('xi_sa_users');
      $this->db->limit(1);
      $query = $this->db->get();

      return $query->row_array();
    }

    public function getUserProfileByUsername($username)
    {
        $this->db->select('token, fullname');
        $this->db->from('xi_sa_users');
        $this->db->where('username', $username);
        $this->db->limit(1);
        $query = $this->db->get();

        return $query->row_array();
    }
}

// This is the end of auth signin model
