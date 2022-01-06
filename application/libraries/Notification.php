<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Aplikasi Loader Library
 * Library untuk mengambil session, generate menu dll
 * @author  Yogi Kaputra
 * @since   1.0
 */

class Notification
{
  public function __construct()
  {
    $this->CI =& get_instance();
    $this->CI->load->database();
  }

  private function getRegIdUserByToken($token_asn)
  {
    $this->CI->db->select('u.id_users, GROUP_CONCAT(f.fcm_regid SEPARATOR ";;") as regid');
    $this->CI->db->from('ms_pegawai p');
    $this->CI->db->join('xi_sa_users u', 'u.id_pegawai = p.id_pegawai', 'left');
    $this->CI->db->join('xi_sa_users_fcm f', 'f.id_users = u.id_users AND f.status = 1', 'left');
    $this->CI->db->where('p.token_ref', $token_asn);
    $this->CI->db->where('p.id_status', 1);
    $this->CI->db->group_by(array('u.id_users'));
    $this->CI->db->order_by('f.create_date DESC');
    $this->CI->db->limit(1);
    $dataAsn = $this->CI->db->get();
    return $dataAsn->row_array();
  }

  private function getRegIdUserById($id_users)
  {
    $this->CI->db->select('f.id_users, GROUP_CONCAT(f.fcm_regid SEPARATOR ";;") as regid');
    $this->CI->db->from('xi_sa_users_fcm f');
    $this->CI->db->where('f.id_users', $id_users);
    $this->CI->db->where('f.status', 1);
    $this->CI->db->group_by(array('f.id_users'));
    $this->CI->db->order_by('f.create_date DESC');
    $this->CI->db->limit(1);
    $dataAsn = $this->CI->db->get();
    return $dataAsn->row_array();
  }

  private function insertNotification($id_receiver, $id_sender, $nm_sender, $token_surat, $note, $message)
  {
    $notificationToken = generateToken($id_receiver, $id_sender);
    $create_date       = gmdate('Y-m-d H:i:s', time()+60*60*7);
    $data = array(
      'token'       => $notificationToken,
      'id_receiver' => $id_receiver,
      'id_sender'   => $id_sender,
      'nm_sender'   => $nm_sender,
      'token_surat' => $token_surat,
      'kode_notifikasi' => $note,
      'tgl_notifikasi'  => $create_date,
      'pesan_notifikasi'  => $message,
      'status'      => 1
    );
    $this->CI->db->insert('ms_data_notifikasi', $data);
    return TRUE;
  }

  public function sendNotificationNotaDinas($token_asn, $id_sender, $nm_sender, $message, $note, $tahun, $kategori, $token, $receiver='', $status='')
  {
    $data      = ($status == 'NA') ? $this->getRegIdUserById($receiver) : $this->getRegIdUserByToken($token_asn);
    $regId     = !empty($data) ? explode(';;', $data['regid']) : array();
    $idReceive = !empty($data) ? $data['id_users'] : $receiver;
    $items     = array('data' => array('title' => $nm_sender, 'message' => $message, 'note' => $note, 'tahun' => $tahun, 'tipe' => $kategori, 'token' => $token, 'alamat_file' => '', 'id_kirim' => '','nama_file' => ''));
		$fields    = array('registration_ids' => $regId, 'data' => $items);
    //insert notifikasi
    $this->insertNotification($idReceive, $id_sender, $nm_sender, $token, $note, $message);
    //send notifikasi
    if(!empty($regId)) {
      $fcm = $this->sendNotification($fields);
      return $fcm;
    } else
      return TRUE;
  }

  public function sendNotificationSuratTugas($token_asn, $id_sender, $nm_sender, $message, $note, $tahun, $kategori, $token, $receiver='', $status='')
  {
    $data      = ($status != 'K') ? $this->getRegIdUserById($receiver) : $this->getRegIdUserByToken($token_asn);
    $regId     = !empty($data) ? explode(';;', $data['regid']) : array();
    $idReceive = !empty($data) ? $data['id_users'] : $receiver;
    $items     = array('data' => array('title' => $nm_sender, 'message' => $message, 'note' => $note, 'tahun' => $tahun, 'tipe' => $kategori, 'token' => $token, 'alamat_file' => '', 'id_kirim' => '','nama_file' => ''));
		$fields    = array('registration_ids' => $regId, 'data' => $items);
    //insert notifikasi
    $this->insertNotification($idReceive, $id_sender, $nm_sender, $token, $note, $message);
    //send notifikasi
    if(!empty($regId)) {
      $fcm = $this->sendNotification($fields);
      return $fcm;
    } else
      return TRUE;
  }

  private function sendNotification($fields)
  {
    $url      = FBS_API_URL;
    $headers  = array('Authorization:key='.FBS_API_KEY, 'Content-Type: application/json');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);
		if ($result === FALSE) {
      die('FCM Send Error: ' . curl_error($ch));
    }
		curl_close($ch);
		return $result;
  }
}


// This is the end of App_Loader
