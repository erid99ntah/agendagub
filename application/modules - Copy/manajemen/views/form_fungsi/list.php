<div class="container">
  <?php echo $this->session->flashdata('message'); ?>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h4>Daftar Fungsi</h4>
        </div>
        <div class="panel-footer" style="padding:1px 0;"></div>
        <div class="panel-body collapse in">
          <?php echo form_open(site_url('manajemen/fungsi/delete'), array('class' => 'confirm-delete')); ?>
          <div class="clearfix">
						<div class="pull-left form-group clearfix">
							<a href="<?php echo site_url('manajemen/fungsi/create'); ?>" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah Data</a>
              <button id="delete_data" class="btn btn-danger" type="submit" disabled=""><i class="fa fa-trash-o"></i> Delete</button>
            </div>
					</div>
          <div class="table-responsive">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered basic-datatables" id="tables_checkbox">
              <thead>
                <tr>
                  <th width="3%" style="text-align:center;">
                    <input type="checkbox" class="square-blue">
									</th>
                  <th width="3%">No.</th>
                  <th>Nama Fungsi</th>
                  <th>URL Fungsi</th>
                  <th>Deskripsi</th>
                  <th>Jenis Fungsi</th>
                  <th width="10%">Status</th>
                  <th width="3%">Edit</th>
                </tr>
              </thead>
              <tbody>
                <?php $i=1; foreach ($list_fungsi as $key => $list): ?>
                <tr>
                  <td align="center">
                    <input type="checkbox" class="square-blue checkid" name="checkid[]" value="<?php echo $list->id_fungsi; ?>">
									</td>
                  <td><?php echo $i; ?>.</td>
                  <td><?php echo $list->nama_fungsi; ?></td>
                  <td><?php echo $list->url_fungsi; ?></td>
                  <td><?php echo $list->deskripsi_fungsi; ?></td>
                  <td><?php echo convert_jenis_fungsi($list->id_jenis_fungsi); ?></td>
                  <td><?php echo convert_status($list->id_status); ?></td>
                  <td align="center"><a href="<?php echo site_url('manajemen/fungsi/update/'.$list->id_fungsi.'/'.$list->nama_fungsi); ?>" type="button" class="btn btn-xs btn-orange confirm-edit" title="Edit Data"><i class="fa fa-pencil"></i> </a></td>
                </tr>
                <?php $i++; endforeach; ?>
              </tbody>
            </table>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div><!-- container -->
