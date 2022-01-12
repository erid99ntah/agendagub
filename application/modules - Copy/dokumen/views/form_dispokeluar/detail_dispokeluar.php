<div class="container">
  <?php
   echo $this->session->flashdata('message'); 
   if(count($detail)<=0){
      error_message('danger', '404!', 'Data Not Found');
      redirect('dokumen/dispokeluar');
   }
   ?>
  <div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  <h4>Detail Disposisi</h4>
                </div>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <td>Pengirim Disposisi</td>
                      <td><?php echo $detail['fullname'];?></td>
                    </tr>
                    <tr>
                      <td>Isi Disposisi</td>
                      <td><?php echo $detail['isi_disposisi'];?></td>
                    </tr>
                    <tr>
                      <td>Tanggal Disposisi</td>
                      <td><?php echo tgl_indo_time($detail['tgl_disposisi']);?></td>
                    </tr>                   
                  </thead>
                </table>
              </div>
              <div class="panel panel-primary">
                <div class="panel-heading">
                  <h4>Penerima Disposisi</h4>                
                </div>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <td>No</td>
                      <td>Penerima Disposisi</td>
                      <td>Tanggal Terima</td>
                      <td>Status Terima</td>
                    </tr>                    
                  </thead>
                  <tbody>
                  <?php 
                     $penerima_disposisi = $this->mmas->getPenerimaDisposisi($detail['id_disposisi']);
                     $i=0;
                     foreach ($penerima_disposisi as $key => $pd) :
                     $i++;
                  ?>
                      <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $pd['nama'];?></td>
                        <td><?php echo $pd['tgl_terima'];?></td>
                        <td><?php echo convert_status_penerima($pd['status_penerima']);?></td>
                      </tr>
                  <?php endforeach;?>
                  </tbody>
                </table>
              </div>
              
        </div>

        <div class="col-md-6">
             <div class="panel panel-success">
                <div class="panel-heading">
                  <h4>Detail Agenda</h4>
                  <?php $detail_agenda=$this->mmas->getDetailAgendaByID($detail['id_agenda']);?>
                </div>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <td>Nama Agenda</td>
                      <td><?php echo $detail_agenda['nama_agenda'];?></td>
                    </tr>
                    <tr>
                      <td>Jenis Agenda</td>
                      <td><?php echo convert_agenda($detail_agenda['jenis_agenda']);?></td>
                    </tr>
                    <tr>
                      <td>Status Agenda</td>
                      <td><?php echo $detail_agenda['nm_status'];?></td>
                    </tr>
                    <tr>
                      <td>Tanggal Agenda</td>
                      <td><?php echo tgl_indo($detail_agenda['tanggal']).'<b> Jam : '.$detail_agenda['jam_mulai'].' s.d '.$detail_agenda['jam_selesai'];?> WIB</b></td>
                    </tr>
                    <tr>
                      <td>Kegiatan</td>
                      <td><?php echo $detail_agenda['kegiatan'];?></td>
                    </tr>
                    <tr>
                      <td>Lokasi Kegiatan</td>
                      <td><?php echo $detail_agenda['lokasi_kegiatan'];?></td>
                    </tr>
                  </thead>
                </table>
              </div>
        </div>

    </div>
  </div>
</div><!-- container -->
