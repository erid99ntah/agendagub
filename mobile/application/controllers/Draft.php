<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
require(APPPATH.'/libraries/RestController.php');
require(APPPATH.'/libraries/Format.php');

class Draft extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model(array('model_draft' => 'mag', 'model_master'=>'mmas'));
    }

    public function list_draft_get()
    {   
        $id_group = escape($this->get('id_group'));
        
        $list=array();
        $data = $this->mag->getListDataDraft($id_group);
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

               if ($dd['status_verifikasi']=='SM')
                        $status_verifikasi=$dd['nm_status'];
                    elseif($dd['status_verifikasi']=='CC')
                        $status_verifikasi=$dd['nm_status'];
                    else
                        $status_verifikasi=$dd['nm_status'];

               $cekStatusAgenda = $this->mag->getStatusAgenda($dd['id_status']);

               $year = substr($dd['create_date'],0,4);
               $month = substr($dd['create_date'],5,2); 
               $fileDokumen =base_url('./../images/agenda/'.$year.'/'.$month.'/'.$dd['dokumen']);

               // ($dd['dokumen']!='' && file_exists($fileDokumen)){
               if ($dd['dokumen']!=''){
                    $url=$fileDokumen;
               }
               else{
                    $url='File Not Found';
               }              


               $i=array('token'             =>$dd['token'],
                        'nama_agenda'       =>$dd['nama_agenda'],
                        'jenis_agenda'      =>$dd['jenis_agenda'],
                        'tanggal'           =>$dd['tanggal'],
                        'jam_mulai'         =>$dd['jam_mulai'],
                        'jam_selesai'       =>$dd['jam_selesai'],
                        'kegiatan'          =>$dd['kegiatan'],
                        'lokasi_kegiatan'   =>$dd['lokasi_kegiatan'],
                        'status_verifikasi' =>$dd['status_verifikasi'],
                        'nm_status_verifikasi'         =>$status_verifikasi,
                        'id_status'         =>$dd['id_status'],
                        'status_agenda'         =>$cekStatusAgenda,
                        'dokumen'           =>$url,
                        'keterangan'           =>$dd['keterangan']
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


    public function detail_draft_get()
    {
        $token = escape($this->get('token'));
        $detail = $this->mag->getDetailDraft($token);

        if (count($detail) <=0) {
             $this->response( [
                    'status'  => true,
                    'info'    =>false,
                    'message' =>'Data Tidak Ditemukan'
                ], 200 );
        }else{

             if ($detail['status_verifikasi']=='SM')
                        $status_verifikasi=$detail['nm_status'];
                    elseif($detail['status_verifikasi']=='CC')
                        $status_verifikasi=$detail['nm_status'];
                    else
                        $status_verifikasi=$detail['nm_status'];

                $cekStatusAgenda = $this->mag->getStatusAgenda($detail['id_status']);

               $year = substr($detail['create_date'],0,4);
               $month = substr($detail['create_date'],5,2); 
               $fileDokumen =base_url('./../images/agenda/'.$year.'/'.$month.'/'.$detail['dokumen']);

               //if ($detail['dokumen']!='' && file_exists($fileDokumen)){
               if ($detail['dokumen']!=''){
                    $url=$fileDokumen;
               }
               else{
                    $url='File Not Found';
               }

               $i=array('token'             =>$detail['token'],
                        'nama_agenda'       =>$detail['nama_agenda'],
                        'jenis_agenda'      =>$detail['jenis_agenda'],
                        'tanggal'           =>$detail['tanggal'],
                        'id_opd'           =>$detail['id_opd'],
                        'penerima'           =>$detail['penerima'],
                        'jam_mulai'         =>$detail['jam_mulai'],
                        'jam_selesai'       =>$detail['jam_selesai'],
                        'kegiatan'          =>$detail['kegiatan'],
                        'lokasi_kegiatan'   =>$detail['lokasi_kegiatan'],
                        'status_verifikasi' =>$detail['status_verifikasi'],
                        'nm_status_verifikasi' =>$status_verifikasi,
                        'id_status'         =>$detail['id_status'],
                        'status_agenda'         =>$cekStatusAgenda,
                        'dokumen'           =>$url,
                        'keterangan'           =>$detail['keterangan']
                        );

            $this->response( [
                    'status'  => true,
                    'info'    =>true,
                    'message' => $i
                ], 200 );
        }
    }

    public function approve_draft_post()
    {
        $token = escape($this->post('token'));
        $id_user = escape($this->post('id_user'));
        $detail = $this->mag->getDetailDraft($token);

        if (count($detail) <=0) {
             $this->response( [
                    'status'  => true,
                    'info'    =>false,
                    'message' =>'Data Tidak Ditemukan'
                ], 200 );
        }else{

             $data = $this->mag->approveDraft($token,$id_user);
             $this->response( [
                    'status'  => true,
                    'info'    =>true,
                    'message' => 'Agenda Berhasil Di ACC'
                ], 200 );
        }
    }

    public function reject_draft_post(){
        $token = escape($this->post('token'));
        $detail = $this->mag->getDetailDraft($token);

        if (count($detail) <=0) {
             $this->response( [
                    'status'  => true,
                    'info'    =>false,
                    'message' =>'Data Tidak Ditemukan'
                ], 200 );
        }else{

             $data = $this->mag->rejectDraft($token);
             $this->response( [
                    'status'  => true,
                    'info'    =>true,
                    'message' => 'Agenda Berhasil Di Tolak'
                ], 200 );
        }
    }

    public function review_draft_post(){
        $token = escape($this->post('token'));
        $detail = $this->mag->getDetailDraft($token);

        if (count($detail) <=0) {
             $this->response( [
                    'status'  => true,
                    'info'    =>false,
                    'message' =>'Data Tidak Ditemukan'
                ], 200 );
        }else{

             if($this->mag->validasiDataAgendaPimpinan("add") == FALSE) 
             {

                 $this->response( [
                        'status'  => true,
                        'info'    =>true,
                        'message' => validation_errors()
                    ], 200 );
             }else{

                 $data = $this->mag->insertDataReview($token);
                 $this->response( [
                        'status'  => true,
                        'info'    =>true,
                        'message' => 'Agenda Berhasil Di Review'
                    ], 200 );
            }
        }
    }

    public function list_penerima_disposisi_get(){
        
        $token = escape($this->get('token_agenda'));
        $detail = $this->mag->getDetailDraft($token);

        if (count($detail) <=0) {
             $this->response( [
                    'status'  => true,
                    'info'    =>false,
                    'message' =>'Data Agenda Tidak Ditemukan'
                ], 200 );
        }else{

                $jenis_agenda = $detail['jenis_agenda'];

                $data = $this->mag->getDataPenerima($jenis_agenda);
                $list=array();
                if (count($data) <=0) {
                     $this->response( [
                            'status'  => true,
                            'info'    =>false,
                            'message' =>'Data Tidak Ditemukan'
                        ], 200 );
                }else{

                     foreach ($data as $key => $dp) {
                        $i=array('token'=>$dp['token'],
                                 'fullname'      =>$dp['fullname'],
                                 'jabatan_id'   => $dp['jabatan_id'],
                                 'jabatan_nm'   => $dp['jabatan_nm'],
                                 'nm_jab_dprd'   => $dp['nm_jab_dprd'],
                                 'nm_fraksi'     => $dp['nm_fraksi'],
                                 'nm_jab_fraksi' => $dp['nm_jab_fraksi'],
                                 'nm_komisi'     => $dp['nm_komisi'],
                                 'nm_jab_komisi' => $dp['nm_jab_komisi']
                                 ); 
                        array_push($list, $i);
                     }
                    
                     $this->response( [
                            'status'  => true,
                            'info'    => true,
                            'message' => $list
                        ], 200 );
                }
        }
    }

    public function validasi_draft_post(){
        $token = escape($this->post('token'));
        $detail = $this->mag->getDetailDraft($token);

        if (count($detail) <=0) {
             $this->response( [
                    'status'  => true,
                    'info'    =>false,
                    'message' =>'Data Agenda Tidak Ditemukan'
                ], 200 );
        }else{

             if($this->mag->validasiDataAgendaSekretaris("add") == FALSE) 
             {

                 $this->response( [
                        'status'  => true,
                        'info'    =>true,
                        'message' => validation_errors()
                    ], 200 );
             }else{

                 $data = $this->mag->insertDataValidasi($token);
                 $this->response( [
                        'status'  => true,
                        'info'    =>true,
                        'message' => 'Agenda Berhasil Di Review'
                    ], 200 );
            }
        }
    }

    public function insert_draft_post()
    {
         if($this->mag->validasiDraft("add") == FALSE) 
         {

             $this->response( [
                    'status'  => true,
                    'info'    =>true,
                    'message' => validation_errors()
                ], 200 );
         }else{

             $data = $this->mag->insertDataDraft();
             $this->response( [
                    'status'  =>true,
                    'info'    =>true,
                    'message' => 'Draft berhasil disimpan'
                ], 200 );
        }
        /*$path = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']).'../';
        echo $path;*/
    }

    public function list_penerima_agenda_get()
    {          
        $list=array();
        $data = $this->mag->getListPenerimaAgenda();
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

               $i=array('token'           =>$dd['token'],
                        'fullname'        =>$dd['fullname'],
                        'id_opd'          =>$dd['id_opd'],
                        'nm_opd'           =>$dd['nm_opd']
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