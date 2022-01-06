<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
require(APPPATH.'/libraries/RestController.php');
require(APPPATH.'/libraries/Format.php');

class Signin extends RestController {

    var $username;
    var $password;
    var $ip_address;
    var $user_agent;

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model(array('model_auth' => 'mauth', 'model_master'=>'mmas'));
        $this->username     = addslashes(escape(trim($this->input->post('username', TRUE))));
        $this->password     = escape($this->input->post('password', TRUE));
        $this->captcha      = addslashes(escape(trim($this->input->post('captcha', TRUE))));
        $this->ip_address   = addslashes($this->input->ip_address());
        $this->user_agent   = addslashes($this->input->user_agent());  
    }


   public function login_post()
   {
        
        if($this->mauth->validasiDataValue() == FALSE) {
            $this->response( [
                        'status'  => true,
                        'info'    =>false,
                        'message' =>''.validation_errors().''
                    ], 200 );
        }
        else
        {          
                //cek username yang diinputkan pertama
                $cekuser = $this->mauth->cekDataUsername($this->username);
                if(empty($cekuser) OR count($cekuser) <= 0){
                    $this->response( [
                        'status'  => true,
                        'info'    =>false,
                        'message' =>'Username Anda Tidak Ditemukan'
                    ], 200 );
                } 
                else 
                {
                    //cek username dan password
                    if($this->is_password($this->username, $this->password) === FALSE) 
                    {
                        //insert error log ke table log login
                        $this->mauth->setLoginFailed($this->username, $this->ip_address, $this->user_agent);
                        $blockir = $this->cek_blockir($this->username);
                        if($blockir >= 7 && $blockir < 10){
                             $this->response( [
                            'status'  => true,
                            'info'    =>false,
                            'message' =>'Anda sudah '.$blockir.' kali salah menginputkan password, kesempatan anda '.(10 - $blockir).' kali lagi. Jika mauthih salah akun diblokir otomatis..'
                             ], 200 );
                        }
                        else if($blockir >= 10) {
                            $this->mauth->setAccountUserBlock($this->username);
                             $this->response( [
                            'status'  => true,
                            'info'    =>false,
                            'message' =>'Akun anda sudah diblokir, silahkan hubungi administrator'
                             ], 200 );
                           
                        } else{                            
                             $this->response( [
                                'status'  => true,
                                'info'    =>false,
                                'message' =>'Username dan Password anda tidak cocok'
                             ], 200 );
                           
                        }
                    }
                    else 
                    {
                        //cek akun aktif atau tidak
                        if($this->is_actived($this->username) === FALSE) {
                            error_message('danger', 'Peringatan!', 'Akun anda sudah tidak aktif, silahkan hubungi administrator...');
                            $this->createLoginForm();
                        } else {
                            //cek akun blokir atau tidak
                            if($this->is_blockir($this->username) === TRUE) {
                                error_message('danger', 'Peringatan!', 'Akun anda saat ini sedang diblokir, silahkan hubungi administrator...');
                                $this->createLoginForm();
                            } else {
                                
                                //delete failed log
                                $this->mauth->deleteFailedLog($this->username);
                                //insert success login
                                $this->mauth->setSuccessLog($this->username, $this->ip_address, $this->user_agent);
                                
                                //ambil group user
                                $getGroup = $this->mauth->getDataUserGroup($this->username);
                                /*if(count($getGroup) > 1) {
                                    //multi group
                                    $this->session->set_flashdata('message', '');
                                    $this->createSelectGroupForm($getGroup);
                                } elseif(count($getGroup) == 1) {
                                    //set login time
                                    $this->expired_login->login_time();
                                    //set session satu group
                                    
                                    redirect('home');
                                }*/
                                $dataUser = $this->set_session($this->username, $getGroup[0]['id_group']);
                                 $this->response( [
                                    'status'  => true,
                                    'info'    =>true,
                                    'message' =>$dataUser
                                 ], 200 );

                            }
                        }
                    }
                } //cek username yang diinputkan pertama
            
        }   
    }    

    private function set_session($username, $group)
    {   
        $list=array();

        //ambil data user berdasarkan group
        $dataUser = $this->mauth->getDataUserProperties($username, $group);

        if(count($dataUser) > 0) {
            $session=array();
            $session['id_users']            = $dataUser['id_users'];
            $session['fullname']            = $dataUser['fullname'];
            $session['group_active']        = $dataUser['id_group'];
            $session['group_name']          = $dataUser['nama_group'];
            $session['id_level_akses']      = $dataUser['id_level_akses'];
            $session['level_akses']         = $dataUser['level_akses'];
            $session['nick_level']          = $dataUser['nick_level'];
            $session['userid']              = $dataUser['token'];
            $session['id_opd']              = $dataUser['id_opd'];
            array_push($list, $session);    
        } 
        return $list;
  }

    private function is_password($username, $password)
    {
        $validpass = $this->mauth->cekDataUsernamePass($username, $password);
        return $validpass;
    }

    private function is_actived($username)
    {
        $actived = $this->mauth->cekDataUserActive($username);
        return $actived;
    }

    private function is_blockir($username)
    {
        $blocked = $this->mauth->cekDataUserBlock($username);
        return $blocked;
    }

    private function cek_blockir($username)
    {
        $log = $this->mauth->getCountFailedLog($username);
        return $log->num_rows();
    }

    public function user_profile_get()
    {
        $username = escape($this->get('username'));
        $detail = $this->mauth->getDetailUsersDprd($username);

        if (count($detail) <=0) {
             $this->response( [
                    'status'  => true,
                    'info'    =>false,
                    'message' =>'Data User Tidak Ditemukan'
                ], 200 );
        }else{

               $i=array(
                        'token'      =>$detail['token'],
                        'fullname'   =>$detail['fullname'],
                        'id_opd'     =>$detail['id_opd'],
                        'nm_opd'     =>$detail['nm_opd'],
                        'sub_opd'    =>$detail['sub_opd'],
                        'nm_sub_opd' =>$detail['nm_sub_opd'],
                        'jns_jbtn_id'=>$detail['jns_jbtn_id'],
                        'jns_jbtn_nm'=>$detail['jns_jbtn_nm'],
                        'jabatan_id' =>$detail['jabatan_id'],
                        'jabatan_nm' =>$detail['jabatan_nm'],
                        'eselon_id'  =>$detail['eselon_id'],
                        'eselon_nm'  =>$detail['eselon_nm'],
                        );

            $this->response( [
                    'status'  => true,
                    'info'    =>true,
                    'message' => $i
                ], 200 );
        }
    }


    public function log_session_post()
    {
        $id_user      =escape($this->post('id_user'));       
        $username      =escape($this->post('username'));       

        if($this->mauth->validasiDataSession() == FALSE) 
        {

             $this->response( [
                    'status'  => true,
                    'info'    =>true,
                    'message' => validation_errors()
                ], 200 );
        }else{

                $detail = $this->mmas->getUsersProfileByToken($id_user);
                $detailUsername = $this->mauth->getDetailUsersDprd($username);

                if (count($detail) <=0) {
                     $this->response( [
                            'status'  => true,
                            'info'    =>false,
                            'message' =>'Data user dengan token '.$id_user.' tidak ditemukan'
                        ], 200 );

                }elseif(count($detailUsername) <=0) {
                     $this->response( [
                            'status'  => true,
                            'info'    =>false,
                            'message' =>'Data user dengan token '.$username.' tidak ditemukan'
                        ], 200 );
                }else{

                     $data = $this->mauth->insertDataSession($id_user);
                     $this->response( [
                            'status'  => true,
                            'info'    =>true,
                            'message' => 'Insert Session Berhasil'
                        ], 200 );
                }
        }

    }


    public function logout_post()
    {
        $id_user      =escape($this->post('id_user'));       
        $device_id      =escape($this->post('device_id'));       

       
        $detail = $this->mauth->getLogMobileByUserID($id_user,$device_id);

        if (count($detail) <=0) {
             $this->response( [
                    'status'  => true,
                    'info'    =>false,
                    'message' =>'Data user '.$id_user.' dengan device ID '.$device_id.' tidak ditemukan'
                ], 200 );
        
        }else{

             $data = $this->mauth->updateDataSession($id_user,$device_id);
             $this->response( [
                    'status'  => true,
                    'info'    =>true,
                    'message' => 'Logout Berhasil. Terima Kasih Sudah Menggunakan Aplikasi Ini'
                ], 200 );
        }

    }

}