<div class="container">
  <?php echo $this->session->flashdata('message'); ?>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-green">
        <div class="panel-heading">
          <h4>Daftar Pengguna</h4>
        </div>
        <div class="panel-footer" style="padding:1px 0;"></div>
        <div class="panel-body collapse in">
          <div class="row" style="background:#D1F2EB;">
            <div class="col-xs-12 col-md-12" style="margin-top:-10px;margin-bottom:20px;">
              <?php echo form_open(site_url('#'), array('role' => 'form', 'id' => 'formParam')); ?>
              <div class="form-group">
                <div class="col-xs-12 col-md-2">
                  <label style="font-size:16px;"><b>Filter Level</b></label>
                  <?php echo form_dropdown('level', $data_level, $this->input->post('level'), 'class="select-all param" id="level" style="width:100%"');?>
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-12 col-md-3">
                  <label style="font-size:16px;"><b>Filter Daerah</b></label>
                  <?php echo form_dropdown('regency', $data_regency, $this->input->post('regency'), 'class="select-all param" id="regency" style="width:100%"');?>
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-12 col-md-3">
                  <label style="font-size:16px;"><b>Filter RS Rujukan</b></label>
                  <?php echo form_dropdown('rsud', $data_rsud, $this->input->post('rsud'), 'class="select-all param" id="rsud" style="width:100%"');?>
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-12 col-md-2">
                  <label style="font-size:16px;"><b>Filter Blokir</b></label>
                  <?php echo form_dropdown('blokir', array(''=>'Pilih Data', 1=>'Blokir', 0=>'Tidak Blokir'), $this->input->post('blokir'), 'class="select-all param" id="blokir" style="width:100%"');?>
                </div>
              </div>
              <div class="form-group">
                <div class="col-xs-12 col-md-2">
                  <label style="font-size:16px;"><b>Filter Status</b></label>
                  <?php echo form_dropdown('status', array(''=>'Pilih Data', 1=>'Aktif', 0=>'Tidak Aktif'), $this->input->post('status'), 'class="select-all param" id="status" style="width:100%"');?>
                </div>
              </div>
              <?php echo form_close(); ?>
            </div>
          </div>
          <?php echo form_open(site_url('manajemen/users/delete'), array('class' => 'confirm-delete')); ?>
          <div class="clearfix" style="margin-top:20px;">
						<div class="pull-left form-group clearfix">
							<a href="<?php echo site_url('manajemen/users/create'); ?>" class="btn btn-primary"><i class="fa fa-plus-square"></i> Tambah Data</a>
              <button id="deleteData" class="btn btn-danger" type="submit" disabled=""><i class="fa fa-trash-o"></i> Delete</button>
            </div>
					</div>
          <div class="table-responsive">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="listuser" width="100%">
              <thead>
                <tr>
                  <th width="3%"><input type="checkbox" id="check-all"></th>
                  <th width="3%">No.</th>
                  <th width="34%">Pengguna</th>
                  <th with="15%">Group</th>
                  <th with="15%">Regency</th>
                  <th with="15%">RS Rujukan</th>
                  <th width="5%">Blokir</th>
                  <th width="7%">Status</th>
                  <th width="3%">Edit</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div><!-- container -->

<script type="text/javascript">
  var csrfName  = '<?php echo $this->security->get_csrf_token_name(); ?>';
  var site      = '<?php echo site_url();?>';
  $(document).ready(function(e){
    getDataPengguna();
  });

  $(document).on('change', '.param', function(e){
    e.preventDefault();
    getDataPengguna();
  });

  function getDataPengguna() {
    $('#listuser').dataTable({
      "destroy": true,
      "processing":true,
      "language": {
        "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
      },
      "serverSide": true,
      "ordering": false,
      "ajax": {
        "url": site + "manajemen/users/listview",
        "type": "POST",
        "data": {
          "param" : $('#formParam').serializeArray(),
          "<?php echo $this->security->get_csrf_token_name(); ?>" : $('input[name="'+csrfName+'"]').val()
        },
      },
      "columnDefs": [
        {
          "targets": [ 0 ], //first column
          "orderable": false, //set not orderable
        },
        {
          "targets": [ -1 ], //last column
          "orderable": false, //set not orderable
        },
      ],
    });
    $('#listuser_filter input').addClass('form-control').attr('placeholder','Search Data');
    $('#listuser_length select').addClass('form-control');
  }

  // Handle click on "Select all" control
  $(document).on('click', '#check-all', function(){
    var row = this;
    $('#listuser > tbody input[type=checkbox]').prop('checked', this.checked);
    if(this.checked)
      document.getElementById("deleteData").disabled = false;
    else
      document.getElementById("deleteData").disabled = true;
  });

  // Handle click on "Select all" control
  $(document).on('click', '#listuser > tbody input[type=checkbox]', function (e) {
    var rowCount = $('#listuser > tbody input[type=checkbox]').length;
    var n = $('#listuser > tbody input[type=checkbox]').filter(':checked').length;
    if(n > 0)
			document.getElementById("deleteData").disabled = false;
		else
			document.getElementById("deleteData").disabled = true;

    if(rowCount == n)
			$('#check-all').prop('checked', 'checked');
		else
			$('#check-all').removeProp('checked');
  });
</script>
