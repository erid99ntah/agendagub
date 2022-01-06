tinymce.init({
	selector: "textarea",
	height: 300,
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
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css',
		'css/content.css'
  ],
	setup: function(ed) {
		ed.on('change keyup', function(e){
			tinymce.triggerSave();
			$('textarea#mceditor').text(ed.getContent());
		});
		/*ed.on(
			'Init PreInit PostRender PreProcess PostProcess BeforeExecCommand ExecCommand Activate Deactivate ' +
			'NodeChange SetAttrib Load Save BeforeSetContent SetContent BeforeGetContent GetContent Remove Show Hide' +
			'Change Undo Redo AddUndo BeforeAddUndo', function(e) {
			console.log(e.type, e);
		});*/
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

tinymce.init({
	selector: "textarea#mceditor1",
	height: 500,
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
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css',
		'css/content.css'
  ],
	setup: function(ed) {
		ed.on('change keyup', function(e){
			tinymce.triggerSave();
			$('textarea#mceditor1').text(ed.getContent());
		});
		/*ed.on(
			'Init PreInit PostRender PreProcess PostProcess BeforeExecCommand ExecCommand Activate Deactivate ' +
			'NodeChange SetAttrib Load Save BeforeSetContent SetContent BeforeGetContent GetContent Remove Show Hide' +
			'Change Undo Redo AddUndo BeforeAddUndo', function(e) {
			console.log(e.type, e);
		});*/
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
