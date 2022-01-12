<div class="container">
  <?php echo $this->session->flashdata('message'); ?>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h4>Set Rules Module</h4>
        </div>
        <div class="panel-footer" style="padding:1px 0;"></div>
        <div class="panel-body collapse in">
          <?php echo form_open(site_url($urlform), array('class' => 'confirm-rules')); ?>
          <div class="clearfix">
						<div class="pull-left form-group clearfix">
              <a data-toggle="modal" href="#myModal" class="btn btn-primary"><i class="fa fa-plus-square"></i> Setting Rules</a>
              <button id="delete_data" class="btn btn-green" type="submit" disabled=""><i class="fa fa-save"></i> Simpan Perubahan</button>
            </div>
					</div>
          <div class="row clearfix">
            <div class="pull-left form-group clearfix col-sm-3">
              <select class="select-all" name="update" id="update">
                <option value="">Pilih Proses</option>
                <option value="AR">Aktfifkan Rules</option>
                <option value="NR">Non Aktifkan Rules</option>
                <option value="DR">Delete Rules</option>
              </select>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-hover table-bordered" cellspacing="0" width="100%" id="tables_checkbox">
            	<thead>
            		<tr>
                  <th width="3%" style="text-align:center;">
                    <input type="checkbox" class="square-blue">
									</th>
            			<th width="3%">No.</th>
                  <th>Nama Fungsi</th>
            			<th width="10%">Status</th>
            		</tr>
            	</thead>
            	<tbody>
              <?php if ($rules_lists == 0) {
                echo '<tr><td colspan="4">Tidak Ada Data</td></tr>';
              } else { ?>
              <?php foreach ($rules_lists as $key => $rules): ?>
                <tr><td colspan="4"><strong>Nama Kontrol : <?php echo $key ?></strong></td></tr>
                <?php $i=1; foreach ($rules as $fungsi => $row): ?>
                <tr>
                  <td style="text-align:center;">
                    <input type="checkbox" class="square-blue checkid" name="checkid[]" value="<?php echo $row['id_rules']; ?>">
									</td>
                  <td><?php echo $i; ?>.</td>
                  <td><?php echo $row['label_fungsi']; ?></td>
                  <td width="10%"><?php echo convert_status($row['status']); ?></td>
                </tr>
                <?php $i++; endforeach; ?>
              <?php endforeach; } ?>
            	</tbody>
            </table>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div><!-- container -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Form Setting Rules</h4>
      </div>
      <?php echo form_open(site_url($urlform), array('class' => 'form-horizontal', 'role' => 'form')); ?>
      <div class="modal-body">
        <div class="form-group">
          <div class="col-sm-12">
            <label for="nama_kontrol">Nama Kontrol</label>
            <?php
              echo form_dropdown('nama_kontrol', $data_kontrol, $this->input->post('nama_kontrol'), 'class="select-all" style="width:100%"');
              echo form_error('nama_kontrol');
            ?>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            <label for="nama_fungsi">Nama Fungsi</label>
            <?php
              echo form_multiselect('nama_fungsi[]', $data_fungsi, $this->input->post('nama_fungsi[]'), 'class="select-all" style="width:100%" data-placeholder="Pilih Data"');
              echo form_error('nama_kontrol');
            ?>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-6">
            <label for="status">Status</label>
            <?php echo form_dropdown('status', status(), $this->input->post('status'), 'class="select-data" style="width:100%"');?>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <input class="btn btn-primary" type="submit" name="save" value="Simpan Data">
      </div>
      <?php echo form_close(); ?>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
