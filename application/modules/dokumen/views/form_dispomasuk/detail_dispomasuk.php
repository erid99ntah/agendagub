<div class="container">
  <?php
   echo $this->session->flashdata('message'); 
   if(count($detail)<=0){
      error_message('danger', '404!', 'Data Not Found');
      redirect('dokumen/dispomasuk');
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
                  <h4>Detail Penerima Disposisi</h4>
                </div>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <td>Penerima Disposisi</td>
                      <td>
                          <?php 
                          $nm_penerima  = $this->m_masuk->getUserFullname($detail['id_penerima']);
                          echo $nm_penerima;
                          ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Status Penerima</td>
                      <td><?php echo convert_status_penerima($detail['status_penerima']);?></td>
                    </tr>
                    <tr>
                      <td>Tanggal Terima</td>
                      <td><?php echo tgl_indo_time($detail['tgl_disposisi']);?></td>
                    </tr>                   
                  </thead>
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
