<div class="container">
  <?php
   echo $this->session->flashdata('message'); 
   if(count($detail)<=0){
      error_message('danger', '404!', 'Data Not Found');
      redirect('dokumen/draft');
   }
   ?>
  <div class="row">
    <div class="col-md-12">


    <div class="row">
      <div class="col-md-12">
        <div class="col-md-8">
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
      if ($this->app_loader->is_admin() ||  $this->app_loader->is_pimpinan()) 
      {

        if ($detail['id_status']=='SM' ) 
        {
          
        ?>
          <div class="panel panel-green">
            <div class="panel-heading">Status Agenda</div>  
            <div class="panel-body">
                 <?php echo form_open(site_url('dokumen/draft/validasi'), array('class' => 'form-horizontal row-border', 'role' => 'form')); ?>
                  <div class="panel-body">
                  <input type="hidden" name="token" value="<?php echo $detail['token'];?>" >
                    <div class="form-group">
                      <label for="id_status" class="col-sm-3 control-label"><b> Status Agenda</b></label>
                      <div class="col-sm-6">
                        <?php echo form_dropdown('id_status', array('' =>'Pilih Status Agenda', 'SH'=>'Dihadiri', 'SW'=>'Diwakilkan'), $this->input->post('id_status'), 'class="select-all"', 'id="id_status"');?>
                      </div>
                    </div>
                    

                    <div class="form-group" id="disposisi" >
                      <label for="id_status" class="col-sm-3 control-label"><b> Penerima Disposisi</b></label>
                      <div class="col-sm-6">
                        <select name="penerima_disposisi" id="penerima_disposisi" class="select-all">
                            <option value="" selected>---Pilih Penerima Disposisi---</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="keterangan" class="col-sm-3 control-label"><b id="ket">Keterangan</b></label>
                      <div class="col-sm-6">
                        <textarea class="form-control" name="keterangan" id="keterangan" rows="3" placeholder="Keterangan"><?php echo set_value('keterangan'); ?></textarea>
                      </div>
                    </div>
                    
                  </div>
                  <div class="panel-footer">
                    <div class="row">
                      <div class="col-sm-6 col-sm-offset-3">
                        <div class="btn-toolbar">
                          <input class="btn-primary btn" type="submit" name="save" id="save" value="Simpan Data">
                          <a href="javascript:history.back()" class="btn-default btn">Batal</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php echo form_close(); ?>
            </div>
          </div>

        <?php
        }
      }
      ?>


       <?php
      if ($detail['id_status']=='SW') 
      {
        $disposisi = $this->mmas->getDisposisiByAgenda($detail['id_agenda']);

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
                                   echo "<ol>"; 
                                  $no=0;
                                  foreach ($penerima_disposisi as $key => $pd) 
                                  {
                                    $no++;
                                    echo '<li> '.$pd['nama'].'</li>';
                                  }
                                  echo "</ol>";
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

<script type="text/javascript">  
  var csrfName  = '<?php echo $this->security->get_csrf_token_name(); ?>';
  var site      = '<?php echo site_url();?>';

   $(document).ready(function(e){
      var x = document.getElementById("disposisi");
      if (x.style.display === "none") {
        x.style.display = "block";
      } else {
        x.style.display = "none";
      }
  });

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
      url: site + 'dokumen/draft/getPenerimaDisposisi',
      data: {'token_agenda': '<?php echo $detail['token'];?>','jenis_agenda' : id},
      dataType: 'html',
      success: function(response) {       
         
          $('#penerima_disposisi').html(response);       
      }
    });
  }
</script>