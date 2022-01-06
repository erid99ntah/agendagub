<div class="container">
  <?php echo $this->session->flashdata('message'); ?>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-midnightblue">
        <div class="panel-heading">
		      <h4>Form Edit Pengguna</h4>
		    </div>
        <div class="panel-footer" style="padding:1px 0;"></div>
        <?php echo form_open(site_url($urlform), array('class' => 'form-horizontal row-border', 'role' => 'form')); ?>
        <div class="panel-body">
          <div class="form-group">
				    <label for="username" class="col-sm-3 control-label">Username</label>
				    <div class="col-sm-4">
              <?php echo form_hidden('users', $this->encryption->encrypt($data_users['id_users'])); ?>
              <?php echo form_hidden('token', $data_users['token']); ?>
				      <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $data_users['username']; ?>">
              <?php echo form_error('username'); ?>
            </div>
				  </div>
          <div class="form-group">
            <label for="nama_user" class="col-sm-3 control-label">Nama Lengkap</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="nama_user" id="nama_user" placeholder="Nama Lengkap" value="<?php echo $data_users['nama_user']; ?>">
              <?php echo form_error('nama_user'); ?>
            </div>
          </div>
          <div class="form-group">
            <label for="email" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $data_users['email']; ?>">
              <?php echo form_error('email'); ?>
            </div>
          </div>
          <div class="form-group">
				    <label for="password" class="col-sm-3 control-label">Password</label>
				    <div class="col-sm-3">
				      <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo set_value('password'); ?>">
              <?php echo form_error('password'); ?>
            </div>
				  </div>
          <div class="form-group">
				    <label for="conf_password" class="col-sm-3 control-label">Ulangi Password</label>
				    <div class="col-sm-3">
				      <input type="password" class="form-control" name="conf_password" id="conf_password" placeholder="Ulangi Password" value="<?php echo set_value('conf_password'); ?>">
              <?php echo form_error('conf_password'); ?>
            </div>
				  </div>
          <div class="form-group">
            <label for="nama_group" class="col-sm-3 control-label">Pilih Group</label>
            <?php
              $groups = explode(',', $data_users['group_user']);
              $tot = count($group_list); $list = ceil($tot/4);
              if($tot<4) $max = $tot; else $max = 4;
              for($i=0;$i<$max;$i++){
                $a = $list*$i; $b = $list+($list*$i);
                if($b>$tot) $b = $tot;
              ?>
              <div class="col-sm-2">
                <?php
                  for($j=$a;$j<$b;$j++){
                    if(in_array($group_list[$j]['id_group'], $groups)) $cek = "checked"; else $cek = "";
                ?>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="nama_group[]" id="nama_group" value="<?php echo $group_list[$j]['id_group']; ?>" <?php echo $cek; ?>>
                    <?php echo $group_list[$j]['nama_group']; ?>
                  </label>
                </div>
                <?php } ?>
              </div>
            <?php } echo form_error('nama_group[]'); ?>
				  </div>
          <div class="form-group">
				    <label for="status" class="col-sm-3 control-label">Blokir</label>
				    <div class="col-sm-2">
              <?php echo form_dropdown('blokir', blokir(), $data_users['blokir'], 'class="select-data"');?>
				    </div>
				  </div>
          <div class="form-group">
				    <label for="status" class="col-sm-3 control-label">Status</label>
            <div class="col-sm-2">
              <?php echo form_dropdown('status', status(), $data_users['id_status'], 'class="select-data"');?>
            </div>
				  </div>
        </div>
        <div class="panel-footer">
	      	<div class="row">
	      		<div class="col-sm-6 col-sm-offset-3">
	      			<div class="btn-toolbar">
                <input class="btn-primary btn" type="submit" name="save" id="save" value="Simpan Data">
                <a href="javascript:history.back()" class="btn-default btn">Batal</a>
	      			</div>
	      		</div>
	      	</div>
		    </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div><!-- container -->
