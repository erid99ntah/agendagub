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
            <div class="col-md-6" style="padding:0;margin:0;">
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
                                
                               echo '<a href="'.site_url('dokumen/draft/download_file/'.$detail['token']).'">
                                      '.$detail['dokumen'].'
                                      </a>';  
                                      $drv = ''; 
                              }
                              else{
                                echo "File Not Found";
                                $url='';
                                $drv='hidden';
                              }
                                       
                              ?>
                            </td>
                          </tr>

                          <tr>
                              <td>Status Agenda</td>
                              <td><label class="label label-primary"> <?php echo $detail['nm_status'];?> </label> </td>
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
          <div class="col-md-6" <?php echo $drv;?>>
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
    <?php
      if ($detail['id_status']=='SW') 
      {
        /*$disposisi = $this->mag->getDisposisiByAgenda($detail['id_agenda']);

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
        echo '</div>'  ;*/
      }
    ?>
      

    </div>
  </div>
</div><!-- container -->
