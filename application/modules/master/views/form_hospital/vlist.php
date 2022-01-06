<div class="container">
  <div class="row" id="formParent">
    <div class="col-xs-12 col-sm-12">
      <div class="btn-toolbar" style="margin-bottom: 15px">
        <a type="button" href="<?php echo site_url('master/hospital'); ?>" class="btn btn-inverse" name="button" style="padding:12px 16px;"><b><i class="fa fa-table"></i> Data Fasyankes</b></a>
        <button type="button" class="btn btn-primary-alt" id="btnAdd" style="padding:11px 16px;"><b><i class="fa fa-plus"></i> Tambah Baru</b></button>
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
                <i class="fa fa-sliders"></i> Filter Data
              </a>
            </h3>
          </div>
          <div class="pull-right">
            <div class="btn-toolbar">
              <button type="button" class="btn btn-primary" id="printDoc"><i class="fa fa-file-word-o"></i> EXPORT KE WORD</button>
              <button type="button" class="btn btn-success" id="printExcel"><i class="fa fa-file-excel-o"></i> EXPORT KE EXCEL </button>
              <button type="button" class="btn btn-danger" id="printPdf"><i class="fa fa-file-pdf-o"></i> EXPORT KE PDF </button>
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12">
          <?php echo form_open(site_url('#'), array('id'=>'formFilter', 'style'=>'display:none;margin-bottom:20px;')); ?>
            <div style="display:block;background:#FFF;padding:20px;border:1px solid #CCC;box-shadow:0px 0px 10px #CCC;">
              <div class="row">
                <div class="col-xs-12 col-sm-3">
                  <div class="form-group">
                    <label style="font-size:16px;"><b>Pilih Provinsi</b></label>
                    <?php echo form_dropdown('province', $province, $this->input->post('province'), 'class="select-all"');?>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                  <div class="form-group">
                    <label style="font-size:16px;"><b>Pilih Kab/Kota</b></label>
                    <?php echo form_dropdown('regency', array(''=>'Pilih Kab/Kota'), $this->input->post('regency', TRUE), 'class="select-all"'); ?>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                  <div class="form-group">
                    <label style="font-size:16px;"><b>Pilih Katogeri Rumah Sakit</b></label>
                    <?php echo form_dropdown('rujukan', array(''=>'Pilih Kategori', 1=>'Rumah Sakit Rujukan', 2=>'Rumah Sakit Daerah'), $this->input->post('rujukan'), 'class="select-all" id="rujukan"');?>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                  <div class="form-group">
                    <label style="font-size:16px;"><b>Pilih Status</b></label>
                    <?php echo form_dropdown('status', array(''=>'Pilih Status', 1=>'Aktif', 0=>'Tidak Aktif'), $this->input->post('status'), 'class="select-all" id="status_id"');?>
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
      <div class="panel panel-green">
        <div class="panel-heading">
          <h4>Daftar Fasilitas Layanan Kesehatan</h4>
        </div>
        <div class="panel-body collapse in">
          <div class="table-responsive">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="tblRumahSakit" width="100%">
              <thead>
                <tr>
                  <th width="3%">#</th>
                  <th width="8%">Kode</th>
                  <th width="27%">Nama Fasyankes</th>
                  <th width="15%">Provinsi</th>
                  <th width="15%">Kab/Kota</th>
                  <th width="17%">Kategori</th>
                  <th width="8%">status</th>
                  <th width="6%">Action</th>
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
        <h4 class="modal-title"><b>FORM ENTRI DATA FASYANKES</b></h4>
      </div>
      <?php echo form_open(site_url('master/hospital/create'), array('id' => 'formEntry')); ?>
      <div class="modal-body" style="padding:15px 15px 5px 15px;">
        <div id="errEntry"></div>
        <div class="row">
          <?php echo form_hidden('tokenId', ''); ?>
          <div class="col-xs-12 col-sm-4">
            <div class="form-group required">
              <label for="kode_fasyankes" class="control-label" style="font-size:15px;"><b>Kode Fasyankes <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="kode_fasyankes" id="kode_fasyankes" placeholder="Kode Fasyankes" value="<?php echo $this->input->post('kode_fasyankes', TRUE); ?>">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="form-group required">
              <label for="fullname" class="control-label"><b>Nama Fasyankes <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Nama Fasyankes" value="<?php echo $this->input->post('fullname', TRUE); ?>">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="form-group required">
              <label for="shortname" class="control-label"><b>Singkatan Fasyankes</b></label>
              <input type="text" class="form-control" name="shortname" id="shortname" placeholder="Singkatan Fasyankes" value="<?php echo $this->input->post('shortname', TRUE); ?>">
              <div class="help-block"></div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-3">
            <div class="form-group required">
              <label for="province" class="control-label"><b>Provinsi Fasyankes <font color="red">*</font></b></label>
              <?php echo form_dropdown('province', $province, $this->input->post('province'), 'class="select-all" id="province"');?>
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-3">
            <div class="form-group required">
              <label for="regency" class="control-label"><b>Kab/Kota Fasyankes <font color="red">*</font></b></label>
              <?php echo form_dropdown('regency', array(''=>'Pilih Kab/Kota'), $this->input->post('regency', TRUE), 'class="select-all" id="regency"'); ?>
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-3">
            <div class="form-group required">
              <label for="district" class="control-label"><b>Kecamatan Fasyankes <font color="red">*</font></b></label>
              <?php echo form_dropdown('district', array(''=>'Pilih Kecematan'), $this->input->post('district', TRUE), 'class="select-all" id="district"'); ?>
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-3">
            <div class="form-group required">
              <label for="village" class="control-label"><b>Kelurahan Fasyankes <font color="red">*</font></b></label>
              <?php echo form_dropdown('village', array(''=>'Pilih Kelurahan'), $this->input->post('village', TRUE), 'class="select-all" id="village"'); ?>
              <div class="help-block"></div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-8">
            <div class="form-group required">
              <label for="address" class="control-label"><b>Alamat Lengkap</b></label>
              <input type="text" class="form-control" name="address" id="address" placeholder="Alamat Lengkap" value="<?php echo $this->input->post('address', TRUE); ?>">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="form-group required">
              <label for="phone" class="control-label"><b>No. Telp</b></label>
              <input type="text" class="form-control" name="phone" id="phone" placeholder="No. Telp" value="<?php echo $this->input->post('phone', TRUE); ?>">
              <div class="help-block"></div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-4">
            <div class="form-group required">
              <label for="tipe_fasyankes" class="control-label"><b>Tipe Fasyankes <font color="red">*</font></b></label>
              <?php echo form_dropdown('tipe_fasyankes', array(''=>'Pilih Tipe', 'RS'=>'RS'), $this->input->post('tipe_fasyankes'), 'class="select-all" id="tipe_fasyankes"');?>
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="form-group required">
              <label for="flag" class="control-label"><b>Kategori Fasyankes <font color="red">*</font></b></label>
              <?php echo form_dropdown('flag', array(''=>'Pilih Kategori', 1=>'Rumah Sakit Rujukan Pemerintah', 2=>'Rumah Sakit Daerah'), $this->input->post('flag'), 'class="select-all" id="flag"');?>
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="form-group required">
              <label for="status" class="control-label"><b>Status<font color="red">*</font></b></label>
              <?php echo form_dropdown('status', status(), $this->input->post('status'), 'class="select-all" id="status"');?>
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
    getDataListRumahSakit();
  });

  $(document).on('click', '.btnFilter', function(e){
    $('#formFilter').slideToggle('slow');
    $('.select-all').select2('val', '');
  });

  $(document).on('click', '#cancel', function(e){
    e.preventDefault();
    $('.select-all').select2('val', '');
    getDataListRumahSakit();
  });

  $('#formFilter').submit(function(e){
    e.preventDefault();
    getDataListRumahSakit();
  });

  function getDataListRumahSakit() {
    $('#tblRumahSakit').dataTable({
      "destroy": true,
      "processing":true,
      "language": {
        "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
      },
      "serverSide": true,
      "ordering": false,
      "ajax": {
        "url": site + "master/hospital/listview",
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
    $('#tblRumahSakit_filter input').addClass('form-control').attr('placeholder','Search Data');
    $('#tblRumahSakit_length select').addClass('form-control');
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
    $('#formEntry').attr('action', site + 'master/hospital/create');
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
    var postData = $(this).serialize();
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
                url: formActionURL,
                type: "POST",
                data: postData,
                dataType: "json",
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
                  getDataListRumahSakit();
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
    $('#formEntry').attr('action', site + 'master/hospital/update');
    var token = $(this).data('id');
    $('#modalEntryForm').modal({
      backdrop: 'static'
    });
    getDataRumahSakit(token);
  });

  function getDataRumahSakit(token) {
    run_waitMe($('#frmEntry'));
    $.ajax({
      type: 'POST',
      url: site + 'master/hospital/details',
      data: {'token' : token, '<?php echo $this->security->get_csrf_token_name(); ?>' : $('input[name="'+csrfName+'"]').val()},
      dataType: 'json',
      success: function(data) {
        $('input[name="'+csrfName+'"]').val(data.csrfHash);
        if(data.status == 1) {
          $('input[name="tokenId"]').val(token);
          $('#kode_fasyankes').val(data.message.kode);
          $('#fullname').val(data.message.fullname);
          $('#shortname').val(data.message.shortname);
          $('#province').select2('val', data.message.province).trigger('change');
          regeID = data.message.regency;
          distID = data.message.district;
          villID = data.message.village;
          $('#address').val(data.message.address);
          $('#phone').val(data.message.phone);
          $('#tipe_fasyankes').select2('val', data.message.tipe);
          $('#flag').select2('val', data.message.flag);
          $('#status').select2('val', data.message.status);
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
                url: site + 'master/hospital/delete',
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
                  getDataListRumahSakit();
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

  //cetak laporan word
  $(document).on('click', '#printDoc', function(e){
    let province = $('#formFilter').find('select[name="province"]').val();
    let regency  = $('#formFilter').find('select[name="regency"]').val();
    let type     = $('#formFilter').find('select[name="rujukan"]').val();
    let status   = $('#formFilter').find('select[name="status"]').val();
    url = site + 'master/hospital/export-to-word?provinsi='+province+'&daerah='+regency+'&type='+type+'&status='+status;
    window.location.href = url;
  });

  //cetak laporan excel
  $(document).on('click', '#printExcel', function(e){
    let province = $('#formFilter').find('select[name="province"]').val();
    let regency  = $('#formFilter').find('select[name="regency"]').val();
    let type     = $('#formFilter').find('select[name="rujukan"]').val();
    let status   = $('#formFilter').find('select[name="status"]').val();
    url = site + 'master/hospital/export-to-excel?provinsi='+province+'&daerah='+regency+'&type='+type+'&status='+status;
    window.location.href = url;
  });

  //cetak laporan pdf
  $(document).on('click', '#printPdf', function(e){
    let province = $('#formFilter').find('select[name="province"]').val();
    let regency  = $('#formFilter').find('select[name="regency"]').val();
    let type     = $('#formFilter').find('select[name="rujukan"]').val();
    let status   = $('#formFilter').find('select[name="status"]').val();
    url = site + 'master/hospital/export-to-pdf?provinsi='+province+'&daerah='+regency+'&type='+type+'&status='+status;
    window.location.href = url;
  });

  $(document).on('change', 'select[name="province"]', function(e) {
    let id = $(this).val();
    getRegency(id);
  });

  $(document).on('change', 'select[name="regency"]', function(e) {
    let id = $(this).val();
    getDistrict(id);
  });

  $(document).on('change', 'select[name="district"]', function(e) {
    let id = $(this).val();
    getVillage(id);
  });

  //mengambil data kab/kota
  function getRegency(provinceId) {
    regeID = (regeID != '') ? regeID : '<?php echo $this->input->post('regency', TRUE); ?>';
    let lblReg = '';
    $.ajax({
      type: 'GET',
      url: site + 'master/hospital/regency',
      data: {'province' : provinceId},
      dataType: 'json',
      success: function(data) {
        $('input[name="'+csrfName+'"]').val(data.csrfHash);
        $('select[name="regency"]').html('').select2('data', null);
        if(data.status == 1) {
          lblReg = '<option value="">Pilih Kab/Kota</option>';
          $.each(data.message,function(key,value){
            lblReg += '<option value="'+value['id']+'">'+value['text']+'</option>';
          });
        } else
          lblReg = '<option value="">Pilih Kab/Kota</option>';
        $('select[name="regency"]').html(lblReg);
        $('select[name="regency"]').select2('val', regeID).trigger('change');
      }
    });
  }

  //mengambil data kecamatan
  function getDistrict(regencyId) {
    let lblDis = '';
    distID = (distID != '') ? distID : '<?php echo $this->input->post('district', TRUE); ?>';
    $.ajax({
      type: 'GET',
      url: site + 'master/hospital/district',
      data: {'regency' : regencyId},
      dataType: 'json',
      success: function(data) {
        $('input[name="'+csrfName+'"]').val(data.csrfHash);
        $('#district').html('').select2('data', null);
        if(data.status == 1) {
          lblDis = '<option value="">Pilih Kecamatan</option>';
          $.each(data.message,function(key,value){
            lblDis += '<option value="'+value['id']+'">'+value['text']+'</option>';
          });
        } else
          lblDis = '<option value="">Pilih Kecamatan</option>';
        $('#district').html(lblDis);
        $('#district').select2('val', distID).trigger('change');
      }
    });
  }

  //mengambil data kelurahan/desa/nagari
  function getVillage(districtId) {
    let lblVil = '';
    villID = (villID != '') ? villID : '<?php echo $this->input->post('village', TRUE); ?>';
    $.ajax({
      type: 'GET',
      url: site + 'master/hospital/village',
      data: {'district' : districtId},
      dataType: 'json',
      success: function(data) {
        $('input[name="'+csrfName+'"]').val(data.csrfHash);
        $('#village').html('').select2('data', null);
        if(data.status == 1) {
          lblVil = '<option value="">Pilih Kelurahan</option>';
          $.each(data.message,function(key,value){
            lblVil += '<option value="'+value['id']+'">'+value['text']+'</option>';
          });
        } else
          lblVil = '<option value="">Pilih Kelurahan</option>';
        $('#village').html(lblVil);
        $('#village').select2('val', villID).trigger('change');
      }
    });
  }

</script>
