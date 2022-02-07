<div class="container">
  <?php
   echo $this->session->flashdata('message'); 
   if(count($detail)<=0){
      error_message('danger', '404!', 'Data Not Found');
      redirect('dokumen/draftnew');
   }
   ?>
  <div class="row">
    <div class="col-md-12">


    <div class="row">
      <div class="col-md-12">
        <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
    		      <h4>Detail Agenda</h4>
    		    </div>
            <table class="table table-striped table-bordered" style="width:100%;overflow:auto;" >
              <thead>
                <tr>
                  <td>Nama Agenda</td>
                  <td><?php echo $detail['nama_agenda'];?></td>
                </tr>
                <tr>
                    <td>Status Agenda</td>
                    <td><label class="label label-primary"> <?php echo $detail['nm_status'];?> </label> </td>
                </tr>
                <tr>
                  <td>Status Agenda</td>
                  <td><?php echo $detail['nm_status'];?></td>
                </tr>
                <tr>
                  <td>Tanggal Agenda</td>
                  <td><?php echo tgl_indo($detail['tanggal']).'<b> Jam : '.$detail['jam_mulai'].' s.d '.$detail['jam_selesai'];?> WIB</b></td>
                </tr>
                <tr>
                  <td>Kegiatan</td>
                  <td><?php echo $detail['kegiatan'];?></td>
                </tr>
                <tr>
                  <td>Lokasi Kegiatan</td>
                  <td><?php echo $detail['lokasi_kegiatan'];?></td>
                </tr>

                 <tr>
                    <td>Penyelenggara Kegiatan</td>
                    <td><?php echo $detail['penyelenggara'];?></td>
                  </tr>

                   <tr>
                    <td> Contact Person</td>
                    <td><?php echo $detail['cp'];?></td>
                  </tr>

                <tr>
                  <td>Dokumen</td>
                  <td><?php
                    $tahun = substr($detail['create_date'],0,4);
                    $bulan = substr($detail['create_date'],5,2); 
                    $dokumen = $detail['dokumen'];

                    if ( ($dokumen !="") && file_exists('images/agenda/'.$tahun.'/'.$bulan.'/'.$dokumen) ){
                     $url=site_url('images/agenda/'.$tahun.'/'.$bulan.'/'.$dokumen);
                      
                     echo '<a href="'.site_url('dokumen/draftnew/download_file/'.$detail['token']).'">
                            '.$detail['dokumen'].'
                            </a>'; 
                      $showDoc='';  
                    }
                    else{
                      echo "File Not Found";
                      $url='';
                      $showDoc='hidden';
                    }
                             
                    ?>
                  </td>
                </tr>

                <tr>
                    <td> Penerima Disposisi</td>
                    <td> <?php echo $detail['penerima_disposisi'];?> </td>
                </tr>

                <tr>
                    <td> Keterangan Hadir</td>
                    <td> <?php echo $detail['keterangan_hadir'];?> </td>
                </tr>

              </thead>
            </table>
          </div>
        </div>
        <div class="col-md-6" <?php echo $showDoc;?> >
            <div class="panel panel-primary">
                <div class="panel-heading">
                  <h4>Dokumen</h4>
                </div>

                <?php
                   echo ' <object data="'.$url.'" type="application/pdf" style="width:100%;height:500px;"></object>';
                ?>
            </div>

        </div>
    </div>
  </div>
     


    </div>
  </div>
</div><!-- container -->

<script type="text/javascript">  
  var csrfName  = '<?php echo $this->security->get_csrf_token_name(); ?>';
  var site      = '<?php echo site_url();?>';

  
  $(document).on('change', 'select[name="id_status"]', function(e) {
    let id = $(this).val();
    if (id=='SH') {
      var x = document.getElementById("disposisi");      
      x.style.display = "none";
      $('#ket').html('Keterangan');
    }
    else
    {
      $('#ket').html('Isi Disposisi');
      var x = document.getElementById("disposisi");      
      x.style.display = "block";
      
      getPenerimaDisposisi(id)
    }    
  });

  function getPenerimaDisposisi(id) {    
    
    $.ajax({
      type: 'GET',
      url: site + 'dokumen/draftnew/getPenerimaDisposisi',
      data: {'token_agenda': '<?php echo $detail['token'];?>','jenis_agenda' : id},
      dataType: 'html',
      success: function(response) {       
         
          $('#penerima_disposisi').html(response);       
      }
    });
  }
</script>