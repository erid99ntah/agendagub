<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Nofication Manager
 * Library untuk mengirim dan membaca pesan
 * @author  Yogi Kaputra
 * @since   1.0
 */

class Notification_Manager
{

  public function __construct()
  {
    $this->CI =& get_instance();
    $this->CI->load->database();
    $this->CI->load->library('cipusher');
  }

  public function getUserByRegency($id_regency)
  {
    $this->CI->db->select('username');
    $this->CI->db->where('id_regency', $id_regency);
    $this->CI->db->order_by('id_users DESC');
    $this->CI->db->limit(1);
    $query = $this->CI->db->get('xi_sa_users')->row_array();
    $user = !empty($query) ? $query['username'] : '';
    return $user;
  }

  public function getUserByHospital($id_hospital)
  {
    $this->CI->db->select('username');
    $this->CI->db->where('id_rs', $id_hospital);
    $this->CI->db->order_by('id_users DESC');
    $this->CI->db->limit(1);
    $query = $this->CI->db->get('xi_sa_users')->row_array();
    $user = !empty($query) ? $query['username'] : '';
    return $user;
  }

  private function recipient_id($level_akses)
  {
    $this->CI->db->select('a.username');
    $this->CI->db->from('xi_sa_users a');
    $this->CI->db->join('xi_sa_users_privileges b', 'a.id_users = b.id_users', 'inner');
    $this->CI->db->join('xi_sa_group c', 'b.id_group = c.id_group', 'inner');
    $this->CI->db->where_in('c.id_level_akses', $level_akses);
    $this->CI->db->where('c.id_status', 1);
    $query = $this->CI->db->get();
    return $query->result_array();
  }

  private function laboratorium_id($id_labor)
  {
    $this->CI->db->select('username');
    $this->CI->db->where('id_labor', $id_labor);
    $query = $this->CI->db->get('xi_sa_users');
    return $query->result_array();
  }

  private function insertNotification($data=array())
  {
    if(count($data) > 0) {
      //insert notification
      $this->CI->db->insert_batch('ta_notification', $data);
      //run pusher
      $this->CI->cipusher->send(array('message'=>'notifsuccess'));
    }
    return TRUE;
  }

  public function add($params=array())
  {
    $user    = array();
    $arrData = array();
    //get data penerima
    if(in_array($params['type'], array('otg.new', 'odp.new', 'case.new', 'swab.new', 'data.new'))) {
      $dataUser = ($params['type'] == 'swab.new') ? $this->laboratorium_id($params['labor']) : $this->recipient_id($params['level_akses']);
      foreach ($dataUser as $key => $u) {
        $user[] = $u['username'];
      }
    } else {
      $user[] = $params['recipient_id'];
    }
    if(count($user) > 0) {
      foreach ($user as $n) {
        $token = generateToken($n, $params['type']);
        $arrData[] = array(
          'token'         => $token,
          'sender_id'     => $params['sender_id'],
          'recipient_id'  => $n,
          'type'          => $params['type'],
          'parameters'    => $params['parameters'],
          'reference'     => $params['reference'],
          'unread'        => 1,
          'create_by'     => $params['create_by'],
          'create_date'   => $params['create_date'],
          'create_ip'     => $params['create_ip'],
          'mod_by'        => $params['create_by'],
          'mod_date'      => $params['create_date'],
          'mod_ip'        => $params['create_ip']
        );
      }
    }
    $result = $this->insertNotification($arrData);
    return $result;
  }
}


// This is the end of App_Loader
