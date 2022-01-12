<div class="container">
  <div class="row" id="formParent">
    <div class="col-xs-12 col-sm-12">
      <div class="btn-toolbar" style="margin-bottom: 15px">
        <a type="button" href="<?php echo site_url('dokumen/agenda'); ?>" class="btn btn-primary-alt" name="button" ><b><i class="fa fa-refresh"></i> Data Agenda</b></a>        
      </div>
    </div>
    <div class="col-xs-12 col-sm-12">
      <?php echo $this->session->flashdata('message'); ?>
      <div id="errSuccess"></div>
    </div>
    <div class="col-xs-12 col-sm-12">
      <div class="row">
        <div class="col-xs-12 col-sm-12">
          <div class="pull-left">
            <h3 style="font-weight:bold;text-align:left;">
              <a href="javascript:void(0);" class="btnFilter" style="text-decoration:none;color:#000000;">
                <i class="fa fa-search"></i> Filter Data
              </a>
            </h3>
          </div>
         
        </div>
        <div class="col-xs-12 col-sm-12">
          <?php echo form_open(site_url('#'), array('id'=>'formFilter', 'style'=>'display:none;margin-bottom:20px;')); ?>
            <div style="display:block;background:#FFF;padding:20px;border:1px solid #CCC;box-shadow:0px 0px 10px #CCC;">
              <div class="row">
               
               <div class="col-xs-12 col-sm-3">
                  <div class="form-group">
                    <label style="font-size:16px;"><b>Pilih Jenis Agenda</b></label>
                    <?php echo form_dropdown('jenis_agenda', array(''=>'Pilih Jenis Agenda', 'P'=>'Agenda Pimpinan', 'S'=>'Agenda Umum'), $this->input->post('jenis_agenda'), 'class="select-all"');?>
                  </div>
                </div>

                 <div class="col-xs-12 col-sm-3">
                  <div class="form-group">
                    <label style="font-size:16px;"><b>Tanggal</b></label>
                    <input type="text" class="form-control datepicker" name="tanggal" id="tanggal" placeholder="Tanggal Kegiatan" >                    
                  </div>
                </div>

              <div class="col-xs-12 col-sm-3">
                  <div class="form-group">
                    <label style="font-size:16px;"><b>Pilih Status</b></label>
                    <?php echo form_dropdown('status', array(''=>'Pilih Status', 'SH'=>'Dihadiri', 'SW'=>'Diwakilkan'), $this->input->post('status'), 'class="select-all" ');?>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-12">
                  <div class="pull-left">
                    <div class="btn-toolbar">
                      <button type="submit" class="btn btn-primary" name="filter" id="filter"><i class="fa fa-filter"></i> LAKUKAN PENCARIAN</button>
                      <button type="button" class="btn btn-danger" name="cancel" id="cancel"><i class="fa fa-refresh"></i> CANCEL</button>
                    </div>
                  </div>
                  <div class="pull-right">
                    <div class="btn-toolbar">
                      <button type="button" class="btn btn-default btnFilter" name="button"><i class="fa fa-times"></i> CLOSE</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
    <div class="col-xs-12 col-sm-12">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h4>Daftar Agenda</h4>
        </div>
        <div class="panel-body collapse in">
          <div class="table-responsive">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="tblAgenda" width="100%">
              <thead>
                <tr>
                  <th width="3%">#</th>
                  <th width="20%">Nama Agenda</th>
                  <th width="10%">Jenis Agenda</th>
                  <th width="10%">Tanggal</th>
                  <th width="10%">Jam</th>
                  <th width="20%">Kegiatan</th>
                  <th width="20%">Lokasi</th>                  
                  <th width="10%">Status Agenda</th>      
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><!-- container -->

<div class="modal fade in" id="modalEntryForm" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" id="frmEntry">
    <div class="modal-content">
      <div class="modal-header" style="padding:10px 15px 10px 15px;">
        <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><b>FORM ENTRI DATA AGENDA</b></h4>
      </div>
      <?php echo form_open_multipart(site_url('dokumen/agenda/create'), array('id' => 'formEntry')); ?>
      <div class="modal-body" style="padding:15px 15px 5px 15px;">
        <div id="errEntry"></div>
        <?php echo form_hidden('tokenId', ''); ?>
        <div class="row"> 
          <div class="col-xs-12">
            <div class="form-group required">
              <label for="nama_agenda" class="control-label" style="font-size:15px;"><b>Nama Agenda <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="nama_agenda" id="nama_agenda" placeholder="Nama Agenda" value="<?php echo $this->input->post('nm_agenda', TRUE); ?>">
              <div class="help-block"></div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label for="jenis_agenda" class="control-label" style="font-size:15px;"><b> Jenis Agenda <font color="red">*</font></b></label>
             <?php echo form_dropdown('jenis_agenda', array(''=>'Pilih Jenis Agenda', 'P'=>'Agenda Pimpinan', 'S'=>'Agenda Umum'), $this->input->post('jenis_agenda'), 'class="select-all" id="jenis_agenda"');?>
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label for="penerima" class="control-label"><b>Penerima <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="penerima" id="penerima" placeholder="penerima" value="<?php echo $this->input->post('penerima', TRUE); ?>">
              <div class="help-block"></div>
            </div>
          </div>
        </div>

        <div class="row">
         <div class="col-xs-12 col-sm-4">
            <div class="form-group required">
              <label for="tanggal" class="control-label"><b>Tanggal Kegiatan <font color="red">*</font></b></label>
              
              <div class="input-group date datepicker" style="padding:0px;">
                  <input type="text" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal Kegiatan" value="<?php echo date('Y-m-d');?>">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              </div>
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="form-group required">
              <label for="jam_mulai" class="control-label"><b>Jam Mulai <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="jam_mulai" id="jam_mulai" placeholder="Jam Mulai" value="<?php echo $this->input->post('jam_mulai', TRUE); ?>">

              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="form-group required">
              <label for="jam_selesai" class="control-label"><b>Jam Selesai <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="jam_selesai" id="jam_selesai" placeholder="Jam Selesai" value="<?php echo $this->input->post('jam_selesai', TRUE); ?>">
              <div class="help-block"></div>
            </div>
          </div>
        </div>
        <div class="row">
         <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label for="kegiatan" class="control-label" style="font-size:15px;"><b>Nama Kegiatan <font color="red">*</font></b></label>
              <textarea class="form-control" name="kegiatan" id="kegiatan" placeholder="Nama Kegiatan"></textarea>
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label for="lokasi_kegiatan" class="control-label"><b>Lokasi Kegiatan <font color="red">*</font></b></label>
               <textarea class="form-control" name="lokasi_kegiatan" id="lokasi_kegiatan" placeholder="Lokasi Kegiatan"></textarea>
              <div class="help-block"></div>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label for="dokumen" class="control-label"><b>Dokumen</b></label>
              <input type="file" class="form-control" name="dokumen" id="dokumen" placeholder="dokumen" value="<?php echo $this->input->post('dokumen', TRUE); ?>">
              <div id="file_upload"></div>
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label for="phone" class="control-label"><b>Keterangan</b></label>
              <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan"></textarea>
              <div class="help-block"></div>
            </div>
          </div>
        </div>
        
      </div>
      <div class="modal-footer" style="margin-top:0px;padding:10px 15px 15px 0px;">
        <button type="button" class="btn btn-default btnClose" style="padding:12px 16px;"><i class="fa fa-times"></i> CANCEL</button>
        <button type="submit" class="btn btn-primary" name="save" id="save" style="padding:12px 16px;"><i class="fa fa-check"></i> SUBMIT</button>
      </div>
      <?php echo form_close(); ?>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade in" id="modalEntryFormReview" tabindex="-1" role="dialog" aria-labelledby="modalEntryLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" id="frmEntryReview">
    <div class="modal-content">
      <div class="modal-header" style="padding:10px 15px 10px 15px;">
        <button type="button" class="close btnClose" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><b id="tipe_validasi">FORM VALIDASI DATA AGENDA</b></h4>
      </div>
      <?php echo form_open_multipart(site_url('dokumen/agenda/approve'), array('id' => 'formEntryReview')); ?>
      <div class="modal-body" style="padding:15px 15px 5px 15px;">
        <div id="errEntryReview"></div>
        <?php echo form_hidden('tokenId', ''); ?>
        <div class="row"> 

          <div class="col-xs-12">
          <b id="catatan">Catatan : Data Agenda akan divalidasi dan diteruskan Ke Pimpinan</b><br></br>
            <div class="form-group required">
              <label for="nama_agenda" class="control-label" style="font-size:15px;"><b>Nama Agenda <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="nama_agenda" id="nama_agenda" placeholder="Nama Agenda" value="<?php echo $this->input->post('nama_agenda', TRUE); ?>" readonly>
              <div class="help-block"></div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-12">
            <div class="form-group required">
              <label for="phone" class="control-label" ><b id="ket">Keterangan</b></label>
              <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan"></textarea>
              <div class="help-block"></div>
            </div>
          </div>
        </div>
        
      </div>
      <div class="modal-footer" style="margin-top:0px;padding:10px 15px 15px 0px;">
        <button class="btn" data-dismiss="modal" aria-hidden="true" style="padding:12px 16px;"><i class="fa fa-times"></i> CANCEL</button>
        <button type="submit" class="btn btn-primary" name="saveReview" id="saveReview" style="padding:12px 16px;"><i class="fa fa-check"></i> SUBMIT</button>
      </div>
      <?php echo form_close(); ?>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript"src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
 $('.datepicker').datepicker({
        format: "yyyy-mm-dd"
    });
</script>

<script type="text/javascript">
  $.fn.modal.Constructor.prototype.enforceFocus = function() {};
  var csrfName  = '<?php echo $this->security->get_csrf_token_name(); ?>';
  var site      = '<?php echo site_url();?>';
  var regeID = '', distID = '', villID = '';

  function run_waitMe(el) {
    el.waitMe({
			effect: 'facebook',
			text: 'Please wait...',
			bg: 'rgba(255,255,255,0.7)',
			color: '#000',
			maxSize: 100,
			waitTime: -1,
      textPos: 'vertical',
			source: '',
			fontSize: '',
			onClose: function(el) {}
		});
  }

  $(document).ready(function(e){
    getDataListAgenda();
  });

  $(document).on('click', '.btnFilter', function(e){
    $('#formFilter').slideToggle('slow');
    $('.select-all').select2('val', '');
  });

  $(document).on('click', '#cancel', function(e){
    e.preventDefault();
    $('.select-all').select2('val', '');
    getDataListAgenda();
  });

  $('#formFilter').submit(function(e){
    e.preventDefault();
    getDataListAgenda();
  });

  function getDataListAgenda() {
    $('#tblAgenda').dataTable({
      "destroy": true,
      "processing":true,
      "language": {
        "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
      },
      "serverSide": true,
      "ordering": false,
      "ajax": {
        "url": site + "dokumen/agenda/listview",
        "type": "POST",
        "data": {
          "param" : $('#formFilter').serializeArray(),
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
    $('#tblAgenda_filter input').addClass('form-control').attr('placeholder','Search Data');
    $('#tblAgenda_length select').addClass('form-control');
  }

  //panggil form Entri
  $(document).on('click', '#btnAdd', function(e){
    formReset();
    $('#modalEntryForm').modal({
      backdrop: 'static'
    });
  });

  //close form entri
  $(document).on('click', '.btnClose', function(e) {
    formReset();
    $('#modalEntryForm').modal('toggle');
  });

  function formReset() {
    $('#formEntry').attr('action', site + 'dokumen/agenda/create');
    $('#errEntry').html('');
    $('.select-all').select2('val', '');
    $('#status').select2('val', 1);
    $('.help-block').text('');
    $('.required').removeClass('has-error');
    $('form#formEntry').trigger('reset');
    regeID = ''; distID = ''; villID = '';
  }

  $('#formEntry').submit(function(e) {
    e.preventDefault();
    // /var postData = $(this).serialize();
    var form = $('#formEntry')[0]; // Khusus form yang menggunakan upload foto
    // get form action url
    var formActionURL = $(this).attr("action");
    $("#save").html('<i class="fa fa-hourglass-half"></i> DIPROSES...');
    $("#save").addClass('disabled');
    run_waitMe($('#frmEntry'));
    bootbox.dialog({
      title: "Konfirmasi",
      message: "Apakah anda ingin menyimpan data fasilitas layanan kesehatan ini ?",
      buttons: {
        "cancel" : {
          "label" : "<i class='fa fa-times'></i> Tidak",
          "className" : "btn-danger",
          callback:function(response){
            if (response) {
              $("#save").html('<i class="fa fa-check"></i> SUBMIT');
              $("#save").removeClass('disabled');
              $('#frmEntry').waitMe('hide');
            }
          }
        },
        "main" : {
          "label" : "<i class='fa fa-check'></i> Ya, Lanjutkan",
          "className" : "btn-primary",
          callback:function(response){
            if (response) {
              $.ajax({
                url : formActionURL,
                mimetype : "multipart/form-data",
                type : "POST",
                data : new FormData(form),
                dataType : "json",
                async : true,
                cache : false,
                contentType: false,
                processData : false
              }).done(function(data) {
                $('input[name="'+csrfName+'"]').val(data.csrfHash);
                $('.help-block').text('');
                $('.required').removeClass('has-error');
                if(data.status == 0) {
                  $('#errEntry').html('<div class="alert alert-danger" id="pesanErr"><strong>Peringatan!</strong> Tolong dilengkapi form inputan dibawah...</div>');
                  $.each(data.message, function(key,value){
                    if(key != 'isi')
                      $('input[name="'+key+'"], select[name="'+key+'"]').closest('div.required').addClass('has-error').find('div.help-block').text(value);
                    else {
                      $('#pesanErr').html('<strong>Peringatan!</strong> ' +value);
                    }
                  });
                  $('#modalEntryForm').animate({
                    scrollTop: (data.message.isi) ? 0 : ($('.has-error').find('input, select').first().focus().offset().top-300)
                  }, 'slow');
                } else {
                  $('#errSuccess').html('<div class="alert alert-dismissable alert-success">'+
                                          '<strong>Sukses!</strong> '+ data.message +
                                          '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                                        '</div>');
                  $('#modalEntryForm').modal('toggle');
                  getDataListAgenda();
                }
                $('#frmEntry').waitMe('hide');
              }).fail(function() {
                $('#errEntry').html('<div class="alert alert-danger">'+
                                     '<strong>Peringatan!</strong> Harap periksa kembali data yang diinputkan...'+
                                    '</div>');
                $('#frmEntry').waitMe('hide');
              }).always(function() {
                $("#save").html('<i class="fa fa-check"></i> SUBMIT');
                $("#save").removeClass('disabled');
              });
            }
          }
        }
      }
    });
  });

  $(document).on('click', '.btnEdit', function(e){
    formReset();
    $('#formEntry').attr('action', site + 'dokumen/agenda/update');
    var token = $(this).data('id');

    $('#modalEntryForm').modal({
      backdrop: 'static'
    });
    getDetailAgenda(token);
  });

  function getDetailAgenda(token) {
    run_waitMe($('#frmEntry'));
    $.ajax({
      type: 'POST',
      url: site + 'dokumen/agenda/details',
      data: {'token' : token, '<?php echo $this->security->get_csrf_token_name(); ?>' : $('input[name="'+csrfName+'"]').val()},
      dataType: 'json',
      success: function(data) {
        $('input[name="'+csrfName+'"]').val(data.csrfHash);
        if(data.status == 1) {
          $('input[name="tokenId"]').val(token);
          $('#nama_agenda').val(data.message.nama_agenda);          
          $('#jenis_agenda').select2('val', data.message.jenis_agenda).trigger('change');
          $('#penerima').val(data.message.penerima);
          $('#tanggal').val(data.message.tanggal);
          $('#jam_mulai').val(data.message.jam_mulai);
          $('#jam_selesai').val(data.message.jam_selesai);
          $('#kegiatan').val(data.message.kegiatan);
          $('#lokasi_kegiatan').val(data.message.lokasi_kegiatan);
          $('#keterangan').val(data.message.keterangan);
          $('#file_upload').html(data.file_upload);
        }
        $('#frmEntry').waitMe('hide');
      }
    });
  }

  $(document).on('click', '.btnDelete', function(e){
    e.preventDefault();
    var postData = {
      'tokenId': $(this).data('id'),
      '<?php echo $this->security->get_csrf_token_name(); ?>' : $('input[name="'+csrfName+'"]').val()
    };
    $(this).html('<i class="fa fa-hourglass-half"></i>');
    $(this).addClass('disabled');
    run_waitMe($('#formParent'));
    bootbox.dialog({
      title: "Konfirmasi",
      message: "Apakah anda ingin menghapus data fasyankes ini ?",
      buttons: {
        "cancel" : {
          "label" : "<i class='fa fa-times'></i> Tidak",
          "className" : "btn-danger",
          callback:function(response) {
            if (response) {
              $('.btnDelete').html('<i class="fa fa-times"></i>');
              $('.btnDelete').removeClass('disabled');
              $('#formParent').waitMe('hide');
            }
          }
        },
        "main" : {
          "label" : "<i class='fa fa-check'></i> Ya, Lanjutkan",
          "className" : "btn-primary",
          callback:function(response){
            if (response) {
              $.ajax({
                url: site + 'dokumen/agenda/delete',
                type: "POST",
                data: postData,
                dataType: "json",
              }).done(function(data) {
                $('input[name="'+csrfName+'"]').val(data.csrfHash);
                if(data.status == 0) {
                  $('#errSuccess').html('<div class="alert alert-danger">'+
                                         '<strong>Informasi!</strong> '+ data.message +
                                        '</div>');
                } else {
                  $('#errSuccess').html('<div class="alert alert-dismissable alert-success">'+
                                          '<strong>Sukses!</strong> '+ data.message +
                                          '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                                       '</div>');
                  getDataListAgenda();
                }
                $('#formParent').waitMe('hide');
              }).fail(function() {
                $('#errSuccess').html('<div class="alert alert-danger">'+
                                      '<strong>Peringatan!</strong> Proses delete data gagal...'+
                                     '</div>');
                $('#formParent').waitMe('hide');
              }).always(function() {
                $('.btnDelete').html('<i class="fa fa-times"></i>');
                $('.btnDelete').removeClass('disabled');
              });
            }
          }
        }
      }
    });
  });
  

  /*----------------------------------Review Agenda---------------------------------------------*/

  $(document).on('click', '.btnReview', function(e){
    formResetReview();
    $('#formEntryReview').attr('action', site + 'dokumen/agenda/approve');
    var token = $(this).data('id');
    var nama_agenda = $(this).data('nm');
     $('#tipe_validasi').html('FORM VALIDASI DATA AGENDA');
     $('#catatan').html('Data Agenda Akan Di Acc dan Diteruskan Ke Pimpinan');
     $('#ket').html('Keterangan');

     $('input[name="nama_agenda"]').val(nama_agenda);
     $('input[name="tokenId"]').val(token);
    $('#modalEntryFormReview').modal({
      backdrop: 'static'
    });
  });

  function formResetReview() {
    $('#formEntryReview').attr('action', site + 'dokumen/agenda/approve');
    $('#errEntryReview').html('');    
    $('.help-block').text('');
    $('.required').removeClass('has-error');
    $('form#formEntryReview').trigger('reset');
  }

  $('#formEntryReview').submit(function(e) {
    e.preventDefault();
    // /var postData = $(this).serialize();
    var form = $('#formEntryReview')[0]; // Khusus form yang menggunakan upload foto
    // get form action url
    var formActionURL = $(this).attr("action");
    $("#saveReview").html('<i class="fa fa-hourglass-half"></i> DIPROSES...');
    $("#saveReview").addClass('disabled');
    run_waitMe($('#frmEntryReview'));
    bootbox.dialog({
      title: "Konfirmasi",
      message: "Apakah anda ingin menyimpan data fasilitas layanan kesehatan ini ?",
      buttons: {
        "cancel" : {
          "label" : "<i class='fa fa-times'></i> Tidak",
          "className" : "btn-danger",
          callback:function(response){
            if (response) {
              $("#saveReview").html('<i class="fa fa-check"></i> SUBMIT');
              $("#saveReview").removeClass('disabled');
              $('#frmEntryReview').waitMe('hide');
            }
          }
        },
        "main" : {
          "label" : "<i class='fa fa-check'></i> Ya, Lanjutkan",
          "className" : "btn-primary",
          callback:function(response){
            if (response) {
              $.ajax({
                url : formActionURL,
                mimetype : "multipart/form-data",
                type : "POST",
                data : new FormData(form),
                dataType : "json",
                async : true,
                cache : false,
                contentType: false,
                processData : false
              }).done(function(data) {
                $('input[name="'+csrfName+'"]').val(data.csrfHash);
                $('.help-block').text('');
                $('.required').removeClass('has-error');
                if(data.status == 0) {
                  $('#errEntryReview').html('<div class="alert alert-danger" id="pesanErrReview"><strong>Peringatan!</strong> Tolong dilengkapi form inputan dibawah...</div>');
                  $.each(data.message, function(key,value){
                    if(key != 'isi')
                      $('input[name="'+key+'"], select[name="'+key+'"]').closest('div.required').addClass('has-error').find('div.help-block').text(value);
                    else {
                      $('#pesanErrReview').html('<strong>Peringatan!</strong> ' +value);
                    }
                  });
                  $('#modalEntryFormReview').animate({
                    scrollTop: (data.message.isi) ? 0 : ($('.has-error').find('input, select').first().focus().offset().top-300)
                  }, 'slow');
                } else {
                  $('#errSuccess').html('<div class="alert alert-dismissable alert-success">'+
                                          '<strong>Sukses!</strong> '+ data.message +
                                          '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                                        '</div>');
                  $('#modalEntryFormReview').modal('toggle');
                  getDataListAgenda();
                }
                $('#frmEntryReview').waitMe('hide');
              }).fail(function() {
                $('#errEntryReview').html('<div class="alert alert-danger">'+
                                     '<strong>Peringatan!</strong> Harap periksa kembali data yang diinputkan...'+
                                    '</div>');
                $('#frmEntryReview').waitMe('hide');
              }).always(function() {
                $("#saveReview").html('<i class="fa fa-check"></i> SUBMIT');
                $("#saveReview").removeClass('disabled');
              });
            }
          }
        }
      }
    });
  });

  $(document).on('click', '.btnReject', function(e){
    formReset();
    $('#formEntryReview').attr('action', site + 'dokumen/agenda/reject');
    var token = $(this).data('id');
    var nama_agenda = $(this).data('nm');
    $('#tipe_validasi').html('FORM TOLAK DATA AGENDA');
    $('#catatan').html('Data Agenda DiTolak');
    $('#ket').html('Alasan Penolakan');

     $('input[name="tokenId"]').val(token);
     $('input[name="nama_agenda"]').val(nama_agenda);
    $('#modalEntryFormReview').modal({
      backdrop: 'static'
    });
  });
  /*----------------------------------Review Agenda---------------------------------------------*/
</script>
