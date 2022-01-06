<div class="container">
  <?php echo $this->session->flashdata('message'); ?>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-heading">
		      <h4>Form Edit Fungsi</h4>
		    </div>
        <?php echo form_open(site_url($urlform), array('class' => 'form-horizontal row-border', 'role' => 'form')); ?>
        <div class="panel-body">
          <div class="form-group">
				    <label for="nama_fungsi" class="col-sm-3 control-label">Nama Fungsi</label>
				    <div class="col-sm-6">
              <?php echo form_hidden('fungsi', $data_fungsi->id_fungsi); ?>
				      <input type="text" class="form-control tooltips" name="nama_fungsi" id="nama_fungsi" placeholder="Nama Fungsi" value="<?php echo $data_fungsi->nama_fungsi; ?>" data-trigger="hover" data-original-title="Nama Fungsi adalah nama method/fungsi yang digunakan didalam class/control">
              <?php echo form_error('nama_fungsi'); ?>
            </div>
				  </div>
          <div class="form-group">
				    <label for="label_fungsi" class="col-sm-3 control-label">Label Fungsi</label>
				    <div class="col-sm-6">
				      <input type="text" class="form-control" name="label_fungsi" id="label_fungsi" placeholder="Label Fungsi" value="<?php echo $data_fungsi->label_fungsi; ?>">
              <?php echo form_error('label_fungsi'); ?>
            </div>
				  </div>
          <div class="form-group">
				    <label for="url_fungsi" class="col-sm-3 control-label">URL Fungsi</label>
				    <div class="col-sm-6">
				      <input type="text" class="form-control" name="url_fungsi" id="url_fungsi" placeholder="URL Fungsi" value="<?php echo $data_fungsi->url_fungsi; ?>">
              <?php echo form_error('url_fungsi'); ?>
            </div>
				  </div>
          <div class="form-group">
				    <label for="deskripsi_fungsi" class="col-sm-3 control-label">Deskripsi Fungsi</label>
				    <div class="col-sm-6">
              <textarea class="form-control" name="deskripsi_fungsi" id="deskripsi_fungsi" rows="3" placeholder="Deskripsi Fungsi"><?php echo $data_fungsi->deskripsi_fungsi; ?></textarea>
            </div>
				  </div>
          <div class="form-group">
				    <label for="jenis_fungsi" class="col-sm-3 control-label">Jenis Fungsi</label>
				    <div class="col-sm-3">
              <?php
                echo form_dropdown('jenis_fungsi', $jenis_fungsi, $data_fungsi->id_jenis_fungsi, 'class="select-all"');
                echo form_error('jenis_fungsi');
              ?>
				    </div>
				  </div>
          <div class="form-group">
				    <label for="status" class="col-sm-3 control-label">Status</label>
            <div class="col-sm-2">
              <?php echo form_dropdown('status', status(), $data_fungsi->id_status, 'class="select-data"');?>
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
