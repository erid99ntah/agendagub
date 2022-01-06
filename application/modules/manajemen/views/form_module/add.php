<div class="container">
  <?php echo $this->session->flashdata('message'); ?>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-heading">
		      <h4>Form Input Module</h4>
		    </div>
        <div class="panel-footer" style="padding:1px 0;"></div>
        <?php echo form_open(site_url('manajemen/module/create'), array('class' => 'form-horizontal row-border', 'role' => 'form')); ?>
        <div class="panel-body">
          <div class="form-group">
				    <label for="nama_module" class="col-sm-3 control-label">Nama Module</label>
				    <div class="col-sm-6">
				      <input type="text" class="form-control tooltips" name="nama_module" id="nama_module" placeholder="Nama Module" value="<?php echo set_value('nama_module'); ?>" data-trigger="hover" data-original-title="Nama Module adalah nama modules yang digunakan">
              <?php echo form_error('nama_module'); ?>
            </div>
				  </div>
          <div class="form-group">
				    <label for="label_module" class="col-sm-3 control-label">Label Module</label>
				    <div class="col-sm-6">
				      <input type="text" class="form-control" name="label_module" id="label_module" placeholder="Label Module" value="<?php echo set_value('label_module'); ?>">
              <?php echo form_error('label_module'); ?>
            </div>
				  </div>
          <div class="form-group">
				    <label for="url_module" class="col-sm-3 control-label">URL Module</label>
				    <div class="col-sm-6">
				      <input type="text" class="form-control" name="url_module" id="url_module" placeholder="URL Module" value="<?php echo set_value('url_module'); ?>">
              <?php echo form_error('url_module'); ?>
            </div>
				  </div>
          <div class="form-group">
				    <label for="deskripsi_module" class="col-sm-3 control-label">Deskripsi Module</label>
				    <div class="col-sm-6">
              <textarea class="form-control" name="deskripsi_module" id="deskripsi_module" rows="3" placeholder="Deskripsi Module"><?php echo set_value('deskripsi_module'); ?></textarea>
              <?php echo form_error('deskripsi_module'); ?>
            </div>
				  </div>
          <div class="form-group">
				    <label for="status" class="col-sm-3 control-label">Status</label>
				    <div class="col-sm-2">
              <?php echo form_dropdown('status', status(), $this->input->post('status'), 'class="select-data"');?>
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
