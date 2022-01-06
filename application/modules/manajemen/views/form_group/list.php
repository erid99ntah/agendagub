<div class="container">
  <?php echo $this->session->flashdata('message'); ?>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h4>Daftar Group</h4>
        </div>
        <div class="panel-footer" style="padding:1px 0;"></div>
        <div class="panel-body collapse in">
          <?php echo form_open(site_url('manajemen/group/delete'), array('class' => 'confirm-delete')); ?>
          <div class="clearfix">
						<div class="pull-left form-group clearfix">
							<a href="<?php echo site_url('manajemen/group/create'); ?>" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah Data</a>
              <button id="delete_data" class="btn btn-danger" type="submit" disabled=""><i class="fa fa-trash-o"></i> Delete</button>
            </div>
					</div>
          <div class="table-responsive">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered basic-datatables" id="tables_checkbox">
              <thead>
                <tr>
                  <th width="3%" align="center">
                    <input type="checkbox" class="square-blue">
									</th>
                  <th width="3%">No.</th>
                  <th width="15%">Nama Grup</th>
                  <th width="15%">Level Akses</th>
                  <th>Hak Akses</th>
                  <th width="10%">Status</th>
                  <th width="8%">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $i=1; foreach ($list_group as $key => $list): ?>
                <tr>
                  <td align="center">
                    <input type="checkbox" class="square-blue checkid" name="checkid[]" value="<?php echo $list->id_group; ?>">
									</td>
                  <td><?php echo $i; ?>.</td>
                  <td><?php echo $list->nama_group; ?></td>
                  <td><?php echo convert_level_akses($list->id_level_akses); ?></td>
                  <td><?php echo $list->hak_akses;?></td>
                  <td><?php echo convert_status($list->id_status); ?></td>
                  <td align="center">
                    <a href="<?php echo site_url('manajemen/group/update/'.$list->id_group.'/'.str_replace(' ','-',strtolower($list->nama_group))); ?>" type="button" class="btn btn-xs btn-orange confirm-edit" title="Edit Data"><i class="fa fa-pencil"></i> </a>
                    <a href="<?php echo site_url('manajemen/group/privileges/'.$list->id_group.'/'.str_replace(' ','-',strtolower($list->nama_group))); ?>" type="button" class="btn btn-xs btn-green" title="Setting Privilege"><i class="fa fa-lock"></i> </a>
                  </td>
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
