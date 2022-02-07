<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
require(APPPATH.'/libraries/RestController.php');
require(APPPATH.'/libraries/Format.php');

class Account extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model(array('model_account' => 'mac'));
    }

    public function update_password_post()
    {      

         if($this->mac->validasiDataSandi("edit") == FALSE) 
         {
             $this->response( [
                    'status'  =>true,
                    'info'    =>false,
                    'message' => validation_errors()
                ], 200 );
         }
         else
         {
            $token     = escape($this->post('token'));
            $detail  = $this->mac->getUsersProfileByToken($token);

            if (count($detail) <=0) {
                 $this->response( [
                        'status'  =>true,
                        'info'    =>false,
                        'message' =>'Data User Tidak Ditemukan'
                    ], 200 );
            }
            else
            {

                 $data = $this->mac->updatePassword();
                 if ($data['status']==TRUE) 
                 {                  
                    $this->response( [
                        'status'  =>true,
                        'info'    =>true,
                        'message' =>$data['message']
                    ], 200 );
                 }else{
                    $this->response( [
                        'status'  =>true,
                        'info'    =>false,
                        'message' =>$data['message']
                    ], 200 );
                 }
            }
        }
        
    }
   
}