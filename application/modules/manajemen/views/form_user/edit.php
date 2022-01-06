<div class="container">
  <?php echo $this->session->flashdata('message'); ?>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-midnightblue">
        <div class="panel-heading">
		      <h4>Form Edit Manajemen Users</h4>
		    </div>
        <?php echo form_open(site_url($urlform), array('class' => 'form-horizontal row-border', 'role' => 'form')); ?>
        <div class="panel-body">
          <div class="form-group">
            <label for="cari" class="col-sm-3 control-label">Cari Pegawai</label>
            <div class="col-sm-6">
              <input type="text" class="search" name="search" id="search" style="width:100%;" value="<?php echo $data_users->nama_user; ?>" disabled>
            </div>
          </div>
          <div class="form-group">
            <label for="nip" class="col-sm-3 control-label">NIP</label>
            <div class="col-sm-3">
              <input type="hidden" class="form-control" name="pegawai" id="pegawai" value="<?php echo $data_users->id_pegawai; ?>" readonly>
              <input type="text" class="form-control" name="nip" id="nip" placeholder="NIP" value="<?php echo nip($data_users->nip); ?>" readonly>
              <?php echo form_error('nip'); ?>
            </div>
          </div>
          <div class="form-group">
            <label for="nama_user" class="col-sm-3 control-label">Nama Pegawai</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="nama_pegawai" id="nama_pegawai" placeholder="Nama Pegawai" value="<?php echo $data_users->nama_pegawai; ?>" readonly>
              <?php echo form_error('nama_pegawai'); ?>
            </div>
          </div>
          <div class="form-group">
            <label for="nama_user" class="col-sm-3 control-label">Jabatan Pegawai</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" name="jabatan" id="jabatan" placeholder="Jabatan Pegawai" value="<?php echo ucwords_title($data_users->jabatan); ?>" readonly>
              <?php echo form_error('jabatan'); ?>
            </div>
          </div>
          <div class="form-group">
				    <label for="username" class="col-sm-3 control-label">Username</label>
				    <div class="col-sm-4">
              <input type="hidden" name="users" value="<?php echo $data_users->id_users; ?>">
				      <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $data_users->username; ?>">
              <?php echo form_error('username'); ?>
            </div>
				  </div>
          <div class="form-group">
            <label for="email" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $data_users->email; ?>">
              <?php echo form_error('email'); ?>
            </div>
          </div>
          <div class="form-group">
				    <label for="password" class="col-sm-3 control-label">Password</label>
				    <div class="col-sm-3">
				      <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo set_value('password'); ?>">
              <?php echo form_error('password'); ?>
            </div>
				  </div>
          <div class="form-group">
				    <label for="conf_password" class="col-sm-3 control-label">Konfirmasi Password</label>
				    <div class="col-sm-3">
				      <input type="password" class="form-control" name="conf_password" id="conf_password" placeholder="Konfirmasi Password" value="<?php echo set_value('conf_password'); ?>">
              <?php echo form_error('conf_password'); ?>
            </div>
				  </div>
          <div class="form-group">
            <label for="nama_group" class="col-sm-3 control-label">Pilih Group</label>
            <?php
              $groups = array();
              foreach ($user_group as $ug) {
                array_push($groups, $ug['id_group']);
              }
              $tot = count($group_list); $list = ceil($tot/4);
              if($tot<4) $max = $tot; else $max = 4;
              for($i=0;$i<$max;$i++){
                $a = $list*$i; $b = $list+($list*$i);
                if($b>$tot) $b = $tot;
              ?>
              <div class="col-sm-2">
                <?php
                  for($j=$a;$j<$b;$j++){
                    if(in_array($group_list[$j]->id_group, $groups)) $cek = "checked"; else $cek = "";
                ?>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="nama_group[]" id="nama_group" value="<?php echo $group_list[$j]->id_group; ?>" <?php echo $cek; ?>>
                    <?php echo $group_list[$j]->nama_group; ?>
                  </label>
                </div>
                <?php } ?>
              </div>
            <?php } echo form_error('nama_group[]'); ?>
				  </div>
          <div class="form-group">
				    <label for="status" class="col-sm-3 control-label">Blokir</label>
				    <div class="col-sm-2">
              <?php echo form_dropdown('blokir', blokir(), $data_users->blokir, 'class="select-data" style="width:100%"');?>
				    </div>
				  </div>
          <div class="form-group">
				    <label for="status" class="col-sm-3 control-label">Status</label>
				    <div class="col-sm-2">
              <?php echo form_dropdown('status', status(), $data_users->id_status, 'class="select-data" style="width:100%"');?>
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
  </div>
</div><!-- container -->
<script type='text/javascript'>
  var site = "<?php echo site_url();?>";
  $('.search').select2({
    dropdownAutoWidth: true,
    width: 'element',
    placeholder: 'Masukan NIP atau Nama Pegawai',
    minimumInputLength: 1,
    allowClear: true,
    delay: 200,
    dropdownCssClass: "bigdrop",
    ajax: {
        dataType: "json",
        url: site+'/manajemen/users/search-pegawai',
        data: function (term, page) {
            return {
                keyword: term
            };
        },
        results: function (data) {
            var results = [];
            $.each(data, function(index, item){
                results.push({
                    id: item.nama_user,
                    text: item.nama_user,
                    pegid: item.pegid,
                    nip: item.nip,
                    nama: item.nama,
                    deskripsi: item.deskripsi,
                    jabatan: item.jabatan,
                    avatar: item.avatar
                });
            });
            return { results: results };
        },
        cache: true
    },
    initSelection : function (element, callback) {
        var data = {id: element.val(), text: element.val()};
        callback(data);
    },
    formatNoMatches: function(term){
      return 'Pegawai dengan NIP/Nama "' + term + '" tidak ditemukan';
    },
    formatResult: repoFormatResult, // omitted for brevity, see the source of this page
    formatSelection: repoFormatSelection,  // omitted for brevity, see the source of this page
    escapeMarkup: function (m) { return m; }
  }).on("select2-selecting", function(e) {
        $('#pegawai').val(e.object.pegid);
        $('#nip').val(e.object.nip);
        $('#nama_pegawai').val(e.object.nama);
        $('#jabatan').val(e.object.jabatan);
        $('#username').val(e.object.nip.split(' ').join(''));
    })
    .on("select2-removed", function(e) {
      $('#pegawai').val("");
      $('#nip').val("");
      $('#nama_pegawai').val("");
      $('#jabatan').val("");
      $('#username').val("");
    });

  function repoFormatResult(repo) {
    var markup = '<div class="row">' +
                   '<div class="col-md-1">'+
                      '<img style="margin-top:2px;height:57px;" src="' + repo.avatar + '" alt="foto ' + repo.nama + '"/>'+
                    '</div>' +
                   '<div class="col-md-11" style="padding-left:22px;">' +
                      '<div><strong>' + repo.nama + '</strong><span style="padding-left:5px;">'+ repo.nip +'</span></div>' +
                      '<div>' + repo.deskripsi + '</div>' +
                      '<div>' + repo.jabatan + '</div>' +
                    '</div>'+
                  '</div>';
    return markup;
  }

  function repoFormatSelection(repo) {
    return repo.text;
  }

</script>
