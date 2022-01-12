<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pilih Group | SAKIP</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="initial-scale=1,minimum-scale=1,maximum-scale=1,width=device-width,height=device-height,target-densitydpi=device-dpi,user-scalable=yes">
    <meta name="description" content="Deskripsi tentang aplikasi">
    <meta name="author" content="Diskominfo Sumbar">
    <meta name="keywords" content="kata kunci" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/styles.css?=121') ?>">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/favicon.ico') ?>" sizes="32x32">
  </head>
  <body class="focusedform">
    <div class="verticalcenter">
      <a href="index.php" style="display:none;"><img src="<?php echo base_url('assets/img/logo-big.png') ?>" alt="Logo" class="brand" /></a>
	    <div class="panel panel-primary">
    		<div class="panel-body">
    			<h4 class="text-center" style="margin-bottom: 25px;">Pilih Group</a></h4>
          <?php echo $this->session->flashdata('message'); ?>
          <p>Selamat datang Anda memiliki <?php echo count($multi_group); ?> grup, silahkan pilih salah satu untuk melanjutkan </p>
          <?php echo form_open(site_url('signin/login'), array('class' => 'form-horizontal', 'role' => 'form')); ?>
  				<div class="form-group">
  					<div class="col-sm-12">
              <?php 
              foreach ($multi_group as $group): ?>
                <div class="radio">
                  <label>
                    <input type="radio" name="pilgroup" id="pilgroup" value="<?php echo $group['id_group'] ?>"> <?php echo $group['nama_group']; ?>
                  </label>
                </div>
              <?php endforeach;  echo form_error('pilgroup');?>
  					</div>
  				</div>
    		</div>
    		<div class="panel-footer">
    			<div class="pull-right">
  					<input type="submit" name="next" id="submit" class="btn btn-primary" value="Lanjutkan">
    			</div>
    		</div>
        <?php echo form_close(); ?>
	    </div>
    </div>

    <script src="<?php echo base_url('assets/js/jquery-1.10.2.min.js'); ?>"></script>

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
