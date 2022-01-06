<div class="container">
  <?php
   echo $this->session->flashdata('message'); 
   if(count($detail)<=0){
      error_message('danger', '404!', 'Data Not Found');
      redirect('dokumen/agenda');
   }
   ?>
  <div class="row">
    <div class="col-md-12">

      <div class="row">
        <div class="col-md-12">
            <div class="col-md-8" style="padding:0;margin:0;">
                <div class="panel panel-primary">
                  <div class="panel-heading">
          		      <h4>Detail Agenda</h4>
          		    </div>
                  <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <td>Nama Agenda</td>
                        <td><?php echo $detail['nama_agenda'];?></td>
                      </tr>
                      <tr>
                        <td>Jenis Agenda</td>
                        <td><?php echo convert_agenda($detail['jenis_agenda']);?></td>
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
                            <td>Dokumen</td>
                            <td><?php
                              $tahun = substr($detail['create_date'],0,4);
                              $bulan = substr($detail['create_date'],5,2); 
                              $dokumen = $detail['dokumen'];

                              if ( ($dokumen !="") && file_exists('images/agenda/'.$tahun.'/'.$bulan.'/'.$dokumen) ){
                               $url=site_url('images/agenda/'.$tahun.'/'.$bulan.'/'.$dokumen);
                                
                               echo '<a href="'.site_url('dokumen/draft/download_file/'.$detail['token']).'">
                                      '.$detail['dokumen'].'
                                      </a>';   
                              }
                              else{
                                echo "File Not Found";
                                $url='';
                              }
                                       
                              ?>
                            </td>
                          </tr>

                    </thead>
                  </table>
                </div>
          </div>
          <div class="col-md-4">
              <div class="panel panel-primary">
                    <div class="panel-heading">
                      <h4>Dokumen</h4>
                    </div>

                    <?php
                       echo '<embed  style="width:100%;height:300px;" src="http://docs.google.com/gview?url='.$url.'&embedded=true" type="text/html" >'
                    ?>
                </div>
          </div>
      </div>
    </div>
    <?php
      if ($detail['id_status']=='SW') 
      {
        $disposisi = $this->mag->getDisposisiByAgenda($detail['id_agenda']);

        echo '<div class="panel panel-primary">
                <div class="panel-heading">Disposisi</div>';  
                echo ' <table class="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th>Tanggal Disposisi</th>
                            <th>Isi Disposisi</th>
                            <th>Pengirim Disposisi</th>
                            <th>Penerima Disposisi</th>                            
                          </tr>
                        </thead>';
                        echo '<tbody>';
                        foreach ($disposisi as $key => $ds) {                          
                          echo '<tr>';
                                echo '<td> '.tgl_indo_time($ds['tgl_disposisi']).'</td>';
                                echo '<td> '.$ds['isi_disposisi'].'</td>';
                                echo '<td> '.$ds['fullname'].'</td>';
                                $penerima_disposisi = $this->mmas->getPenerimaDisposisi($ds['id_disposisi']);
                                echo '<td>'; 
                                  foreach ($penerima_disposisi as $key => $pd) 
                                  {
                                   echo $pd['nama'];
                                  }
                                 echo '</td>'; 
                                
                          echo '</tr>';
                        }
                  echo '</tbody>';
                  echo '</table>';
        echo '</div>'  ;
      }
    ?>
      

    </div>
  </div>
</div><!-- container -->
