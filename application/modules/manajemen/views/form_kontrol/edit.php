<div class="container">
  <?php echo $this->session->flashdata('message'); ?>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-heading">
		      <h4>Form Edit Kontrol</h4>
		    </div>
        <div class="panel-footer" style="padding:1px 0;"></div>
        <?php echo form_open(site_url($urlform), array('class' => 'form-horizontal row-border', 'role' => 'form')); ?>
        <div class="panel-body">
          <div class="form-group">
				    <label for="nama_kontrol" class="col-sm-3 control-label">Nama Kontrol</label>
				    <div class="col-sm-6">
              <?php echo form_hidden('kontrol', $data_kontrol->id_kontrol); ?>
				      <input type="text" class="form-control tooltips" name="nama_kontrol" id="nama_kontrol" placeholder="Nama Kontrol" value="<?php echo $data_kontrol->nama_kontrol; ?>" data-trigger="hover" data-original-title="Nama Kontrol adalah nama class/controller yang digunakan didalam modules">
              <?php echo form_error('nama_kontrol'); ?>
            </div>
				  </div>
          <div class="form-group">
				    <label for="label_kontrol" class="col-sm-3 control-label">Label Kontrol</label>
				    <div class="col-sm-6">
				      <input type="text" class="form-control" name="label_kontrol" id="label_kontrol" placeholder="Label Kontrol" value="<?php echo $data_kontrol->label_kontrol; ?>">
              <?php echo form_error('label_kontrol'); ?>
            </div>
				  </div>
          <div class="form-group">
				    <label for="url_kontrol" class="col-sm-3 control-label">URL Kontrol</label>
				    <div class="col-sm-6">
				      <input type="text" class="form-control" name="url_kontrol" id="url_kontrol" placeholder="URL Kontrol" value="<?php echo $data_kontrol->url_kontrol; ?>">
              <?php echo form_error('url_kontrol'); ?>
            </div>
				  </div>
          <div class="form-group">
				    <label for="deskripsi_kontrol" class="col-sm-3 control-label">Deskripsi kontrol</label>
				    <div class="col-sm-6">
              <textarea class="form-control" name="deskripsi_kontrol" id="deskripsi_kontrol" rows="3" placeholder="Deskripsi kontrol"><?php echo $data_kontrol->deskripsi_kontrol; ?></textarea>
            </div>
				  </div>
          <div class="form-group">
				    <label for="status" class="col-sm-3 control-label">Status</label>
				    <div class="col-sm-2">
              <?php echo form_dropdown('status', status(), $data_kontrol->id_status, 'class="select-data"');?>
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
