<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Agenda extends SLP_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model(array('model_draft' => 'mag', 'model_master'=>'mmas'));
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
    }    

}