<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
require(APPPATH.'/libraries/RestController.php');
require(APPPATH.'/libraries/Format.php');

class Notifikasi extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model(array('model_notifikasi' => 'mnot'));
    }
    
    public function insert_post()
    {
        if($this->mnot->validasiDataNotifikasi("add") == FALSE) 
        {

             $this->response( [
                    'status'  => true,
                    'info'    =>true,
                    'message' => validation_errors()
                ], 200 );
        }
        else
        {
            $token_agenda = escape($this->post('token_agenda'));
            $token_disposisi = escape($this->post('token_disposisi'));
            $tipe_notifikasi = escape($this->post('tipe_notifikasi'));
            $arrDisposisi=array('DM');
            $arrDraft=array('SM', 'SR', 'SV');

            $tipe_notifikasi = $this->input->post('tipe_notifikasi');
            $detail=$this->mnot->getDetailDraft($token_agenda); 

            /*if (in_array($tipe_notifikasi, $arrDisposisi)) {
                $detail=$this->mnot->getDetailDraft($token_agenda); 
            }

            if (in_array($tipe_notifikasi, $arrDraft)) {
                $detail=$this->mnot->getDetailDispomasuk($token_disposisi);  
            }*/


             if (count($detail) <=0) {
               $this->response( [
                      'status'  => true,
                      'info'    =>false,
                      'message' =>'Data Agenda/Disposisi Tidak Ditemukan'
                  ], 200 );
             }
             else
             {
                 $data = $this->mnot->insertDataNotifikasi();
                 $this->response( [
                        'status'  => true,
                        'info'    =>true,
                        'message' => 'Notifikasi Berhasil Di Simpan'
                    ], 200 );
             }

        }        
    }

    public function update_get()
    {
        $token_notifikasi = escape($this->get('token_notifikasi'));
        $detail = $this->mnot->getDetailNotifikasi($token_notifikasi);

        if (count($detail) <=0) {
             $this->response( [
                    'status'  => true,
                    'info'    =>false,
                    'message' =>'Data Tidak Ditemukan'
                ], 200 );
        }else{

             $data = $this->mnot->updateNotifikasi($token_notifikasi);
             $this->response( [
                    'status'  => true,
                    'info'    =>true,
                    'message' => 'Notifikasi berhasil diupdate'
                ], 200 );
        }
    }  


    public function list_get()
    {   
        $id_user = escape($this->get('id_user'));
        
        $list=array();
        $data = $this->mnot->getListNotifikasi($id_user);
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
              
               $detail_agenda = $this->mnot->getDetailAgendaByToken($dd['token_agenda']);
               $detail_disposisi = $this->mnot->getDetailDisposisiByToken($dd['token_disposisi']);

               $i=array('id_notifikasi'     =>$dd['id_notifikasi'],
                        'token_notifikasi'  =>$dd['token_notifikasi'],
                        'token_agenda'      =>$dd['token_agenda'],
                        'nama_agenda'       =>$detail_agenda['nama_agenda'],
                        'token_disposisi'   =>$dd['token_disposisi'],
                        'isi_disposisi'     =>$detail_disposisi['isi_disposisi'],
                        'id_pengirim'       =>$dd['id_pengirim'],
                        'id_penerima'       =>$dd['id_penerima'],
                        'tipe_notifikasi'   =>$dd['tipe_notifikasi'],
                        'pesan_notifikasi'  =>$dd['pesan_notifikasi'],
                        'id_status'         =>$dd['id_status'],
                        'create_date'       =>tgl_indo_time($dd['create_date'])
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