<header class="navbar navbar-inverse navbar-fixed-top" role="banner">
  <a id="leftmenu-trigger" class="tooltips" data-toggle="tooltip" data-placement="right" title="Toggle Sidebar"></a>
  <div class="navbar-header pull-left">
    <a class="navbar-brand" href="<?php echo site_url('home'); ?>"><?php echo $app_name; ?></a>
  </div>

  <ul class="nav navbar-nav pull-right toolbar">
    <li class="dropdown">
    	<a href="#" class="dropdown-toggle username" data-toggle="dropdown">
        <span class="hidden-xs"><?php echo $this->app_loader->current_name(); ?> <i class="fa fa-caret-down"></i></span>
        <img src="<?php echo base_url('assets/img/avatar/default.png'); ?>" alt="" />
      </a>
    	<ul class="dropdown-menu userinfo arrow">
  			<li class="username">
          <a href="#">
  				  <div class="pull-left"><img src="<?php echo base_url('assets/img/avatar/default.png'); ?>" alt=""/></div>
  				  <div class="pull-right"><h5>Hallo, <?php echo $this->app_loader->current_nickname(); ?>!</h5><small><span><?php echo $this->app_loader->current_account(); ?></span></small></div>
          </a>
  			</li>
  			<li class="userlinks">
  				<ul class="dropdown-menu">
            <?php
            $list_group = $this->session->userdata('group_switch');
            if (!empty($list_group)) {
              foreach ($list_group as $list) {
                echo '<li><a href="'.site_url('signin/switch-group/'.$list['id_group']).'">' . $list['nama_group'] . '</a></li>';
              }
              echo '<li class="divider"></li>';
            }
            ?>
  					<li><a href="#">Edit Profile <i class="pull-right fa fa-pencil"></i></a></li>
  					<li><a href="#">Account <i class="pull-right fa fa-cog"></i></a></li>
  					<li><a href="#">Help <i class="pull-right fa fa-question-circle"></i></a></li>
  					<li class="divider"></li>
  					<li><a href="<?php echo site_url('signin/logout') ?>" class="text-right">Sign Out</a></li>
  				</ul>
  			</li>
    	</ul>
    </li>

    <li>
      <a href="<?php echo site_url(); ?>"><span><i class="fa fa-home"></i></span></a>
    </li>
    <!-- <li>
      <a>Tahun Anggaran <?php //echo $this->app_loader->current_tahun(); ?></a>
    </li> -->
	</ul>
</header>
