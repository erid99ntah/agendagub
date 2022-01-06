<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Login | Helpdesk</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="initial-scale=1,minimum-scale=1,maximum-scale=1">
    <meta name="description" content="Helpdesk SUMBAR">
    <meta name="author" content="Diskominfo Sumbar">
    <meta name="keywords" content="Helpdesk SUMBAR" />
    
    <link rel="stylesheet" href="<?php echo base_url('assets/signin/style.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/signin/css/bootstrap.min.css') ?>">
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/favicon.ico') ?>" sizes="32x32">
    <link rel="stylesheet" href="<?php echo base_url('assets/fonts/font-awesome/css/font-awesome.min.css'); ?>" />
  </head>

  <body class="focusedform">
      <div class="container">
        <div class="row">
          <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
              <div class="card-body">
                <h5 class="card-title text-center"> PILIH GRUP </h5>
                 <?php echo $this->session->flashdata('message'); ?>
                 <p>Selamat datang Anda memiliki <?php echo count($multi_group); ?> grup, silahkan pilih salah satu untuk melanjutkan </p>
                 <?php echo form_open(site_url('signin/login'), array('class' => 'form-horizontal', 'role' => 'form')); ?>
                 
                 <div class="form-label-group">
                    <label for="inputPassword"> List Grup</label>
                     <?php 
                      foreach ($multi_group as $group): ?>
                        <div class="radio">
                          <label>
                            <input type="radio" name="pilgroup" id="pilgroup" value="<?php echo $group['id_group'] ?>"> <?php echo $group['nama_group']; ?>
                          </label>
                        </div>
                      <?php endforeach;  echo form_error('pilgroup');?>
                  </div><br>
                  
                  <input type="submit" name="next" id="submit" class="btn btn-primary" value="Lanjutkan">

                  <hr class="my-4">             
                 <?php echo form_close(); ?>
                  <p style="text-align:center;color:#A9A9A9;"><?php echo "Helpdesk ©" . ((date('Y') == "2020") ? "2020" : "2020 - ".date('Y')) . " " . " - Team IT Kominfo Prov. Sumbar"; ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>

    <script src="<?php echo base_url('assets/signin/jquery.js'); ?>"></script>
    <script src="<?php echo base_url('assets/signin/js/bootstrap.bundle.min.js'); ?>"></script>
  	<script type="text/javascript">
  		$(function(){
  		  $('#submit').on('click',function(){
  		  	$(this).val("Melanjutkan...");
  		  	$(this).addClass('disabled');
  		    $('#form-login').submit();
  		  });
  		});
    </script>

  </body>
</html>
