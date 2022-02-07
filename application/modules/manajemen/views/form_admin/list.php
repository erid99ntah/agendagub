<div class="container">
  <div class="row" id="formParent">
    <div class="col-xs-12 col-sm-12">
      <div class="btn-toolbar" style="margin-bottom: 15px">
        <a type="button" href="<?php echo site_url('manajemen/users'); ?>" class="btn btn-primary" name="button" style="padding:12px 16px;"><b><i class="fa fa-refresh"></i> Data User</b></a>
        <button type="button" class="btn btn-primary-alt" id="btnAdd" style="padding:11px 16px;"><b><i class="fa fa-plus-square"></i> Tambah Baru</b></button>
        
        <button type="button" class="btn btn-danger-alt" id="btnDelete" style="padding:11px 16px;display:none;"><i class="fa fa-trash-o"></i> Delete User</button>
      </div>
    </div>
    <div class="col-xs-12 col-sm-12">
      <?php echo $this->session->flashdata('message'); ?>
      <div id="errSuccess"></div>
    </div>
    <div class="col-xs-12 col-sm-12">
      <div class="row">
        <div class="col-xs-12 col-sm-3">
          <h3 style="font-weight:bold;text-align:left;">
            <a href="javascript:void(0);" class="btnFilter" style="text-decoration:none;color:#000000;">
              <i class="fa fa-search"></i> Filter Data
            </a>
          </h3>
        </div>
        <div class="col-xs-12 col-sm-12">
          <?php echo form_open(site_url('#'), array('id'=>'formFilter', 'style'=>'display:none;margin-bottom:20px;')); ?>
          <div style="display:block;background:#FFF;padding:20px;border:1px solid #CCC;box-shadow:0px 0px 10px #CCC;">
            <div class="row">
              <div class="col-xs-12 col-sm-4">
                <div class="form-group">
                  <label for="username" style="font-size:16px;"><b>Username</b></label>
                  <input type="text" class="form-control" placeholder="Username" name="username" value="<?php echo $this->input->post('username', TRUE); ?>">
                </div>
              </div>
              <div class="col-xs-12 col-sm-4">
                <div class="form-group">
                  <label for="fullname" style="font-size:16px;"><b>Nama Lengkap</b></label>
                  <input type="text" class="form-control" placeholder="Nama Lengkap" name="fullname" value="<?php echo $this->input->post('fullname', TRUE); ?>">
                </div>
              </div>
              <div class="col-xs-12 col-sm-4">
                <div class="form-group">
                  <label for="email" style="font-size:16px;"><b>Email</b></label>
                  <input type="text" class="form-control" placeholder="Alamat Email" name="email" value="<?php echo $this->input->post('email', TRUE); ?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12 col-sm-4">
                <div class="form-group">
                  <label for="group" style="font-size:16px;"><b>Nama Group</b></label>
                  <input type="text" class="form-control" placeholder="Nama Group" name="group" value="<?php echo $this->input->post('group', TRUE); ?>">
                </div>
              </div>
              <div class="col-xs-12 col-sm-4">
                <div class="form-group">
                  <label style="font-size:16px;"><b>Level Akses</b></label>
                  <?php echo form_dropdown('level', $data_level, $this->input->post('level'), 'class="select-all"');?>
                </div>
              </div>
              <div class="col-xs-12 col-sm-2">
                <div class="form-group">
                  <label style="font-size:16px;"><b>Blokir</b></label>
                  <?php echo form_dropdown('blokir', array(''=>'Pilih Data', 1=>'Blokir', 0=>'Tidak Blokir'), $this->input->post('blokir'), 'class="select-all"');?>
                </div>
              </div>
              <div class="col-xs-12 col-sm-2">
                <div class="form-group">
                  <label style="font-size:16px;"><b>Status</b></label>
                  <?php echo form_dropdown('status', array(''=>'Pilih Status', 1=>'Aktif', 0=>'Tidak Aktif'), $this->input->post('status'), 'class="select-all"');?>
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
          <h4>Daftar User</h4>
        </div>
        <div class="panel-body collapse in">
          <div class="table-responsive">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-hover table-bordered" id="listuser" width="100%">
              <thead>
                <tr>
                  <th width="3%"><input type="checkbox" id="checkAll"></th>
                  <th width="3%">#</th>
                  <th width="27%">Pengguna</th>
                  <th width="15%">Nama Lengkap</th>
                  <th width="15%">Jabatan</th>
                  <th width="15%">Email</th>
                  <th width="15%">Group</th>
                  <th width="5%">Blokir</th>
                  <th width="5%">Status</th>
                  <th width="5%">Edit</th>
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
        <h4 class="modal-title"><b>FORM ENTRI DATA USER</b></h4>
      </div>
      <?php echo form_open(site_url('manajemen/users/create'), array('id' => 'formEntry')); ?>
      <div class="modal-body" style="padding:15px 15px 5px 15px;">
        <div id="errEntry"></div>
        <div class="row">
          <?php echo form_hidden('tokenId', ''); ?>
          <div class="col-xs-12 col-sm-4">
            <div class="form-group required">
              <label for="fullname" class="control-label" style="font-size:15px;"><b>Nama Lengkap <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Nama Lengkap" value="<?php echo $this->input->post('fullname', TRUE); ?>">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="form-group required">
              <label for="email" class="control-label"><b>Alamat Email</b></label>
              <input type="text" class="form-control" name="email" id="email" placeholder="Alamat Email" value="<?php echo $this->input->post('email', TRUE); ?>">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="form-group required">
              <label for="username" class="control-label"><b>Username <font color="red">*</font></b></label>
              <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $this->input->post('username', TRUE); ?>">
              <div class="help-block"></div>
            </div>
          </div>
        </div>

        <div class="row">

          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label for="fullname" class="control-label" style="font-size:15px;"><b>Instansi User <font color="red">*</font></b></label>
              <?php
              echo form_dropdown('id_opd', $data_instansi, $this->input->post('id_opd'), 'class="select-all" id="id_opd"' );
              echo form_error('id_opd');
              ?>
              <div class="help-block"></div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-6">
            <div class="form-group required">
              <label for="id_jabatan" class="control-label" style="font-size:15px;"><b>Jabatan User <font color="red">*</font></b></label>
              <?php
              echo form_dropdown('id_jabatan', array(''=>'Pilih Jabatan'), $this->input->post('id_jabatan'), 'class="select-all" id="id_jabatan"' );
              echo form_error('id_jabatan');
              ?>
              <div class="help-block"></div>
            </div>
          </div>
        </div>

        <div class="row">
          <label for="groupid" class="control-label col-xs-12" style="margin-bottom:0px;"><b>Group User <font color="red">*</font></b></label>
          <div class="col-xs-12 col-sm-12" style="margin-left:-10px;margin-bottom:20px;">
            <div class="form-group required">
              <?php foreach ($data_group as $key => $dg) {
                echo '<div class="col-xs-12 col-sm-2">';
                echo '<label class="checkbox-inline">';
                echo '<input type="checkbox" name="groupid[]" id="groupid_'.$dg['id_group'].'" value="'.$dg['id_group'].'"><b>'.$dg['nama_group'].'</b>';
                echo '</label>';
                echo '</div>';
              } ?>
              <div class="help-block col-xs-12 col-sm-12"></div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-4">
            <div class="form-group required">
              <label for="password" class="control-label"><b>Password <font color="red" class="lblPass">*</font></b></label>
              <div class="input-group">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password Minimal 8 Karakter" value="<?php echo $this->input->post('password', TRUE); ?>">
                <div class="input-group-addon showPass"><i class="fa fa-eye"></i></div>
              </div>
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4">
            <div class="form-group required">
              <label for="conf_password" class="control-label"><b>Konfirmasi Password <font color="red" class="lblPass">*</font></b></label>
              <div class="input-group">
                <input type="password" class="form-control" name="conf_password" id="conf_password" placeholder="Konfirmasi Password" value="<?php echo $this->input->post('conf_password', TRUE); ?>">
                <div class="input-group-addon showPass"><i class="fa fa-eye"></i></div>
              </div>
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-2">
            <div class="form-group required">
              <label for="blokir" class="control-label"><b>Blokir <font color="red">*</font></b></label>
              <?php echo form_dropdown('blokir', blokir(), $this->input->post('blokir'), 'class="select-data" id="blokir"');?>
              <div class="help-block"></div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-2">
            <div class="form-group required">
              <label for="status" class="control-label"><b>Status <font color="red">*</font></b></label>
              <?php echo form_dropdown('status', status(), $this->input->post('status'), 'class="select-data" id="status"');?>
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
  var opdID = '', jabatanID = '';

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
    getDataListUser();   
    
  });

  $(document).on('click', '.btnFilter', function(e){
    $('#formFilter').slideToggle('slow');
  });

  $(document).on('click', '#cancel', function(e){
    e.preventDefault();
    $('form#formFilter').trigger('reset');
    $('.select-all').select2('val', '');
    getDataListUser();
  });

  $('#formFilter').submit(function(e){
    e.preventDefault();
    getDataListUser();
  });

  function getDataListUser() {
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
    $('#listuser_filter input').addClass('form-control').attr('placeholder','Search Data');
    $('#listuser_length select').addClass('form-control');
  }

  // Handle click on "check all" control
  $(document).on('click', '#checkAll', function(){
    $('#listuser > tbody input[type=checkbox]').prop('checked', this.checked).trigger('change');
  });

  // Handle click on "checked" control
  $(document).on('change', '#listuser > tbody input[type=checkbox]', function (e) {
    var rowCount = $('#listuser > tbody input[type=checkbox]').length;
    var n = $('#listuser > tbody input[type=checkbox]').filter(':checked').length;
    if(n > 0)
     $('#btnDelete').show();
   else
     $('#btnDelete').hide();

   if(rowCount == n)
     $('#checkAll').prop('checked', 'checked');
   else
     $('#checkAll').removeProp('checked');
 });

  $(document).on('click', '#listuser > tbody > tr', function(){
    let n = $(this).find('input[type=checkbox]');
    n.prop('checked', (n.is(':checked')) ? false : true).trigger('change');
  });

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
    $('#formEntry').attr('action', site + 'manajemen/users/create');
    $('#errEntry').html('');
    $('#blokir').select2('val', 0);
    $('#status').select2('val', 1);
    $('#sub_opd').select2('val', 0);
    $('.help-block').text('');
    $('.required').removeClass('has-error');
    $('form#formEntry').trigger('reset');
    $('.lblPass').text('*');
  }

  $(document).on('click', '.btnEdit', function(e){
    e.stopPropagation();
    formReset();
    var token = $(this).data('token');
    $('#formEntry').attr('action', site + 'manajemen/users/update');
    $('.lblPass').text('');
    $('#modalEntryForm').modal({
      backdrop: 'static'
    });
    getDataUser(token);
  });

  function getDataUser(token) {
    run_waitMe($('#frmEntry'));
    $.ajax({
      type: 'POST',
      url: site + 'manajemen/users/details',
      data: {'tokenId' : token, '<?php echo $this->security->get_csrf_token_name(); ?>' : $('input[name="'+csrfName+'"]').val()},
      dataType: 'json',
      success: function(dataUser) {
        $('input[name="'+csrfName+'"]').val(dataUser.csrfHash);
        if(dataUser.status == 1) {
       
          var $option = $("<option selected='selected'></option>").val(dataUser.message.sub_opd).text(dataUser.message.nm_sub_opd);

          $('#sub_opd').append($option).trigger('change');

          $('input[name="tokenId"]').val(token);
          $('#fullname').val(dataUser.message.fullname);
          $('#username').val(dataUser.message.username);
          $('#email').val(dataUser.message.email);
          $('#id_opd').select2('val', dataUser.message.id_opd).trigger('change');
          jabatanID = dataUser.message.id_jabatan;          

          $('#blokir').select2('val', dataUser.message.blokir);
          $('#status').select2('val', dataUser.message.status);
          $.each(dataUser.message.groupid, function(key, g){
            $('input[type="checkbox"][value="'+g+'"]#groupid_'+g).prop('checked', true);
          });
          console.log(jabatanID);
        }
        $('#frmEntry').waitMe('hide');
      }

    });
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
      message: "Apakah anda akan menyimpan data ini ?",
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
                  getDataListUser();
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

$(document).on('click', '#btnDelete', function(e){
  e.preventDefault();
  var token = [];
  $.each($('#listuser > tbody input[type=checkbox]:checked'), function(){
    token.push($(this).val());
  });

  var postData = {
    'tokenId': token,
    '<?php echo $this->security->get_csrf_token_name(); ?>' : $('input[name="'+csrfName+'"]').val()
  };
  $(this).html('<i class="fa fa-hourglass-half"></i> Diproses');
  $(this).addClass('disabled');
  run_waitMe($('#formParent'));
  bootbox.dialog({
    title: "Konfirmasi",
    message: "Apakah anda ingin menghapus data user ?",
    buttons: {
      "cancel" : {
        "label" : "<i class='fa fa-times'></i> Tidak",
        "className" : "btn-danger",
        callback:function(response) {
          if (response) {
            $('#btnDelete').html('<i class="fa fa-trash-o"></i> Delete User');
            $('#btnDelete').removeClass('disabled');
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
              url: site + 'manajemen/users/delete',
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
                getDataListUser();
              }
              $('#formParent').waitMe('hide');
            }).fail(function() {
              $('#errSuccess').html('<div class="alert alert-danger">'+
                '<strong>Peringatan!</strong> Proses delete data gagal...'+
                '</div>');
              $('#formParent').waitMe('hide');
            }).always(function() {
              $('#btnDelete').html('<i class="fa fa-trash-o"></i> Delete User');
              $('#btnDelete').removeClass('disabled');
            });
          }
        }
      }
    }
  });
});

var defaults = { minimumChars: 8 };
var progressHtml = "<div class='contextual-progress' style='margin-top:5px;margin-bottom:0px;'>"+
"<div class='clearfix'>"+
"<div class='progress-title'></div>"+
"</div>"+
"<div class='progress'>"+
"<div id='password-progress' class='progress-bar' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' style='width:0%;'></div>"+
"</div>"+
"</div>";
                      // $('input[type=password]:first').closest('div.input-group').after(progressHtml);
                      $(progressHtml).insertAfter($('input[type=password]:first').closest('div.input-group'));
                      $('.progress-title').text('');
                      $('.contextual-progress').hide();

                      $('#password').keyup(function (event) {
                        $('.contextual-progress').show();
                        var element = $(event.target);
                        var password = element.val();
                        if (password.length == 0) {
                          $('.progress-title').html('');
                          $('.contextual-progress').hide();
                        } else {
                          var score = calculatePasswordScore(password, defaults);
                          $('.progress-bar').css('width', score + '%').attr('aria-valuenow', score);
                          if(score == 0) {
                            $('.progress-title').html('Too short')
                          } else if (score < 50) {
                            $('.progress-title').html('Weak password');
                            $('#password-progress').removeClass();
                            $('#password-progress').addClass('progress-bar progress-bar-danger');
                          } else if (score >= 50 && score <= 60) {
                            $('.progress-title').html('Normal password');
                            $('#password-progress').removeClass();
                            $('#password-progress').addClass('progress-bar progress-bar-warning');
                          } else if (score > 60 && score <= 80) {
                            $('.progress-title').html('Good password');
                            $('#password-progress').removeClass();
                            $('#password-progress').addClass('progress-bar progress-bar-success');
                          } else if(score > 80) {
                            $('.progress-title').html('Strong password');
                            $('#password-progress').removeClass();
                            $('#password-progress').addClass('progress-bar progress-bar-primary');
                          }
                        }
                      });

$('#conf_password').keyup(function (event) {
  $('.progress-title').html('');
  $('.contextual-progress').hide();
  let password = $('#password').val();
  let confirm  = $(this).val();
  if(password !==  confirm && confirm.length > 0)
    $(this).closest('div.required').addClass('has-error').find('div.help-block').text('Password tidak cocok!');
  else
    $(this).closest('div.required').removeClass('has-error').find('div.help-block').text('');
});

$(document).on('click', '.showPass', function(e){
  let div = $(this).closest('div.input-group');
  let id  = div.find('input').attr('id');
  if($(this).hasClass('open')) {
    div.find('#'+id).attr('type', 'password');
    $(this).removeClass('open').addClass('closed').html('<i class="fa fa-eye"></i>');
  } else {
    div.find('#'+id).attr('type', 'text');
    $(this).removeClass('closed').addClass('open').html('<i class="fa fa-eye-slash"></i>');
  }
});

$(document).on('keyup', '#username', function() {
  var name = $(this).val();
  if(name.length > 0)
    checkUsername(name);
});

function checkUsername(newname) {
  $.ajax({
    type: 'POST',
    url: site + 'manajemen/users/searching',
    data: {'username' : newname, '<?php echo $this->security->get_csrf_token_name(); ?>' : $('input[name="'+csrfName+'"]').val()},
    dataType: 'json',
    success: function(data) {
      $('input[name="'+csrfName+'"]').val(data.csrfHash);
      if(data.message > 0)
        $('#username').closest('div.required').addClass('has-error').find('div.help-block').text('Username sudah ada!');
      else
        $('#username').closest('div.required').removeClass('has-error').find('div.help-block').text('');
    }
  });
}

function calculatePasswordScore(password, options) {
  var score = 0;
  var hasNumericChars = false;
  var hasSpecialChars = false;
  var hasMixedCase = false;
  if (password.length < 1)
    return score;
  if (password.length < options.minimumChars)
    return score;
    //match numbers
    if (/\d+/.test(password)) {
      hasNumericChars = true;
      score += 20;
      var count = (password.match(/\d+?/g)).length;
      if (count > 1) {
        //apply extra score if more than 1 numeric character
        score += 10;
      }
    }
    //match special characters including spaces
    if (/[\W]+/.test(password)) {
      hasSpecialChars = true;
      score += 20;
      var count = (password.match(/[\W]+?/g)).length;
      if (count > 1) {
        //apply extra score if more than 1 special character
        score += 10;
      }
    }
    //mixed case
    if ((/[a-z]/.test(password)) && (/[A-Z]/.test(password))) {
      hasMixedCase = true;
      score += 20;
    }
    if (password.length >= options.minimumChars && password.length < 12) {
      score += 10;
    } else if (!hasMixedCase && password.length >= 12) {
      score += 10;
    }
    if ((password.length >= 12 && password.length <= 15) && (hasMixedCase && (hasSpecialChars || hasNumericChars))) {
      score += 20;
    } else if (password.length >= 12 && password.length <= 15) {
      score += 10;
    }
    if ((password.length > 15 && password.length <= 20) && (hasMixedCase && (hasSpecialChars || hasNumericChars))) {
      score += 30;
    } else if (password.length > 15 && password.length <= 20) {
      score += 10;
    }
    if ((password.length > 20) && (hasMixedCase && (hasSpecialChars || hasNumericChars))) {
      score += 40;
    } else if (password.length > 20) {
      score += 20;
    }
    if (score > 100)
      score = 100;
    return score;
  }

  $(document).on('change', 'select[name="id_opd"]', function(e) {
    let id = $(this).val();
    getJabatan(id);
  });

  function getJabatan(opdId) {
    jabatanID = (jabatanID != '') ? jabatanID : '<?php echo $this->input->post('id_jabatan', TRUE); ?>';
    let lblJabatan = '';
    $.ajax({
      type: 'GET',
      url: site + 'manajemen/users/jabatan',
      data: {'opdId' : opdId},
      dataType: 'json',
      success: function(data) {
        $('input[name="'+csrfName+'"]').val(data.csrfHash);
        $('select[name="id_jabatan"]').html('').select2('data', null);
        if(data.status == 1) {
          lblJabatan = '<option value="">Pilih Jabatan</option>';
          $.each(data.message,function(key,value){
            lblJabatan += '<option value="'+value['id']+'">'+value['text']+'</option>';
          });
        } else
        lblJabatan = '<option value="">Pilih Jabatan</option>';
        $('select[name="id_jabatan"]').html(lblJabatan);
        $('select[name="id_jabatan"]').select2('val', jabatanID).trigger('change');
        
      }
    });
  }

  function getRegency(provinceId) {
    subOpdID = (subOpdID != '') ? subOpdID : '<?php echo $this->input->post('sub_opd', TRUE); ?>';
    let lblSubOpd = '';
    $.ajax({
      type: 'GET',
      url: site + 'manajemen/users/subOpd',
      data: {'opdId' : opdId},
      dataType: 'json',
      success: function(data) {
        $('input[name="'+csrfName+'"]').val(data.csrfHash);
        $('select[name="sub_opd"]').html('').select2('data', null);
        if(data.status == 1) {
          lblSubOpd = '<option value="">Pilih Sub OPD</option>';
          $.each(data.message,function(key,value){
            lblSubOpd += '<option value="'+value['id']+'">'+value['text']+'</option>';
          });
        } else
        lblSubOpd = '<option value="">Pilih Sub OPD</option>';
        $('select[name="sub_opd"]').html(lblSubOpd);
        $('select[name="sub_opd"]').select2('val', subOpdID).trigger('change');
      }
    });
  }

  function getSubOpd(opdId)
  {
    $.ajax({
     url      :"<?php echo site_url('manajemen/users/subOpd'); ?>",
     method   :"GET",
     dataType :"html",
     data: {'opdId' : opdId},
     beforeSend:function(){          
      $('#sub_opd').html("<h1>Loading <br><i class='fa fa-spinner fa-pulse fa-3x'></i> </h1>");
    },
    success:function(data)
    {
      $('input[name="'+csrfName+'"]').val(data.csrfHash);
      $('#sub_opd').html(data);        
    },
    error:function(){          
     $('#sub_opd').html('<p class="error"><strong>Oops!</strong> Try that again in a few moments.</p>');
   }
 });
  }  


  //panggil form Entri
  $(document).on('click', '#btnAddPegawai', function(e){
    formReset();
    $('#modalEntryFormPegawai').modal({
      backdrop: 'static'
    });
  });

  
  function autofill(){
    var nip =document.getElementById('nip').value;
    $.ajax({
     url  :"<?php echo base_url();?>manajemen/users/getPegawai",
     data :'&nip='+nip,
     success:function(data){
        var hasil = JSON.parse(data);  
        console.log(hasil.fullname);

               
         document.getElementById('nip').value=hasil.nip;
         document.getElementById('nama').value=hasil.fullname;/*
         document.getElementById('alamat').value=val.alamat;
         document.getElementById('telp').value=val.telp; */ 


       
     }
   });

  }

  $(document).on('click', '.pilih-pegawai', function (e) 
  {    
    $('input[name="nip"]').val($(this).attr('data-nip'));
    $('input[name="fullname"]').val($(this).attr('data-nama'));
    $('input[name="username"]').val($(this).attr('data-nip'));
    $('input[name="jabatan"]').val($(this).attr('data-jabatan'));

    $('#modalPilihPegawai').modal('hide');
  });

  $('#formEntryPegawai').submit(function(e) {
  e.preventDefault();
  var postData = $(this).serialize();
    // get form action url
    var formActionURL = $(this).attr("action");
    $("#savePegawai").html('<i class="fa fa-hourglass-half"></i> DIPROSES...');
    $("#savePegawai").addClass('disabled');
    run_waitMe($('#frmEntryPegawai'));
    bootbox.dialog({
      title: "Konfirmasi",
      message: "Apakah anda akan menyimpan data ini ?",
      buttons: {
        "cancel" : {
          "label" : "<i class='fa fa-times'></i> Tidak",
          "className" : "btn-danger",
          callback:function(response){
            if (response) {
              $("#savePegawai").html('<i class="fa fa-check"></i> SUBMIT');
              $("#savePegawai").removeClass('disabled');
              $('#frmEntryPegawai').waitMe('hide');
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
                  $('#errEntryPegawai').html('<div class="alert alert-danger" id="pesanErr"><strong>Peringatan!</strong> Tolong dilengkapi form inputan dibawah...</div>');
                  $.each(data.message, function(key,value){
                    if(key != 'isi')
                      $('input[name="'+key+'"], select[name="'+key+'"]').closest('div.required').addClass('has-error').find('div.help-block').text(value);
                    else {
                      $('#pesanErrPegawai').html('<strong>Peringatan!</strong> ' +value);
                    }
                  });
                  $('#modalEntryFormPegawai').animate({
                    scrollTop: (data.message.isi) ? 0 : ($('.has-error').find('input, select').first().focus().offset().top-300)
                  }, 'slow');
                } else {
                  $('#errSuccess').html('<div class="alert alert-dismissable alert-success">'+
                    '<strong>Sukses!</strong> '+ data.message +
                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                    '</div>');
                  $('#modalEntryFormPegawai').modal('toggle');
                  getDataListUser();
                }
                $('#frmEntryPegawai').waitMe('hide');
                getDataListUser();
              }).fail(function() {
                $('#errEntryPegawai').html('<div class="alert alert-danger">'+
                 '<strong>Peringatan!</strong> Harap periksa kembali data yang diinputkan...'+
                 '</div>');
                $('#frmEntryPegawai').waitMe('hide');
              }).always(function() {
                $("#savePegawai").html('<i class="fa fa-check"></i> SUBMIT');
                $("#savePegawai").removeClass('disabled');
              });
            }
          }
        }
      }
    });
});


 function formResetPegawai() {
    $('#formEntryPegawai').attr('action', site + 'manajemen/users/edit');
    $('#errEntryPegawai').html('');
    $('#blokir').select2('val', 0);
    $('#status').select2('val', 1);    
    $('.help-block').text('');
    $('.required').removeClass('has-error');
    $('form#formEntryPegawai').trigger('reset');
    $('.lblPass').text('*');
  }

  $(document).on('click', '.btnEditPegawai', function(e){
    e.stopPropagation();
    formResetPegawai();
    var token = $(this).data('token');
    $('#formEntryPegawai').attr('action', site + 'manajemen/users/edit');
    $('.lblPass').text('');
    $('#modalEntryFormPegawai').modal({
      backdrop: 'static'
    });
    getDataUserPegawai(token);
  });

  function getDataUserPegawai(token) {
    run_waitMe($('#frmEntryPegawai'));
    $.ajax({
      type: 'POST',
      url: site + 'manajemen/users/details',
      data: {'tokenId' : token, '<?php echo $this->security->get_csrf_token_name(); ?>' : $('input[name="'+csrfName+'"]').val()},
      dataType: 'json',
      success: function(dataUser) {
        $('input[name="'+csrfName+'"]').val(dataUser.csrfHash);
        if(dataUser.status == 1) {

          $('input[name="tokenId"]').val(token);
          $('#nip').val(dataUser.message.nip);
          $('#jabatan').val(dataUser.message.jabatan);
          $('#fullnamepegawai').val(dataUser.message.fullname);
          $('#usernamepegawai').val(dataUser.message.username);
          $('#emailpegawai').val(dataUser.message.email);
          
          $('#id_opd').select2('val', dataUser.message.id_opd).trigger('change');          

          $('#blokir').select2('val', dataUser.message.blokir);
          $('#status').select2('val', dataUser.message.status);
          $.each(dataUser.message.groupid, function(key, g){
            $('input[type="checkbox"][value="'+g+'"]#groupid_'+g).prop('checked', true);
          });
        }
        $('#frmEntryPegawai').waitMe('hide');
      }
    });
}


function getPegawai()
{
        $.ajax({
         url      :"<?php echo base_url('manajemen/users/getPegawai');?>",
         method   :"GET",
         dataType :"html",
         data:{
              data: 'data', <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
         },
         beforeSend:function(){                
          $('#pegawai_table').html("<h1><i class='fa fa-spinner fa-pulse fa-2x'></i> </h1>");
         },
         success:function(data)
         {
          $('#pegawai_table').html(data)
          $('.basic-datatables').dataTable({
            "ordering" : false
          });
         },
         error:function(){          
           $('#pegawai_table').html('<p class="error"><strong>Oops!</strong> Try that again in a few moments.</p>');
         }
        });
}     
</script>
