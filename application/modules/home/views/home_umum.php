<div class="container">

   <div class="row">
    <div class="col-md-12">
      <div class="row"> 

        <div class="col-xs-12 col-sm-4">   
         
            <div id="myCalendar" class="vanilla-calendar" style="margin-bottom: 20px"></div>   
                    
        </div>

        <div class="col-xs-12 col-sm-8">
              <div class="panel panel-warning">
                <div class="panel-heading">
                  <h4>Disposisi Masuk : <span class="tgl_disposisi"></span></h4>
                </div>
                <div class="panel-body" style="padding:10px;">             

                    <table class="table table-bordered table-striped dispomasuk">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Isi Disposisi</th>
                          <th>Nama Agenda</th>
                          <th>Tanggal Agenda</th>
                          <th>Pengirim Disposisi</th>
                          <th>Tanggal Disposisi</th>
                          <th>Penerima</th>
                          <th>Status Disposisi</th>
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
          getDataListDisposisi(tgl_diklik);
        }
      });
      let tgl='<?php echo date('Y-m-d');?>';
      
      getDataListDisposisi(tgl);
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


  function getDataListDisposisi(tgl) 
  {
      var html = "";
      var html2 = "";
      run_waitMe($('.panel'));
      $.ajax({
        type: 'POST',
        url: site + 'home/home/listdisposisi',
        data:{tgl:tgl, '<?php echo $this->security->get_csrf_token_name(); ?>' : $('input[name="'+csrfName+'"]').val()},
        dataType: 'json',
        success: function(data)
        {
          $('.tgl_disposisi').html(data.tgl);
          $('input[name="'+csrfName+'"]').val(data.csrfHash);
          if(data.dataDispomasuk.length > 0) {
            var no=0;
            $.each(data.dataDispomasuk, function(key,value){
              no++;
              html += '<tr>';
                html += '<td>'+no+'</td>';
                html += '<td><a href="<?php echo site_url('dokumen/dispomasuk/review/');?>'+value['token']+'">'+value['isi_disposisi']+'</a></td>';
                html += '<td width="15%">'+value['nama_agenda']+'</td>';
                html += '<td width="15%">'+value['tanggal']+'</td>';
                html += '<td width="15%">'+value['nm_pengirim']+'</td>';
                html += '<td>'+value['tgl_disposisi']+'</td>';
                html += '<td>'+value['penerima_disposisi']+'</td>';
                html += '<td>'+value['status_baca']+'</td>';
              html += '</tr>';
            });
          } else {
            html = '<tr><td colspan="6">Data Belum Ada</td></tr>';
          }
          
          $('.dispomasuk > tbody').html(html);
          $('.panel').waitMe('hide');
        }        
      });
  } 
 

  
</script>