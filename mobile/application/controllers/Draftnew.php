<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
require(APPPATH.'/libraries/RestController.php');
require(APPPATH.'/libraries/Format.php');

class Draftnew extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model(array('model_draftnew' => 'mag', 'model_master'=>'mmas'));
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
                    'message' => 'Draft berhasil disimpan',
                    'token' => $data['token']
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


    public function update_draft_post()
    {
        $token     = escape($this->post('token'));
        $create_by = escape($this->post('id_user'));
        $detail  = $this->mag->getDetailDraft($token);

        if (count($detail) <=0) {
             $this->response( [
                    'status'  =>true,
                    'info'    =>false,
                    'message' =>'Data Agenda Tidak Ditemukan'
                ], 200 );
        }else{

             if($this->mag->validasiDraft("edit") == FALSE) 
             {

                 $this->response( [
                        'status'  =>true,
                        'info'    =>false,
                        'message' => validation_errors()
                    ], 200 );
             }else{

                 $data = $this->mag->updateDataDraft();
                 $this->response( [
                        'status'  =>true,
                        'info'    =>true,
                        'message' => 'Draft berhasil diupdate',
                        'token'   => $data['token']
                    ], 200 );
            }
        }
    }

    public function delete_draft_post()
    {
        $token   = escape($this->post('token'));

        $detail  = $this->mag->getDetailDraft($token);

        if (count($detail) <=0) {
             $this->response( [
                    'status'  =>true,
                    'info'    =>false,
                    'message' =>'Data Tidak Ditemukan'
                ], 200 );
        }
        else
        {           
             $data = $this->mag->deleteDataDraft($token);
             if ($data['status']==FALSE) 
             {
                $this->response( [
                    'status'  =>true,
                    'info'    =>false,
                    'message' => $data['message']
                ], 200 );
             }
             else
             {
               $this->response( [
                    'status'  =>true,
                    'info'    =>true,
                    'message' => 'Draft berhasil dihapus'
                ], 200 ); 
             }
             
        }
    }


    public function list_status_get()
    {   
        $list=array();
        $data = $this->mag->getDataStatus();
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
                   $i=array('id_status'  =>$dd['id_status'],
                            'nm_status'  =>$dd['nm_status']
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