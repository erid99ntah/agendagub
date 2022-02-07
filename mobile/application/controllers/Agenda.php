<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
require(APPPATH.'/libraries/RestController.php');
require(APPPATH.'/libraries/Format.php');

class Agenda extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model(array('model_agenda' => 'mag', 'model_master' => 'mmas'));
    }

    public function list_agenda_get()
    {   
        $tanggal = escape($this->get('tanggal'));
        if (isset($tanggal))
            $tanggal = escape($this->get('tanggal'));
        else
            $tanggal='';

        $status_agenda  = escape($this->get('status_agenda'));
        $penerima       = escape($this->get('penerima'));
        $jenis_agenda   = escape($this->get('jenis_agenda'));

        $list=array();
        $data = $this->mag->getListDataAgenda($tanggal, $status_agenda, $penerima, $jenis_agenda);
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

              // if ($dd['dokumen']!='' && file_exists($fileDokumen)){
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
                        'penyelenggara'     =>$dd['penyelenggara'],
                        'cp'                =>$dd['cp'],
                        'status_verifikasi' =>$dd['status_verifikasi'],
                        'nm_status'         =>$status_verifikasi,
                        'dokumen'           =>$url,
                        'id_status'         =>$dd['id_status'],
                        'penerima_disposisi'         =>$dd['penerima_disposisi'],
                        'keterangan_hadir'         =>$dd['keterangan_hadir'],
                        'status_agenda'         =>$cekStatusAgenda,
                        'create_by'         =>$dd['create_by'],
                        'create_user'       =>$this->mmas->getUsersProfileByUsername($dd['create_by'])['fullname']
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


    public function detail_agenda_get()
    {
        $token = escape($this->get('token'));
        $detail = $this->mag->getDetailAgenda($token);

        if (empty($detail)) {
             $this->response( [
                    'status'  => true,
                    'info'    =>false,
                    'message' =>'Data Tidak Ditemukan'
                ], 200 );
        }else{

            $cekStatusAgenda = $this->mag->getStatusAgenda($detail['id_status']);
            $status_verifikasi = $this->mag->getStatusAgenda($detail['status_verifikasi']);


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

               $penerima_disposisi='';
               if ($detail['id_status']=='SW') 
               {
                 $cek_disposisi = $this->mmas->cekDisposisiByAgendaID($detail['id_agenda']);
                 $penerima_disposisi  = $this->mmas->arrayPenerimaDisposisi($cek_disposisi['id_disposisi']);
               }     
               else{
                $penerima_disposisi='';
               }

               $i=array('token'             =>$detail['token'],
                        'nama_agenda'       =>$detail['nama_agenda'],
                        'jenis_agenda'      =>$detail['jenis_agenda'],
                        'tanggal'           =>$detail['tanggal'],
                        'jam_mulai'         =>$detail['jam_mulai'],
                        'jam_selesai'       =>$detail['jam_selesai'],
                        'kegiatan'          =>$detail['kegiatan'],
                        'lokasi_kegiatan'   =>$detail['lokasi_kegiatan'],
                        'penyelenggara'   =>$detail['penyelenggara'],
                        'cp'                =>$detail['cp'],
                        'keterangan'   =>$detail['keterangan'],
                        'status_verifikasi' =>$status_verifikasi,
                        'nm_status'         =>$status_verifikasi,
                        'dokumen'           =>$url,
                        'id_status'         =>$detail['id_status'],
                          'penerima_disposisi'         =>$detail['penerima_disposisi'],
                        'keterangan_hadir'         =>$detail['keterangan_hadir'],
                        'status_agenda'     =>$cekStatusAgenda,
                        'create_by'         =>$detail['create_by'],
                        'create_user'       =>$this->mmas->getUsersProfileByUsername($detail['create_by'])['fullname']
                        //'penerima_disposisi'=>$penerima_disposisi
                        );

            $this->response( [
                    'status'  => true,
                    'info'    =>true,
                    'message' => $i
                ], 200 );
        }
    }

}