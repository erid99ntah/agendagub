<div class="container">
  <?php echo $this->session->flashdata('message'); ?>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-green">
        <div class="panel-heading">
		      <h4>Form Edit identitas</h4>
		    </div>
        <div class="panel-footer" style="padding:1px 0;"></div>
        <?php echo form_open(site_url($urlform), array('class' => 'form-horizontal row-border', 'role' => 'form')); ?>
        <div class="panel-body">
         
          <?php echo form_hidden('identitas', $data_identitas->id_identitas); ?>
				     
          <div class="form-group">
				    <label for="pengelola" class="col-sm-3 control-label">Pengelola</label>
				    <div class="col-sm-6">
				      <input type="text" class="form-control" name="pengelola" id="pengelola" placeholder="Pengelola" 
              value="<?php echo $data_identitas->pengelola; ?>">
              <?php echo form_error('pengelola'); ?>
            </div>
				  </div>
          <div class="form-group">
				    <label for="judul" class="col-sm-3 control-label">Judul</label>
				    <div class="col-sm-6">
				      <input type="text" class="form-control" name="judul" id="judul" placeholder="Sub Judul" value="<?php echo $data_identitas->judul; ?>">
              <?php echo form_error('judul'); ?>
            </div>
				  </div>
          <div class="form-group">
				    <label for="subjudul" class="col-sm-3 control-label">Sub Judul</label>
				    <div class="col-sm-6">
             <input type="text" class="form-control tooltips" name="subjudul" id="subjudul" placeholder="subjudul" value="<?php echo $data_identitas->subjudul; ?>" 
             data-trigger="hover" data-original-title="Sub Judul">              
            </div>
				  </div>          

           <div class="form-group">
            <label for="alamat" class="col-sm-3 control-label">Alamat</label>
            <div class="col-sm-6">
              <textarea class="form-control" name="alamat" id="alamat" rows="3" placeholder="Alamat">
              <?php echo escape($data_identitas->alamat); ?>
              </textarea>
            </div>
          </div>

           <div class="form-group">
            <label for="phone" class="col-sm-3 control-label">Phone</label>
            <div class="col-sm-6">
              <input type="text" class="form-control tooltips" name="phone" id="phone" placeholder="Nama identitas" value="<?php echo $data_identitas->phone; ?>" 
              data-trigger="hover" data-original-title="phone">
            </div>
          </div>

           <div class="form-group">
            <label for="email" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-6">
             <input type="text" class="form-control tooltips" name="nama_identitas" id="email" placeholder="Nama email" value="<?php echo $data_identitas->email; ?>" 
             data-trigger="hover" data-original-title="Nama email">
            </div>
          </div>

           <div class="form-group">
            <label for="renstra_tahun" class="col-sm-3 control-label">Renstra Tahun</label>
            <div class="col-sm-6">
               <input type="text" class="form-control tooltips" name="renstra_tahun" id="renstra_tahun" placeholder="Renstra Tahun" value="<?php echo $data_identitas->renstra_tahun; ?>" 
              data-trigger="hover" data-original-title="Tahun Awal Renstra">
            </div>
          </div>

          <div class="form-group">
            <label for="renstra_tahun_sd" class="col-sm-3 control-label">Renstra Tahun SD</label>
            <div class="col-sm-6">
               <input type="text" class="form-control tooltips" name="renstra_tahun_sd" id="renstra_tahun_sd" placeholder="Renstra Tahun SD" value="<?php echo $data_identitas->renstra_tahun_sd; ?>" 
              data-trigger="hover" data-original-title="Tahun Akhir Renstra">
            </div>
          </div>

          <div class="form-group">
            <label for="tw1" class="col-sm-3 control-label">TW 1</label>
            <div class="col-sm-6">
               <input type="text" class="form-control tooltips" name="tw1" id="tw1" placeholder="tw1" value="<?php echo $data_identitas->tw1; ?>" 
              data-trigger="hover" data-original-title="Triwulan 1">
              <p class="help-block">* 1 = Aktif  , 0=Tidak Aktif</p>
            </div>
          </div>

          <div class="form-group">
            <label for="tw2" class="col-sm-3 control-label">TW 2</label>
            <div class="col-sm-6">
               <input type="text" class="form-control tooltips" name="tw2" id="tw2" placeholder="tw2" value="<?php echo $data_identitas->tw2; ?>" 
              data-trigger="hover" data-original-title="Triwulan 2">
              <p class="help-block">* 1 = Aktif  , 0=Tidak Aktif</p>
            </div>
          </div>

          <div class="form-group">
            <label for="tw3" class="col-sm-3 control-label">TW 3</label>
            <div class="col-sm-6">
               <input type="text" class="form-control tooltips" name="tw3" id="tw3" placeholder="tw3" value="<?php echo $data_identitas->tw3; ?>" 
              data-trigger="hover" data-original-title="Triwulan 3">
              <p class="help-block">* 1 = Aktif  , 0=Tidak Aktif</p>
            </div>
          </div>

          <div class="form-group">
            <label for="tw4" class="col-sm-3 control-label">TW 4</label>
            <div class="col-sm-6">
               <input type="text" class="form-control tooltips" name="tw4" id="tw4" placeholder="tw4" value="<?php echo $data_identitas->tw4; ?>" 
              data-trigger="hover" data-original-title="Triwulan 4">
              <p class="help-block">* 1 = Aktif  , 0=Tidak Aktif</p>
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
