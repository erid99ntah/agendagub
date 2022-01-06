<div class="container">

   <div class="row">
      <div class="col-md-12">
          <div class="row"> 

              <div class="col-xs-12 col-sm-6">
                    <div class="panel panel-primary">
                      <div class="panel-heading">
                        <h4>Kalender</h4>
                      </div>
                      <div class="panel-body" style="padding:10px;">

                      </div>
                    </div>
              </div>

              <div class="col-xs-12 col-sm-6">
                    <div class="panel panel-primary">
                      <div class="panel-heading">
                        <h4>Agenda Akan Datang</h4>
                      </div>
                      <div class="panel-body" style="padding:10px;">

                      </div>
                    </div>
              </div>

              <div class="col-xs-12 col-sm-6">
                    <div class="panel panel-warning">
                      <div class="panel-heading">
                        <h4>Agenda Sekretaris</h4>
                      </div>
                      <div class="panel-body" style="padding:10px;">

                      </div>
                    </div>
              </div>


               <div class="col-xs-12 col-sm-6">
                    <div class="panel panel-info">
                      <div class="panel-heading">
                        <h4>Agenda Ketua DPRD</h4>
                      </div>
                      <div class="panel-body" style="padding:10px;">

                      </div>
                    </div>
              </div>



            

          </div>
      </div>
  </div>

  <div class="row">
    <div class="col-xs-12 col-sm-12">
      <div class="panel panel-primary hidden">
        <div class="panel-heading">
          <h4>Pemberitahuan Masuk</h4>
        </div>
        <div class="panel-body" style="padding:10px;">
          <?php echo form_open(site_url('#'), array('id'=>'formMail')); ?>
          <div class="table-responsive">
            <table cellspacing="0" cellpadding="0" class="table table-hover mailbox">
              <thead>
  							<tr>
  								<th width="6%">
                    <span><input type="checkbox" class="checkAll" id="default" style="margin:0px 0px 12px -2px;"></span>
                    <div class="btn-group option" style="margin-top:-6px;padding:6px 2px;">
                      <a class="btn-link tooltips dropdown-toggle" data-placement="bottom" title="Select" href="javascript:;" data-toggle="dropdown" style="padding:6px 2px;text-decoration:none;color:#444;"><b class="caret" ></b></a>
  										<ul class="dropdown-menu pull-left">
  											<li class="checkAll" id="all"><a href="javascript:;">All</a></li>
                        <li class="checkAll" id="none"><a href="javascript:;">None</a></li>
                        <li class="checkAll" id="read"><a href="javascript:;">Read</a></li>
  											<li class="checkAll" id="unread"><a href="javascript:;">Unread</a></li>
  										</ul>
                    </div>
                  </th>
                  <th width="15%">
                    <div class="btn-group" style="padding:6px 6px;">
                      <a class="btn-link tooltips delete" data-placement="bottom" title="Delete" style="padding:8px 14px;text-align:center;text-decoration:none;color:#444;font-size:18px;display:none;"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                      <a class="btn-link tooltips more" data-placement="bottom" title="More" href="javascript:;" data-toggle="dropdown" style="padding:8px 18px;text-align:center;text-decoration:none;color:#444;font-size:18px;"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
                      <ul class="dropdown-menu pull-left">
                        <li><a href="javascript:;" id="btnMarkAll"><b>Mark all as read</b></a></li>
                      </ul>
                    </div>
                  </th>
  								<th colspan="2">
                    <div class="pull-left" style="width:70%;">
                      <div id="errSuccess"></div>
                    </div>
  									<div class="pull-right" id="paging" style="font-size:16px;">
  										<div class="btn-group" style="padding:6px 2px;">
                        <a class="btn-link pagination-info" href="javascript:;" data-toggle="dropdown" style="padding:6px 6px;text-decoration:none;color:#444;" data-page="1">1-30 of 789</a>
                        <ul class="dropdown-menu pull-left">
    											<li class="disabled btnPage" id="newer"><a href="javascript:;"><b>Newer</b></a></li>
                          <li class="btnPage" id="older"><a href="javascript:;"><b>Older</b></a></li>
    										</ul>
                        <a class="btn-link tooltips btnPage" id="prev" data-placement="bottom" style="padding:7px 16px;text-align:center;text-decoration:none;color:#444;font-size:18px;" title="Newer"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
                        <a class="btn-link tooltips btnPage" id="next" data-placement="bottom" style="padding:7px 16px;text-align:center;text-decoration:none;color:#444;font-size:18px;" title="Older"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                      </div>
  									</div>
  								</th>
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
  $.fn.modal.Constructor.prototype.enforceFocus = function() {};
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
  var site     = '<?php echo site_url();?>';
  var noPage   = 1; var maxPage;
  $(document).ready(function(e){
    /*getDataListMail(noPage);
    var pusher = new Pusher('a6be18f8aa19ab9f3828', {
      cluster: 'ap1',
      forceTLS: true
    });
    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
      if(data.message == 'notifsuccess') {
        getDataListMail(noPage);
      }
    });*/
  });

  function run_waitMe(el) {
    el.waitMe({
			effect: 'facebook',
			text: 'Loading...',
			bg: 'rgba(255,255,255,0.7)',
			color: '#000',
			maxSize: '40px',
			waitTime: 3000,
      textPos: 'vertical',
			fontSize: '18px',
			onClose: function(el) {}
		});
  }

  $(document).on('click', '.btnPage', function(e){
    var flag = $(this).attr('id');
    var no    = $('#paging').find('.pagination-info').data('page');
    noPage = (flag == 'newer') ? 1 : ((flag == 'older') ? maxPage : ((flag == 'next') ? ((no==maxPage) ? maxPage : parseInt(no) + 1) : ((parseInt(no) - 1 <= 0) ? 1 : parseInt(no) - 1)));
    $('#paging').find('.pagination-info').data('page', noPage);
    if(noPage == 1) {
      $('#newer').addClass('disabled');
      $('#older').removeClass('disabled');
    } else if(noPage == 3) {
      $('#newer').removeClass('disabled');
      $('#older').addClass('disabled');
    } else {
      $('#newer').removeClass('disabled');
      $('#older').removeClass('disabled');
    }
    $('.mailbox > tbody input[type=checkbox]').removeProp('checked').trigger('change');
    getDataListMail(noPage);
  });

  function getDataListMail(numpage) {
    var html = "";
    run_waitMe($('.panel'));
    $.ajax({
      type: 'POST',
      url: site + 'home/inbox/listview',
      data:{page:numpage, '<?php echo $this->security->get_csrf_token_name(); ?>' : $('input[name="'+csrfName+'"]').val()},
      dataType: 'json',
      success: function(data) {
        $('input[name="'+csrfName+'"]').val(data.csrfHash);
        if(data.records.length > 0) {
          $.each(data.records, function(key,value){
            html += '<tr class="btnView '+((value['unread']==1) ? "unread" : "read")+'" data-href="'+value['url']+'">';
              html += '<td><input type="checkbox" name="checkid[]" value="'+value['token']+'" style="margin-left:-2px;" onclick="event.stopPropagation();"></td>';
              html += '<td width="15%">'+value['fullname']+'</td>';
              html += '<td>'+value['reference']+'</td>';
              html += '<td class="text-right" width="10%">'+[value['create_date']]+'</td>';
            html += '</tr>';
          });
        } else {
          html = '<tr><td colspan="4">Belum ada pemberitahuan masuk</td></tr>';
        }
        maxPage = (data.recordsTotal != 0) ? Math.ceil(parseInt(data.recordsTotal)/data.limit) : 1;
        $('#paging').find('.pagination-info').text(data.recordsFiltered+' to '+data.recordsTotal);
        $('.mailbox > tbody').html(html);
        $('.panel').waitMe('hide');
      }
    });
  }

  // Handle click on "Select all" control
  $(document).on('click', '.checkAll', function() {
    var id = $(this).attr('id');
    if(id=='default')
      $('.mailbox > tbody input[type=checkbox]').prop('checked', this.checked).trigger('change');
    else if(id=='all')
      $('.mailbox > tbody input[type=checkbox]').prop('checked', 'checked').trigger('change');
    else if(id=='none')
      $('.mailbox > tbody input[type=checkbox]').removeProp('checked').trigger('change');
    else if(id=='read') {
      $('.mailbox > tbody > tr.read input[type=checkbox]').prop('checked', 'checked').trigger('change');
      $('.mailbox > tbody > tr.unread input[type=checkbox]').removeProp('checked').trigger('change');
    } else if(id=='unread') {
      $('.mailbox > tbody > tr.unread input[type=checkbox]').prop('checked', 'checked').trigger('change');
      $('.mailbox > tbody > tr.read input[type=checkbox]').removeProp('checked').trigger('change');
    }
  });

  // Handle click on "Select all" control
  $(document).on('change', '.mailbox > tbody input[type=checkbox]', function (e) {
    var rowCount = $('.mailbox > tbody input[type=checkbox]').length;
    var n = $('.mailbox > tbody input[type=checkbox]').filter(':checked').length;
    if(n > 0)
			$('a.delete').show();
		else
			$('a.delete').hide();

    if(this.checked)
      $(this).closest('tr').addClass('info');
    else
      $(this).closest('tr').removeClass('info');

    if(rowCount == n)
			$('input[type="checkbox"].checkAll').prop('checked', 'checked');
		else
			$('input[type="checkbox"].checkAll').removeProp('checked');
  });

  $(document).on('click', '#btnMarkAll', function(e){
    e.preventDefault();
    run_waitMe($('.panel'));
    $.ajax({
      url: site + 'home/inbox/update',
      type: "POST",
      data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : $('input[name="'+csrfName+'"]').val()},
      dataType: "json",
    }).done(function(data) {
      $('input[name="'+csrfName+'"]').val(data.csrfHash);
      if(data.status == 0) {
        $('#errSuccess').html('<div class="alert alert-dismissable alert-danger" style="margin:0px;padding:5px 25px 5px 10px;"> '+
                                '<b>Pesan gagal diupdate...</b>'+
                                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                               '</div>');
      } else {
        $('#errSuccess').html('<div class="alert alert-dismissable alert-success" style="margin:0px;padding:5px 25px 5px 10px;">'+
                                '<b>Pesan sukses diupdate...</b>'+
                                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                               '</div>');
      }
      getDataListMail(noPage);
      $('.panel').waitMe('hide');
    }).fail(function() {
      $('.panel').waitMe('hide');
    });
  });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    var postData = $('#formMail').serialize();
    run_waitMe($('.panel'));
    $.ajax({
      url: site + 'home/inbox/delete',
      type: "POST",
      data: postData,
      dataType: "json",
    }).done(function(data) {
      $('input[name="'+csrfName+'"]').val(data.csrfHash);
      if(data.status == 0) {
        $('#errSuccess').html('<div class="alert alert-dismissable alert-danger" style="margin:0px;padding:5px 25px 5px 10px;"> '+
                                '<b>Pesan gagal dihapus...</b>'+
                                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                               '</div>');
      } else {
        $('#errSuccess').html('<div class="alert alert-dismissable alert-success" style="margin:0px;padding:5px 25px 5px 10px;">'+
                                '<b>Pesan telah dihapus...</b>'+
                                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' +
                               '</div>');
      }
      noPage = (noPage > data.totalRow) ? data.totalRow : noPage;
      $('#paging').find('.pagination-info').data('page', noPage);
      getDataListMail(noPage);
      $('.panel').waitMe('hide');
    }).fail(function() {
      $('.panel').waitMe('hide');
    });
  });

  $(document).on('click', '.btnView', function(e){
    e.preventDefault();
    let href = $(this).data('href');
    var id = $(this).find('input[type="checkbox"]').val();
    $.ajax({
      type: 'POST',
      url: site + 'home/inbox/update',
      data:{token:id, '<?php echo $this->security->get_csrf_token_name(); ?>' : $('input[name="'+csrfName+'"]').val()},
      dataType: 'json',
      success: function(data) {
        $('input[name="'+csrfName+'"]').val(data.csrfHash);
        window.document.location = site + href;
      }
    });
  });
</script>
