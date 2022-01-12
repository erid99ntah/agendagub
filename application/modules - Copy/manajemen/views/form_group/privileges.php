<div class="container">
  <?php echo $this->session->flashdata('message'); ?>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h4>Setting Group Privilege</h4>
        </div>
        <div class="panel-footer" style="padding:1px 0;"></div>
        <div class="panel-body collapse in">
        <?php echo form_open(site_url($urlform)); ?>
          <input type="hidden" name="group" value="<?php echo $group; ?>">
          <div class="clearfix">
						<div class="pull-left form-group clearfix">
              <a href="<?php echo site_url('manajemen/group'); ?>" class="btn-default btn" type="submit"> Batal </a>
              <input class="btn-primary btn" type="submit" name="save" id="save" value="Simpan Privilege">
            </div>
					</div>
          <p>Silahkan pilih privilege untuk Group <strong><?php echo $nama_group; ?></strong></p>
          <div class="form-group">
            <label class="checkbox-inline">
              <input type="checkbox" id="checkall" onchange="selectAll('checkall');"> <strong>Check All Global Privileges</strong>
            </label>
          </div>
          <?php foreach ($data_rules as $list_module => $module): echo $m_class = "m_".str_replace(' ', '', strtolower($list_module));?>
          <div class="form-group well">
            <div class="row">
              <div class="col-md-12">
                <h4 style="margin:-10px 0px;">
                  <input type="checkbox" class="checkall" id="<?php echo $m_class; ?>" onchange="selectAll('<?php echo $m_class; ?>');"> <strong> Module <?php echo $list_module; ?></strong>
                </h4>
              </div>
            </div>
            <div class="row">
            <?php $i=0; foreach ($module as $list_kontrol => $kontrol): echo $k_class = "k_".str_replace(' ', '', strtolower($list_kontrol));?>
              <div class="col-xs-6 col-sm-4 col-md-2">
                <h4 style="margin-bottom:-5px;">
                  <input type="checkbox" class="checkall <?php echo $m_class; ?>" id="<?php echo $k_class; ?>" onchange="selectAll('<?php echo $k_class; ?>');"> <strong><?php echo $list_kontrol; ?></strong>
                </h4>
                <?php foreach ($kontrol as $fungsi => $row): ?>
                <div class="checkbox">
                  <input type="checkbox" class="checkall <?php echo $m_class.' '.$k_class; ?>" name="prvlg[]" value="<?php echo $row['id_rules']; ?>" <?php echo $row['checked'] ?>> <?php echo $row['title_fungsi']; ?>
                </div>
                <?php endforeach; ?>
              </div>
            <?php $i++; if($i==6){echo '</div><div class="row">';} endforeach; ?>
            </div>
          </div>
          <?php endforeach; ?>
        <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div><!-- container -->
<script type="text/javascript">
  checkedParent();

  function checkedParent()
  {
    $.each($('input[name="prvlg[]"]:checked'), function(){
      var classNames = $(this).attr('class').split(' ');
      for (index = classNames.length - 1; index >= 0; --index) {
        var lenAll = $('.' + classNames[index]).length;
        //hitung semua chekbox yang di ckelist
        var lenIsChecked = $('.' + classNames[index] + ':checked').length;
        //jika hasilnya sama maka lakukan checklis
        $.each($('#' + classNames[index]), function () {
          if (lenAll === lenIsChecked)
            this.checked = true;
          else
            this.checked = false;
        });
      }
    });
  }

  function selectAll(c)
  {
    if($("#"+c).is(":checked")){
      $.each($("."+c),function(){this.checked=true})
    }else{
      $.each($("."+c),function(){this.checked=false})
    }
  }

  $(document).on('change', 'input[type=checkbox]', function () {
    var classNames = $(this).attr('class').split(' ');
    for (index = classNames.length - 1; index >= 0; --index) {
      var lenAll = $('.' + classNames[index]).length;
      //hitung semua chekbox yang di ckelist
      var lenIsChecked = $('.' + classNames[index] + ':checked').length;
      //jika hasilnya sama maka lakukan checklis
      $.each($('#' + classNames[index]), function () {
        if (lenAll === lenIsChecked)
          this.checked = true;
        else
          this.checked = false;
      });
    }
  });
</script>
