<div class="container">

   <div class="row">
    <div class="col-md-12">
      <div class="row"> 

      <?php
        if ($this->app_loader->is_ajudan())
          $view_agenda='hidden';
        else
          $view_agenda='';
      ?>

        <div class="col-xs-12 col-sm-4">   
         
            <div id="myCalendar" class="vanilla-calendar" style="margin-bottom: 20px"></div>   
                    
        </div>

        <div class="col-xs-12 col-sm-8">
              <div class="panel panel-warning" >
                <div class="panel-heading">
                  <h4>Agenda Pimpinan Tanggal : <span class="tgl_agenda"></span></h4>
                </div>
                <div class="panel-body" style="padding:10px;">             
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped agendaPimpinan" style="width:100%;overflow:auto;">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Agenda</th>
                          <th>Kegiatan</th>
                          <th>Jam Mulai</th>
                          <th>Jam Selesai</th>
                          <th>Lokasi</th>
                          <th>Status Agenda</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>
                </div>
              </div>
              
        </div>
       
      </div>
    </div>
  </div>

 

</div><!-- container -->

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/vanilla/css/vanilla-calendar-min.css" rel="stylesheet" /> 
<script type="text/javascript"src="<?php echo base_url();?>assets/plugins/vanilla/js/vanilla-calendar-min.js"></script>
<script type="text/javascript">  
  $.fn.modal.Constructor.prototype.enforceFocus = function() {};
  var csrfName  = '<?php echo $this->security->get_csrf_token_name(); ?>';
  var site      = '<?php echo site_url();?>';
  

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

  $(document).ready(function(e)
  {
      let calendar = new VanillaCalendar({
        selector: "#myCalendar",
        months: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
        shortWeekday: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
        onSelect: (data, elem) => {       
          let tgl = data.date;
          let tgl_diklik = GetFormattedDate(tgl);
          getDataListAgenda(tgl_diklik);
        }
      });
      let tgl='<?php echo date('Y-m-d');?>';
      
      getDataListAgenda(tgl);
  });

  function GetFormattedDate(tgl) {
      date = new Date(tgl);
      year = date.getFullYear();
      month = date.getMonth()+1;
      dt = date.getDate();

      if (dt < 10) {
        dt = '0' + dt;
      }
      if (month < 10) {
        month = '0' + month;
      }

     return year+'-' + month + '-'+dt;
  }

  function getAgenda(tgl_diklik)
  {
    var html = "";
    $.ajax({
      type: 'POST',
      url: site + 'home/home/listview',
      data:{tgl:tgl_diklik, '<?php echo $this->security->get_csrf_token_name(); ?>' : $('input[name="'+csrfName+'"]').val()},
      dataType: 'json',
      success: function(data) {
        
      }
    });
  }


  function getDataListAgenda(tgl) 
  {
      var html = "";
      var html2 = "";
      run_waitMe($('.panel'));
      $.ajax({
        type: 'POST',
        url: site + 'home/home/listview',
        data:{tgl:tgl, '<?php echo $this->security->get_csrf_token_name(); ?>' : $('input[name="'+csrfName+'"]').val()},
        dataType: 'json',
        success: function(data)
        {
          $('.tgl_agenda').html(data.tgl);
          $('input[name="'+csrfName+'"]').val(data.csrfHash);
          if(data.agendaPimpinan.length > 0) {
            var no=0;
            $.each(data.agendaPimpinan, function(key,value){
              no++;
              var ket='';
              var id_status=value['id_status'];
              if (id_status=='SH')
               ket='success';
              else
               ket='primary';

              html += '<tr>';
                html += '<td>'+no+'</td>';
                html += '<td><a href="<?php echo site_url('dokumen/agenda/review/');?>'+value['token']+'">'+value['nama_agenda']+'</a></td>';
                html += '<td width="15%">'+value['kegiatan']+'</td>';
                html += '<td>'+value['jam_mulai']+'</td>';
                html += '<td>'+value['jam_selesai']+'</td>';
                html += '<td>'+value['lokasi_kegiatan']+'</td>';
                html += '<td><label style="font-size:15px;" class="label label-'+ket+' label-lg">'+value['status_agenda']+'</label></td>';
              html += '</tr>';
            });
          } else {
            html = '<tr><td colspan="7">Data Belum Ada</td></tr>';
          }
            
          $('.agendaPimpinan > tbody').html(html);
          $('.panel').waitMe('hide');
        }        
      });
  } 
 

  
</script>