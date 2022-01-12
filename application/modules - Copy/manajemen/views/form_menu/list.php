<div class="container">
  <?php echo $this->session->flashdata('message'); ?>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h4>Daftar Menu</h4>
        </div>
        <div class="panel-footer" style="padding:1px 0;"></div>
        <div class="panel-body collapse in">
          <div class="clearfix">
							<div class="pull-left form-group clearfix">
								<a href="<?php echo site_url('manajemen/menu/create'); ?>" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah Data</a>
              </div>
					</div>
          <div class="table-responsive">
						<table id="treestables" class="table table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th width="75%">Title Menu</th>
                  <th width="5%" style="text-align:center;">Sort</th>
                  <th width="10%">Status</th>
                  <th width="10%">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  if($list_menu == "")
                    echo '<tr><td colspan="4">Tidak Ada Data Menu</td></tr>';
                  else
                    echo $list_menu;
                ?>
							</tbody>
      		  </table>
					</div>
        </div>
      </div>
    </div>
  </div>
</div><!-- container -->

<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Konfirmasi</h4>
      </div>
      <?php echo form_open(site_url('manajemen/menu/delete')); ?>
      <div class="modal-body">
        <div class="bootbox-body">Benar ingin menghapus data ini ?</div>
        <input type="hidden" id="menuid" name="menuid">
      </div>
      <div class="modal-footer">
        <button class="btn btn-sm btn-danger" data-dismiss="modal">
				  <i class="ace-icon fa fa-times"></i> Batal
			  </button>
				<button class="btn btn-sm btn-primary" type="submit" id="delete">
					<i class="ace-icon fa fa-check"></i> Ya, Hapus
				</button>
      </div>
      <?php echo form_close(); ?>
		</div>
	</div>
</div>

<script type="text/javascript">
  $('#treestables').treetable({ expandable: true }).treetable('expandAll');

  $(document).on('click', '.delete_menu', function (e) {
    e.preventDefault();
    var id = $(this).closest("tr").attr("data-tt-id");
    document.getElementById("menuid").value = id;
    $("#modal-delete").modal();
  });
</script>
