<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
require(APPPATH.'/libraries/RestController.php');
require(APPPATH.'/libraries/Format.php');

class Disposisi extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model(array('model_disposisi' => 'mdis', 'model_master' => 'mmas'));
    }

    public function list_keluar_get()
    {   
        $id_group = escape($this->get('id_group'));
        
        $list=array();
        $data = $this->mdis->getListDisposisiKeluar($id_group);
        if (count($data)<=0) 
        {
           $this->response( [
                    'status'  => true,
                    'info'    =>false,
                    'message' =>'Data Kosong'
                ], 200 );
        }
        else
        {
            foreach ($data as $key => $dd) 
            {

               $detail_agenda = $this->mmas->arrayDetailAgenda($dd['id_agenda']);
               $penerima      = $this->mmas->arrayPenerimaDisposisi($dd['id_disposisi']);

               $i=array('token'             =>$dd['token'],
                        'id_agenda'         =>$dd['id_agenda'],
                        'tgl_disposisi'     =>$dd['tgl_disposisi'],
                        'isi_disposisi'     =>$dd['isi_disposisi'],
                        'id_pengirim'       =>$dd['id_pengirim'],
                        'id_opd'            =>$dd['id_opd'],
                        'detail_agenda'     =>$detail_agenda,
                        'penerima_disposisi'=>$penerima
                        );
               array_push($list, $i);
            }

            $this->response( [
                    'status'  => true,
                    'info'    =>true,
                    'message' => $list
                ], 200 );
        }           
    }

    public function list_masuk_get()
    {   
        $userid = escape($this->get('userid'));
        
        $list=array();
        $dataUser = $this->mdis->cekUserByUserID($userid);

        if (count($dataUser)<=0) 
        {
           $this->response( [
                    'status'  => true,
                    'info'    =>false,
                    'message' =>'Data User Tidak Ditemukan'
                ], 200 );
        }
        else
        {

            $data = $this->mdis->getListDisposisiMasukUserID($userid);
            if (count($data)<=0) 
            {
               $this->response( [
                        'status'  => true,
                        'info'    =>false,
                        'message' =>'Data Kosong'
                    ], 200 );
            }
            else
            {
                foreach ($data as $key => $dd) {
                   
                   $detail_agenda = $this->mmas->arrayDetailAgenda($dd['id_agenda']);
                   $i=array('id_disposisi'      =>$dd['id_disposisi'],
                            'id_agenda'         =>$dd['id_agenda'],
                            'tgl_disposisi'     =>$dd['tgl_disposisi'],
                            'isi_disposisi'     =>$dd['isi_disposisi'],
                            'id_pengirim'       =>$dd['id_pengirim'],
                            'id_opd'            =>$dd['id_opd'],
                            'detail_agenda'     =>$detail_agenda,
                            'id_disposisi_masuk'=>$dd['id_disposisi_masuk'],
                            'token'             =>$dd['token'],
                            'tgl_terima'        =>$dd['tgl_terima'],
                            'status_penerima'   =>$dd['status_penerima'],
                            'status_baca'       =>convert_status_penerima($dd['status_penerima']),
                            'pesan_penerima'    =>$dd['pesan_penerima']                            
                            );
                   array_push($list, $i);
                }

                $this->response( [
                        'status'  => true,
                        'info'    =>true,
                        'message' => $list
                    ], 200 );
            }    
        }       
    }

    public function detail_masuk_get()
    {  
        $list=array();
        $token = escape($this->get('token')); 
        $detail = $this->mdis->getDetailDisposisiMasuk($token);
        if (count($detail)<=0) 
        {
           $this->response( [
                    'status'  => true,
                    'info'    =>false,
                    'message' =>'Data Disposisi Tidak ditemukan'
                ], 200 );
        }
        else
        {   
               if ($detail['tgl_terima']=='0000-00-00 00:00:00') {
                  $this->mdis->updateDisposisiMasuk($token);    
               }

               $detail_agenda = $this->mmas->arrayDetailAgenda($detail['id_agenda']);
               $detail_user   = $this->mmas->getUsersProfileByToken($detail['id_pengirim']);

               $i=array('id_disposisi'      =>$detail['id_disposisi'],
                        'id_agenda'         =>$detail['id_agenda'],
                        'tgl_disposisi'     =>$detail['tgl_disposisi'],
                        'isi_disposisi'     =>$detail['isi_disposisi'],
                        'id_pengirim'       =>$detail['id_pengirim'],
                        'nm_pengirim'       =>$detail_user['fullname'],
                        'id_opd'            =>$detail['id_opd'],
                        'detail_agenda'     =>$detail_agenda,
                        'id_disposisi_masuk'=>$detail['id_disposisi_masuk'],
                        'token'             =>$detail['token'],
                        'tgl_terima'        =>$detail['tgl_terima'],
                        'status_penerima'   =>$detail['status_penerima'],
                        'status_baca'       =>convert_status_penerima($detail['status_penerima']),
                        'pesan_penerima'    =>$detail['pesan_penerima']                            
                        );
               array_push($list, $i);
         
            $this->response( [
                    'status'  => true,
                    'info'    =>true,
                    'message' => $list
                ], 200 );
        }    
               
    }

   
}