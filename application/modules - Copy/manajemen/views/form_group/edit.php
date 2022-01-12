<div class="container">
  <?php echo $this->session->flashdata('message'); ?>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-heading">
		      <h4>Form Edit Group</h4>
		    </div>
        <div class="panel-footer" style="padding:1px 0;"></div>
        <?php echo form_open(site_url($urlform), array('class' => 'form-horizontal row-border', 'role' => 'form')); ?>
        <div class="panel-body">
          <div class="form-group">
				    <label for="nama_group" class="col-sm-3 control-label">Nama Grup</label>
				    <div class="col-sm-6">
              <?php echo form_hidden('groupid', $data_group->id_group) ?>
				      <input type="text" class="form-control tooltips" name="nama_group" id="nama_group" placeholder="Nama Grup" value="<?php echo $data_group->nama_group; ?>" data-trigger="hover" data-original-title="Nama grup yang akan digunakan">
              <?php echo form_error('nama_group'); ?>
            </div>
				  </div>
          <div class="form-group">
				    <label for="level_akses" class="col-sm-3 control-label">Level Akses</label>
				    <div class="col-sm-3">
              <?php
                echo form_dropdown('level_akses', $level_akses, $data_group->id_level_akses, 'class="select-all"');
                echo form_error('level_akses');
              ?>
				    </div>
				  </div>
          <div class="form-group">
				    <label for="status" class="col-sm-3 control-label">Status</label>
				    <div class="col-sm-2">
              <?php echo form_dropdown('status', status(), $data_group->id_status, 'class="select-data"');?>
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
