<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login | Agenda</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="initial-scale=1,minimum-scale=1,maximum-scale=1">
  <meta name="description" content="Agenda SUMBAR">
  <meta name="author" content="Diskominfo Sumbar">
  <meta name="keywords" content="Agenda SUMBAR" />

  <!-- <link rel="stylesheet" href="<?php echo base_url('assets/signin/style.css') ?>"> -->
  <link rel="stylesheet" href="<?php echo base_url('assets/signin/css/bootstrap.min.css') ?>">
  <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/favicon.ico') ?>" sizes="32x32">
  <link rel="stylesheet" href="<?php echo base_url('assets/fonts/font-awesome/css/font-awesome.min.css'); ?>" />
  <style type="text/css">
    .login-block{
      float:left;
      width:100%;
      padding : 10px 10px 10px 10px;      
      margin-top: 7%;
    }
    body {
      background: #C6C6D3;
    }
    .banner-sec{background:url(<?php echo site_url('images/1.jpg');?>)  no-repeat left bottom; background-size:cover; min-height:500px; border-radius: 0px; padding:0;}
    .carousel-inner{border-radius:0 10px 10px 0;}
    .carousel-caption{text-align:left; left:5%;}
    .login-sec{padding: 50px 30px; position:relative;}
    .login-sec .copy-text{position:absolute; width:80%; bottom:20px; font-size:13px; text-align:center;}
    .login-sec .copy-text i{color:#FEB58A;}
    .login-sec .copy-text a{color:#E36262;}
    .login-sec h2{font-weight:800; font-size:30px; color: #6f42c1;}  
    .bg-indigo{background-color: #6f42c1;color:#fff;}
  </style>
</head>

<body>
    <section class="login-block">
      <div class="container py-5 px-5" style="background:#fff; border-radius:0px;">
        <div class="row">
        <div class="col-md-6 login-sec">
            <h2 class="text-center"> Agenda Pimpinan</h2>
            <p><?php echo $this->session->flashdata('message'); ?></p>
            <?php echo form_open(site_url('signin/login'), array('class' => 'form-horizontal', 'role' => 'form')); ?>
              <div class="form-label-group">
                <label for="inputEmail">Username</label>
                <input type="text" name="username" id="username" placeholder="Isi Username" class="form-control" required>                
                <?php echo form_error('username'); ?>
              </div><br>
              
              <label for="inputPassword">Password</label>
              <div class="input-group mb-3">
                <input type="password" class="form-control" name="password" id="password" placeholder="Isi Password" required>
                <div class="input-group-append">
                  <span class="input-group-text showPass" id="basic-addon1"> <i class="fa fa-eye"></i> </span>
                </div>
                <?php echo form_error('password'); ?>
              </div>
              
              <?php if(isset($captcha_img)) echo $captcha_img;?>             

              <button type="submit" name="submit" id="submit" class="btn btn-success" value="Login"><i class="fa fa-unlock"></i> Login</button> 
              <button type="reset" name="reset" id="reset" class="btn btn-danger" value="Login"><i class="fa fa-refresh"></i> Batal</button> 
             <?php echo form_close(); ?>
            <a href="<?php echo site_url('upload/app-release.apk');?>" class="btn btn-block mt-5 bg-indigo"> Download APK</a>
            <div class="copy-text"><?php echo "Agenda ©" . ((date('Y') == "2020") ? "2020" : "2020 - ".date('Y')) . " " . " - Team IT Kominfo Prov. Sumbar"; ?></div>
          </div>
          <div class="col-md-6 banner-sec d-none d-md-block">
              <div class="banner-text">
                
              </div>
          </div>
      </div>
    
    <!-- <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <h5 class="card-title text-center">Agenda</h5>
            <p><?php echo $this->session->flashdata('message'); ?></p>
            <?php echo form_open(site_url('signin/login'), array('class' => 'form-horizontal', 'role' => 'form')); ?>
              <div class="form-label-group">
                <label for="inputEmail">Username</label>
                <input type="text" name="username" id="username" placeholder="Isi Username" class="form-control" required>                
                <?php echo form_error('username'); ?>
              </div><br>

              <div class="form-label-group">
                <label for="inputPassword">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Isi Password" required>
                
                 <?php echo form_error('password'); ?>
              </div><br>
              
              <?php if(isset($captcha_img)) echo $captcha_img;?>

              
              <input type="reset" name="reset" class="btn btn-danger" value="Reset">
              <input type="submit" name="submit" id="submit" class="btn btn-success" value="Login">
              <hr class="my-4">             
             <?php echo form_close(); ?>
              <p style="text-align:center;color:#A9A9A9;"><?php echo "Agenda ©" . ((date('Y') == "2020") ? "2020" : "2020 - ".date('Y')) . " " . " - Team IT Kominfo Prov. Sumbar"; ?></p>
          </div>
        </div>
      </div>
    </div> -->
  </div>

  <script src="<?php echo base_url('assets/signin/jquery.js'); ?>"></script>   
  <script src="<?php echo base_url('assets/signin/js/bootstrap.bundle.min.js'); ?>"></script>
  <script type="text/javascript">  

  $(document).on('click', '.showPass', function(e) {
            let div = $(this).closest('div.input-group');
            let id  = div.find('input').attr('id');
            if($(this).hasClass('open')) {
                div.find('#'+id).attr('type', 'password');
                $(this).removeClass('open').addClass('closed').html('<i class="fa fa-eye"></i>');
            } else {
                div.find('#'+id).attr('type', 'text');
                $(this).removeClass('closed').addClass('open').html('<i class="fa fa-eye-slash"></i>');
            }
        });

    $(function() {
      $('#submit').on('click',function() {
        $(this).val("Mencoba Login...");
        $(this).addClass('disabled');
        $('#form-login').submit();
      });

      $('#btnspj').on('click',function() {
        $(this).val("Mencoba Login...");
        $(this).addClass('disabled');
        $('#form-login').submit();
      });
    });
  </script>

</body>
</html>
