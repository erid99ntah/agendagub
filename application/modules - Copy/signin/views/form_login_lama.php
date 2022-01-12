<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Login | SAKIP</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="initial-scale=1,minimum-scale=1,maximum-scale=1">
    <meta name="description" content="Deskripsi tentang aplikasi">
    <meta name="author" content="Diskominfo Sumbar">
    <meta name="keywords" content="kata kunci" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/styles.css?=121') ?>">
   <!--  <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'> -->
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/favicon.ico') ?>" sizes="32x32">
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/form-select2/select2.css'); ?>" />
  </head>
  <body class="focusedform" style="background-color:#ffffff;">
    <div class="verticalcenter" style="top:40%;left:50%;margin-top:0px;margin-left:0px;transform: translate(-50%, -50%);">
      <a href="<?php echo base_url(); ?>"style="display:none;"><img src="<?php echo base_url('#') ?>" alt="Logo" class="brand" /></a>
      <h1 style="text-align:center;"> <b style="color:rgb(46, 93, 172);">SAKIP</b></h1>
      <h3 style="text-align:center;margin-top:-20px;">Provinsi Sumatera Barat</h3>
  	  <div class="panel panel-success">
    		<div class="panel-body">
    			<h4 class="text-center" style="margin-bottom: 15px;margin-top:-5px;">Selamat Datang</h4>
          <?php echo $this->session->flashdata('message'); ?>
          <?php echo form_open(site_url('signin/login'), array('class' => 'form-horizontal', 'role' => 'form')); ?>
  				<div class="form-group">
  					<div class="col-sm-12">
  						<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
  							<input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo set_value('username'); ?>">
              </div>
              <?php echo form_error('username'); ?>
  					</div>
  				</div>
  				<div class="form-group">
  					<div class="col-sm-12">
  						<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
  							<input type="password" class="form-control" name="password" id="password" placeholder="Password">
  						</div>
              <?php echo form_error('password'); ?>
  					</div>
  				</div>
  			  <?php if(isset($captcha_img)) echo $captcha_img;?>
    		</div>
    		<div class="panel-footer">
    			<div class="pull-right">
            <input type="reset" name="reset" class="btn btn-danger" value="Reset">
  					<input type="submit" name="submit" id="submit" class="btn btn-success" value="Login">
    			</div>
    		</div>
        <?php echo form_close(); ?>
        <p style="text-align:center;color:#A9A9A9;"><?php echo "Hak Cipta ©" . ((date('Y') == "2020") ? "2020" : "2020 - ".date('Y')) . " " . " Team IT Kominfo Prov. Sumbar"; ?></p>
      </div>
    </div>
    <script src="<?php echo base_url('assets/js/jquery-1.10.2.min.js'); ?>"></script>
    <script type='text/javascript' src='<?php echo base_url('assets/plugins/form-select2/select2.min.js');?>'></script>
  	<script type="text/javascript">
      $(".select-data").select2({
        minimumResultsForSearch: Infinity,
        allowClear: false
      });
  		$(function() {
  		  $('#submit').on('click',function() {
  		  	$(this).val("Mencoba Login...");
  		  	$(this).addClass('disabled');
  		    $('#form-login').submit();
  		  });
  		});
    </script>
  </body>
</html>
