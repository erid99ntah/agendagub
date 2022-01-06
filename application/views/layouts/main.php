<?php
  $timeout = $this->expired_login->login_check();
  if($timeout === FALSE) {
    redirect('signin/timeout');
    exit();
  }
?>
<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php echo $template['partials']['header']; ?>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
  	<!--[if lt IE 9]>
          <link rel="stylesheet" href="assets/css/ie8.css">
  		<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
          <script type="text/javascript" src="assets/plugins/charts-flot/excanvas.min.js"></script>
  	<![endif]-->

  </head>
  <body class="" onload="updateClock()">
    <?php echo $template['partials']['title']; ?>
    <div id="page-container">
    	<?php echo $template['partials']['navigation']; ?>
      <!-- Content Wrapper. Contains page content -->
      <div id="page-content" style="background:#FFFFFF;">
        <div id='wrap'>
          <div id="page-heading" style="background:#FFFFFF;">
            <?php echo $this->breadcrumb->output(); ?><!-- /.breadcrumb -->
            <h1><?php echo $page_name; ?></h1>
            <div class="options">
              <div class="btn-toolbar">
                <h3 style="text-align:right;"><?php echo strtoupper($this->app_loader->current_group_name()); ?></h3>
                <p style="margin-top:-15px;font-size:16px;text-align:right;" id="showtime"><?php echo tgl_surat(date('Y-m-d H:i:s')); ?></p>
              </div>
            </div>
          </div>
    	    <?php echo $template['body']; ?>
        </div><!--wrap -->
      </div><!-- page-content -->
    	<?php echo $template['partials']['footer']; ?>
    </div>
    <?php echo $template['partials']['javascript']; ?>
  </body>
</html>
