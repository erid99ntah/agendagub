<div class="container">
  <?php echo $this->session->flashdata('message'); ?>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-heading">
		      <h4>Form Cetak Agenda</h4>
		    </div>
        <div class="panel-footer" style="padding:1px 0;"></div>
        <?php echo form_open(site_url('dokumen/lap/export'), array('class' => 'form-horizontal row-border', 'role' => 'form')); ?>
        <div class="panel-body">
          

          <div class="form-group">
				    <label for="jenis_agenda" class="col-sm-3 control-label">Jenis Agenda</label>
				    <div class="col-sm-6">
				      <?php echo form_dropdown('jenis_agenda', array( 'P'=>'Agenda Pimpinan'), $this->input->post('jenis_agenda'), 'class="select-all"');?>
              <?php echo form_error('jenis_agenda'); ?>
            </div>
				  </div>

           <div class="form-group">
            <label for="jenis_agenda" class="col-sm-3 control-label">Penerima Agenda</label>
            <div class="col-sm-6">
               <?php echo form_dropdown('penerima', $data_penerima, $this->input->post('penerima', TRUE), 'class="select-all" id="penerima"'); ?>
              <?php echo form_error('jenis_agenda'); ?>
            </div>
          </div>

          <div class="form-group">
				    <label for="tanggal" class="col-sm-3 control-label">Bulan</label>
				    <div class="col-sm-6">
				      <input type="text" class="form-control datepicker" name="tanggal" id="tanggal" placeholder="Tanggal Kegiatan" value="<?php echo date('Y-m-d');?>">                    
              <?php echo form_error('tanggal'); ?>
            </div>
				  </div>
          <div class="form-group">
				    <label for="url_fungsi" class="col-sm-3 control-label">Jenis Dokumen</label>
				    <div class="col-sm-6">
				       <?php echo form_dropdown('jenis_dokumen', array('pdf'=>'PDF'), 'pdf', 'class="select-all"');?>
              <?php echo form_error('url_fungsi'); ?>
            </div>
				  </div>
        
       
        </div>
        <div class="panel-footer">
	      	<div class="row">
	      		<div class="col-sm-6 col-sm-offset-3">
	      			<div class="btn-toolbar">
                <input class="btn-primary btn" type="submit" name="save" id="save" value="Cetak">
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

<script type="text/javascript"src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
 $('.datepicker').datepicker({
        format: "yyyy-mm-dd"
    });
</script>