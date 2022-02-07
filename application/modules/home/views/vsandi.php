<div class="container">
  <?php echo $this->session->flashdata('message'); ?>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-primary">
        <div class="panel-heading">
		      <h4>Form Ganti Sandi</h4>
		    </div>
        <div class="panel-footer" style="padding:1px 0;"></div>
        <?php echo form_open(site_url('home/sandi'), array('class' => 'form-horizontal row-border', 'role' => 'form')); ?>
        <div class="panel-body">
         
          <div class="form-group required">
				    <label for="password" class="col-sm-3 control-label"> Password Lama</label>
				    <div class="col-sm-6">
				      <div class="input-group">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password Lama" value="<?php echo $this->input->post('password', TRUE); ?>">
                <div class="input-group-addon showPass"><i class="fa fa-eye"></i></div>
              </div>
              <?php echo form_error('password'); ?>
            </div>
				  </div>
          <div class="form-group required">
				    <label for="password_baru" class="col-sm-3 control-label"> Password Baru</label>
				    <div class="col-sm-6">
				      <div class="input-group">
                <input type="password" class="form-control" name="password_baru" id="password_baru" placeholder="Password Baru" value="<?php echo $this->input->post('password_baru', TRUE); ?>">
                <div class="input-group-addon showPass"><i class="fa fa-eye"></i></div>
              </div>
              <div class="help-block"></div>
              <?php echo form_error('password_baru'); ?>
            </div>
				  </div>

          <div class="form-group required">
            <label for="conf_password" class="col-sm-3 control-label"> Konfirmasi Password Baru</label>
            <div class="col-sm-6">
               <div class="input-group">
                <input type="password" class="form-control" name="conf_password" id="conf_password" placeholder="Konfirmasi Password Baru" value="<?php echo $this->input->post('conf_password', TRUE); ?>">
                <div class="input-group-addon showPass"><i class="fa fa-eye"></i></div>
              </div>
              <div class="help-block"></div>
              <?php echo form_error('conf_password'); ?>
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

  var defaults = { minimumChars: 8 };
  var progressHtml = "<div class='contextual-progress' style='margin-top:5px;margin-bottom:0px;'>"+
                        "<div class='clearfix'>"+
                          "<div class='progress-title'></div>"+
                        "</div>"+
                        "<div class='progress'>"+
                          "<div id='password-progress' class='progress-bar' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' style='width:0%;'></div>"+
                        "</div>"+
                      "</div>";
                      // $('input[type=password]:first').closest('div.input-group').after(progressHtml);
  $(progressHtml).insertAfter($('input[type=password_baru]:first').closest('div.input-group'));
  $('.progress-title').text('');
  $('.contextual-progress').hide();

  $('#password_baru').keyup(function (event) {
    $('.contextual-progress').show();
    var element = $(event.target);
    var password = element.val();
    console.log(password);
    if (password.length == 0) {
      $('.progress-title').html('');
      $('.contextual-progress').hide();
    } else {
      var score = calculatePasswordScore(password, defaults);
      $('.progress-bar').css('width', score + '%').attr('aria-valuenow', score);
      if(score == 0) {
        $('.progress-title').html('Too short')
      } else if (score < 50) {
        $('.progress-title').html('Weak password');
        $('#password-progress').removeClass();
        $('#password-progress').addClass('progress-bar progress-bar-danger');
      } else if (score >= 50 && score <= 60) {
        $('.progress-title').html('Normal password');
        $('#password-progress').removeClass();
        $('#password-progress').addClass('progress-bar progress-bar-warning');
      } else if (score > 60 && score <= 80) {
        $('.progress-title').html('Good password');
        $('#password-progress').removeClass();
        $('#password-progress').addClass('progress-bar progress-bar-success');
      } else if(score > 80) {
        $('.progress-title').html('Strong password');
        $('#password-progress').removeClass();
        $('#password-progress').addClass('progress-bar progress-bar-primary');
      }
    }
  });

  $('#conf_password').keyup(function (event) {
    $('.progress-title').html('');
    $('.contextual-progress').hide();
    let password = $('#password_baru').val();
    let confirm  = $(this).val();
    if(password !==  confirm && confirm.length > 0)
      $(this).closest('div.required').addClass('has-error').find('div.help-block').text('Password tidak cocok!');
    else
      $(this).closest('div.required').removeClass('has-error').find('div.help-block').text('');
  });

  $(document).on('click', '.showPass', function(e){
    let div = $(this).closest('div.input-group');
    let id  = div.find('input').attr('id');
    if($(this).hasClass('open')) {
      div.find('#'+id).attr('type', 'password');
      $(this).removeClass('open').addClass('closed').html('<i class="fa fa-eye"></i>');
    } else {
      div.find('#'+id).attr('type', 'text');
      $(this).removeClass('closed').addClass('open').html('<i class="fa fa-eye-slash"></i>');
    }
  });

  
  function calculatePasswordScore(password, options) {
    var score = 0;
    var hasNumericChars = false;
    var hasSpecialChars = false;
    var hasMixedCase = false;
    if (password.length < 1)
      return score;
    if (password.length < options.minimumChars)
      return score;
    //match numbers
    if (/\d+/.test(password)) {
      hasNumericChars = true;
      score += 20;
      var count = (password.match(/\d+?/g)).length;
      if (count > 1) {
        //apply extra score if more than 1 numeric character
        score += 10;
      }
    }
    //match special characters including spaces
    if (/[\W]+/.test(password)) {
      hasSpecialChars = true;
      score += 20;
      var count = (password.match(/[\W]+?/g)).length;
      if (count > 1) {
        //apply extra score if more than 1 special character
        score += 10;
      }
    }
    //mixed case
    if ((/[a-z]/.test(password)) && (/[A-Z]/.test(password))) {
      hasMixedCase = true;
      score += 20;
    }
    if (password.length >= options.minimumChars && password.length < 12) {
      score += 10;
    } else if (!hasMixedCase && password.length >= 12) {
      score += 10;
    }
    if ((password.length >= 12 && password.length <= 15) && (hasMixedCase && (hasSpecialChars || hasNumericChars))) {
      score += 20;
    } else if (password.length >= 12 && password.length <= 15) {
      score += 10;
    }
    if ((password.length > 15 && password.length <= 20) && (hasMixedCase && (hasSpecialChars || hasNumericChars))) {
      score += 30;
    } else if (password.length > 15 && password.length <= 20) {
      score += 10;
    }
    if ((password.length > 20) && (hasMixedCase && (hasSpecialChars || hasNumericChars))) {
      score += 40;
    } else if (password.length > 20) {
      score += 20;
    }
    if (score > 100)
      score = 100;
    return score;
  }
</script>