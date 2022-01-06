<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Aplikasi Loader Library
 * Library untuk mengambil session, generate menu dll
 * @author  Yogi Kaputra
 * @since   1.0
 */

class Cipusher
{
  public function __construct()
  {
    $this->CI =& get_instance();
  }

  public function send($data=array())
  {
    require_once(APPPATH.'views/vendor/autoload.php');
    $options = array(
        'cluster' => 'ap1',
        'useTLS' => false
    );
    $pusher = new Pusher\Pusher(
        'a6be18f8aa19ab9f3828', //ganti dengan App_key pusher Anda
        'ed60da53a60a57be093c', //ganti dengan App_secret pusher Anda
        '954728', //ganti dengan App_id pusher Anda
        $options
    );
    $pusher->trigger('my-channel', 'my-event', $data);
    return TRUE;
  }

}


// This is the end of App_Loader
