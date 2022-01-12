<div class="container">
  <?php echo $this->session->flashdata('message'); ?>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-green">
        <div class="panel-heading">
		      <h4>Form Input Instansi</h4>
		    </div>
        <div class="panel-footer" style="padding:1px 0;"></div>
        <?php echo form_open(site_url($urlform), array('class' => 'form-horizontal row-border', 'role' => 'form')); ?>
        <div class="panel-body">
          <div class="form-group">
				    <label for="nm_opd" class="col-sm-3 control-label">Nama Instansi</label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control tooltips" name="nm_opd" id="nm_opd" placeholder="Nama Instansi" value="<?php echo set_value('nm_opd'); ?>" data-trigger="hover" data-original-title="Nama Instansi yang akan digunakan">
              <?php echo form_error('nm_opd'); ?>
            </div>
				  </div>
         
          <div class="form-group">
				    <label for="parent_id" class="col-sm-3 control-label">Parent Menu</label>
				    <div class="col-sm-3">
              <select name="parent_id" class="form-control">
                <?php
                  if ($parentID==0) {
                    echo '<option value="0">Instansi Baru</option>';
                  }
                  else{
                    echo '<option value="'.$parentID.'"> '.$nm_instansi.'</option>'; 
                  }
                ?>
              </select>
				    </div>
				  </div>
         
          <div class="form-group">
				    <label for="order_no" class="col-sm-3 control-label">Order Menu</label>
				    <div class="col-sm-2">
				      <input type="number" min="1" class="form-control" name="order_no" id="order_no" placeholder="Order No" value="<?php echo set_value('order_no'); ?>">
              <?php echo form_error('order_no'); ?>
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

