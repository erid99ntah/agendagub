<div class="container">
  <?php echo $this->session->flashdata('message'); ?>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-green">
        <div class="panel-heading">
		      <h4>Form Edit Menu</h4>
		    </div>
        <div class="panel-footer" style="padding:1px 0;"></div>
        <?php echo form_open(site_url($urlform), array('class' => 'form-horizontal row-border', 'role' => 'form')); ?>
        <div class="panel-body">
          <div class="form-group">
				    <label for="nama_menu" class="col-sm-3 control-label">Nama Menu</label>
				    <div class="col-sm-6">
              <?php echo form_hidden('menuID', $data_menu->id_menu); ?>
				      <input type="text" class="form-control tooltips" name="nama_menu" id="nama_menu" placeholder="Nama Menu" value="<?php echo $data_menu->title_menu; ?>" data-trigger="hover" data-original-title="Nama menu yang akan digunakan">
              <?php echo form_error('nama_menu'); ?>
            </div>
				  </div>
          <div class="form-group">
				    <label for="label_fungsi" class="col-sm-3 control-label">Type Menu</label>
				    <div class="col-sm-6">
              <?php $pilih1 = ""; $pilih2 = ""; if($data_menu->is_parent == 'Y') $pilih1 = "checked"; else $pilih2 = "checked"; ?>
              <label class="radio-inline">
                <input type="radio" id="type_1" name="is_parent" value="Y" <?php echo $pilih1; ?> > Root Menu
              </label>
              <label class="radio-inline">
                <input type="radio" id="type_2" name="is_parent" value="N" <?php echo $pilih2; ?> > Sub Menu
              </label>
              <?php echo form_error('is_parent'); ?>
            </div>
				  </div>
          <div class="form-group">
				    <label for="parent_id" class="col-sm-3 control-label">Parent Menu</label>
				    <div class="col-sm-3">
              <?php echo form_dropdown('parent_id', $list_parent, $data_menu->parent_id, 'class="select-all"');?>
				    </div>
				  </div>
          <div class="form-group">
				    <label for="id_rules" class="col-sm-3 control-label">Module</label>
				    <div class="col-sm-5">
              <input id="id_rules" name="id_rules" class="form-control" type="hidden" value="<?php echo $data_menu->id_rules; ?>">
              <?php $nama_rules = ""; if($data_menu->id_rules != 0) $nama_rules = $data_menu->url_module.'/'.$data_menu->url_kontrol.'/'.$data_menu->url_fungsi; ?>
              <input id="nama_rules" name="nama_rules" placeholder="Pilih Module" class="form-control" type="text" disabled="" value="<?php echo $nama_rules; ?>">
              <p class="help-block">Module tidak perlu diisi jika <code>Type Menu</code> bukanlah <code>Sub Menu</code></p>
              <?php echo form_error('id_rules'); ?>
            </div>
            <button type="button" class="btn btn-primary-alt" data-toggle="modal" data-target="#myModal"> Select </button>
				  </div>
          <div class="form-group">
				    <label for="url_menu" class="col-sm-3 control-label">URL Menu</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" name="url_menu" id="url_menu" placeholder="URL Menu" value="<?php echo $data_menu->url_menu; ?>" readonly="">
            </div>
				  </div>
          <div class="form-group">
				    <label for="order_menu" class="col-sm-3 control-label">Order Menu</label>
				    <div class="col-sm-2">
				      <input type="text" class="form-control" name="order_menu" id="order_menu" placeholder="Order Menu" value="<?php echo $data_menu->order_menu; ?>">
              <?php echo form_error('order_menu'); ?>
            </div>
				  </div>
          <div class="form-group">
				    <label for="icon_menu" class="col-sm-3 control-label">Icon Menu</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" name="icon_menu" id="icon_menu" placeholder="Icon Menu" value="<?php echo $data_menu->icon_menu; ?>">
              <?php echo form_error('icon_menu'); ?>
            </div>
				  </div>
          <div class="form-group">
				    <label for="status" class="col-sm-3 control-label">Status</label>
				    <div class="col-sm-2">
              <?php echo form_dropdown('status', status(), $data_menu->id_status, 'class="select-data"');?>
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

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Data Rules Module</h4>
      </div>
      <div class="modal-body">
        <table class="table table-striped table-bordered table-hover basic-datatables" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th width="3%">No.</th>
              <th>Module</th>
              <th>Kontrol</th>
              <th>Fungsi</th>
              <th width="5%">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $i=1; foreach ($rules_list as $key => $rule): ?>
              <tr>
                <td><?php echo $i; ?>.</td>
                <td><?php echo $rule->label_module;?></td>
                <td><?php echo $rule->label_kontrol;?></td>
                <td><?php echo $rule->label_fungsi;?></td>
                <td><button class="btn btn-primary btn-xs pilih-module" data-id="<?php echo $rule->id_rules; ?>" data-nm="<?php echo $rule->url_module.'/'.$rule->url_kontrol.'/'.$rule->url_fungsi; ?>"> Select </button></td>
              </tr>
            <?php $i++; endforeach; ?>
          </tbody>
        </table>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">

  $(document).on('change', 'input[type=radio][name=is_parent]', function (e) {
    document.getElementById("id_rules").value = "";
    document.getElementById("nama_rules").value = "";
    if ($("#type_1").is(":checked")) {
      document.getElementById("url_menu").value = "#";
    }
    else if ($("#type_2").is(":checked")) {
      document.getElementById("url_menu").value = "";
    }
  });


  $(document).on('click', '.pilih-module', function (e) {
    document.getElementById("id_rules").value = $(this).attr('data-id');
    document.getElementById("nama_rules").value = $(this).attr('data-nm');
    $('#myModal').modal('hide');
  });
</script>
