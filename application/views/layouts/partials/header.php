<title><?php echo $page_name . " | " . $app_name;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,">
<meta name="viewport" content="initial-scale=1, minimum-scale=1, maximum-scale=1, width=device-width, height=device-height, user-scalable=yes">
<meta name="description" content="Helpdesk Provinsi Sumatera Barat">
<meta name="author" content="Diskominfo Sumbar">
<meta name="keywords" content="Helpdesk, Helpdesk Sumbar" />
<link rel="icon" type="image/png" href="<?php echo base_url('assets/img/favicon.ico') ?>" sizes="32x32">
<link rel="stylesheet" href="<?php echo base_url('assets/css/styles.css?=121'); ?>" />
<link rel="stylesheet" href="<?php echo base_url('assets/demo/variations/header-blue.css'); ?>" />
<link rel="stylesheet" href="<?php echo base_url('assets/demo/variations/sidebar-steel.css'); ?>" />
<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600" /> -->
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/form-markdown/css/bootstrap-markdown.min.css'); ?>" />
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/datatables/css/dataTables.bootstrap.css'); ?>" />
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/codeprettifier/prettify.css'); ?>" />
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/form-select2/select2.css'); ?>" />
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/form-multiselect/css/multi-select.css'); ?>" />
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/icheck/skins/all.css'); ?>" />
<link rel='stylesheet' href="<?php echo base_url('assets/js/jqueryui.css'); ?>" />
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/tree-table/css/jquery.treetable.cs'); ?>s" />
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/tree-table/css/jquery.treetable.theme.default.css'); ?>" />
<link rel="stylesheet" href="<?php echo base_url('assets/fonts/font-awesome/css/font-awesome.min.css'); ?>" />
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/waitme/waitMe.css'); ?>" />
<!--<script type="text/javascript" src="assets/js/less.js"></script>-->
<style media="screen">
  .toUpperCase {text-transform: uppercase;}
  .unread {font-weight: bold;}
  .read{font-weight: normal;}
  #paging a.btnPage:hover{
    background-color: #eee;
    border-radius: 50%;
  }
  .option:hover{
    background-color: #eee;
    border-radius: 3px;
  }
  a.delete:hover{
    background-color: #eee;
    border-radius: 50%;
  }
  #paging a.pagination-info:hover{
    background-color: #eee;
    border-radius: 5px;
  }
  a.more:hover{
    background-color: #eee;
    border-radius: 50%;
  }
  .table-hover > tbody > tr:hover > td {
    cursor: pointer;
    -moz-box-shadow: 2px 2px 2px 0 rgba(0, 0, 0, 0.5);
    -webkit-box-shadow: 2px 2px 2px 0 rgba(0, 0, 0, 0.5);
    box-shadow: 2px 2px 2px 0 rgba(0, 0, 0, 0.5);
  }
  .table-hover > tbody > tr:hover > td:first-child {
    -moz-box-shadow: 2px 2px 2px 0 rgba(0, 0, 0, 0.5);
    -webkit-box-shadow: 2px 2px 2px 0 rgba(0, 0, 0, 0.5);
    box-shadow: 2px 2px 2px 0 rgba(0, 0, 0, 0.5);
  }
  .table-hover > tbody > tr:hover > td:last-child {
    -moz-box-shadow: 2px 2px 2px 0 rgba(0, 0, 0, 0.5);
    -webkit-box-shadow: 2px 2px 2px 0 rgba(0, 0, 0, 0.5);
    box-shadow: 2px 2px 2px 0 rgba(0, 0, 0, 0.5);
  }
</style>
<script type='text/javascript' src='<?php echo base_url('assets/js/jquery-1.10.2.min.js');?>'></script>
<script type='text/javascript' src='<?php echo base_url('assets/js/jqueryui-1.10.3.min.js');?>'></script>
<script type='text/javascript' src='<?php echo base_url('assets/js/bootstrap.min.js');?>'></script>
<script type='text/javascript' src='<?php echo base_url('assets/js/enquire.js');?>'></script>
<script type='text/javascript' src='<?php echo base_url('assets/js/jquery.cookie.js');?>'></script>
<script type='text/javascript' src='<?php echo base_url('assets/js/jquery.nicescroll.min.js');?>'></script>
<script type='text/javascript' src='<?php echo base_url('assets/plugins/codeprettifier/prettify.js');?>'></script>
<script type='text/javascript' src='<?php echo base_url('assets/plugins/datatables/js/jquery.dataTables.min.js');?>'></script>
<script type='text/javascript' src='<?php echo base_url('assets/plugins/datatables/js/dataTables.bootstrap.js');?>'></script>
<script type='text/javascript' src='<?php echo base_url('assets/plugins/form-datepicker/js/bootstrap-datepicker.js');?>'></script>
<script type='text/javascript' src='<?php echo base_url('assets/plugins/form-select2/select2.min.js');?>'></script>
<script type='text/javascript' src='<?php echo base_url('assets/plugins/form-multiselect/js/jquery.multi-select.min.js');?>'></script>
<script type='text/javascript' src='<?php echo base_url('assets/plugins/form-validator/js/jquery.form-validator.min.js');?>'></script>
<script type='text/javascript' src='<?php echo base_url('assets/plugins/form-inputmask/jquery.inputmask.bundle.min.js');?>'></script>
<script type='text/javascript' src='<?php echo base_url('assets/plugins/bootbox/bootbox.min.js');?>'></script>
<script type='text/javascript' src='<?php echo base_url('assets/plugins/icheck/icheck.js');?>'></script>
<script type='text/javascript' src='<?php echo base_url('assets/plugins/tree-table/jquery.treetable.js');?>'></script>
<script type='text/javascript' src='<?php echo base_url('assets/plugins/waitme/waitMe.js');?>'></script>
<script type='text/javascript' src='<?php echo base_url('assets/js/placeholdr.js');?>'></script>
<script type='text/javascript' src='<?php echo base_url('assets/js/application.js');?>'></script>
<script type='text/javascript' src='<?php echo base_url('assets/js/table-application.js');?>'></script>
<script type='text/javascript' src='<?php echo base_url('assets/js/jquery-app.js');?>'></script>
<script type='text/javascript' src='<?php echo base_url('assets/editor/tinymce/tinymce.min.js');?>'></script>
<!--<script type='text/javascript' src='<?php //echo base_url('assets/editor/setting.tinymce.js');?>'></script>-->
<!-- <script src="https://js.pusher.com/5.1/pusher.min.js"></script> -->
