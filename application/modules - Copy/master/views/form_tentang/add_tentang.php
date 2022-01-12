<div class="container">
  <?php echo $this->session->flashdata('message'); ?>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-green">
        <div class="panel-heading">
		      <h4>Form Input Tentang</h4>
		    </div>
        <div class="panel-footer" style="padding:1px 0;"></div>
        <?php echo form_open_multipart(site_url($urlform), array('class' => 'form-horizontal row-border', 'role' => 'form')); ?>
        <div class="panel-body">

         
          <div class="form-group">
            <label for="judul" class="col-sm-3 control-label">Judul</label>
            <div class="col-sm-6">
              <input type="text" class="form-control tooltips" name="judul" id="judul" placeholder="Judul" value="<?php echo set_value('judul'); ?>" data-trigger="hover" data-original-title="Judul Berita yang akan digunakan">
              <?php echo form_error('judul'); ?>
            </div>
          </div>

          <div class="form-group">
            <label for="keterangan" class="col-sm-3 control-label">Keterangan</label>
            <div class="col-sm-6">
              <input type="text" class="form-control tooltips" name="keterangan" id="keterangan" placeholder="keterangan"  value="<?php echo set_value('keterangan'); ?>" data-trigger="hover" data-original-title="keterangan yang akan digunakan">
              <?php echo form_error('keterangan'); ?>
            </div>
          </div>

          <div class="form-group">
            <label for="isi" class="col-sm-3 control-label"> Isi</label>
            <div class="col-sm-6">
              <textarea name="isi" placeholder="isi" cols="55" rows="5" id="isi">
                
              </textarea>
              <?php echo form_error('isi'); ?>
            </div>
          </div>
               
          <div class="form-group">
				    <label for="img" class="col-sm-3 control-label">File</label>
				    <div class="col-sm-4">
				      <input type="file" class="form-control" name="img" id="img" placeholder="File Gambar">
            </div>
				  </div>
         
          <div class="form-group">
				    <label for="status" class="col-sm-3 control-label">Status</label>
				    <div class="col-sm-2">
              <?php echo form_dropdown('status', status(), $this->input->post('status'), 'class="select-data"');?>
              <?php echo form_error('status'); ?>
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
  tinymce.init({
  selector: "textarea#isi",
  height: 400,
  plugins: [
    'advlist anchor autolink charmap code codesample colorpicker contextmenu directionality emoticons fullscreen',
    'hr image importcss insertdatetime link lists media nonbreaking pagebreak paste preview print',
    'save searchreplace spellchecker tabfocus table template textcolor textpattern toc visualblocks visualchars wordcount'
  ],
  toolbar1: 'insertfile undo redo | cut copy paste pastetext | formatselect | fontselect fontsizeselect | blockquote visualblocks',
  toolbar2: 'bold italic strikethrough forecolor backcolor | numlist bullist | outdent indent | alignleft aligncenter alignright alignjustify | link unlink anchor image media code',
  toolbar3: 'table insertdatetime | hr removeformat | subscript superscript | charmap emoticons | ltr rtl | nonbreaking template pagebreak',
  nonbreaking_force_tab: true,
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],
  content_css: [
    
  ],
  setup: function(ed) {
    ed.on('change keyup', function(e){
      tinymce.triggerSave();
      $('textarea#mceditor').text(ed.getContent());
    });    
  },

  spellchecker_callback: function(method, data, success, failure) {
    var words = data.match(this.getWordCharPattern());
    if (method == "spellcheck") {
      var suggestions = {};
      for (var i = 0; i < words.length; i++) {
        suggestions[words[i]] = ["First", "second"];
      }
      success({words: suggestions, dictionary: true});
    } else if (method == "addToDictionary") {
      success();
    }
  }
});
</script>