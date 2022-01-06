<!-- BEGIN SIDEBAR -->
<nav id="page-leftbar" role="navigation">
  <!-- BEGIN SIDEBAR MENU -->
  <ul class="acc-menu" id="sidebar">
    <li id="search"></li>
    <?php echo $this->app_loader->create_menu(); ?>
    <li><a href="<?php echo site_url('signin/logout');?>"><i class="fa fa-power-off"></i> <span> Logout</span></a></li>
  </ul>
</nav>
<!-- END SIDEBAR MENU -->
