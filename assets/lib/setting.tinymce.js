tinymce.init({
	selector: "textarea#mceditor",
	theme: "modern",
	height: 300,
	plugins: [
		"advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker toc",
		"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
		"save table contextmenu directionality emoticons template paste textcolor importcss colorpicker textpattern codesample"
	],
	external_plugins: {
		//"moxiemanager": "/moxiemanager-php/plugin.js"
	},
	content_css: "css/development.css",
	add_unload_trigger: false,
	autosave_ask_before_unload: false,

	toolbar1: "newdocument | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
	toolbar2: "cut copy paste pastetext | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media help code | insertdatetime preview | forecolor backcolor",
	toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft | insertfile insertimage codesample",
	toolbar_items_size: 'small',
	image_advtab: true,
	image_caption: true,

	style_formats: [
		{title: 'Bold text', format: 'h1'},
		{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
		{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
		{title: 'Example 1', inline: 'span', classes: 'example1'},
		{title: 'Example 2', inline: 'span', classes: 'example2'},
		{title: 'Table styles'},
		{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'},
	],

	template_replace_values : {
		username : "Jack Black"
	},

	template_preview_replace_values : {
		username : "Preview user name"
	},

	link_class_list: [
		{title: 'Example 1', value: 'example1'},
		{title: 'Example 2', value: 'example2'}
	],

	image_class_list: [
		{title: 'Example 1', value: 'example1'},
		{title: 'Example 2', value: 'example2'}
	],

	templates: [
		{title: 'Some title 1', description: 'Some desc 1', content: '<strong class="red">My content: {$username}</strong>'},
		{title: 'Some title 2', description: 'Some desc 2', url: 'development.html'}
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

	spellchecker_callback: function(method, data, success) {
		if (method == "spellcheck") {
			var words = data.match(this.getWordCharPattern());
			var suggestions = {};

			for (var i = 0; i < words.length; i++) {
				suggestions[words[i]] = ["First", "second"];
			}

			success({words: suggestions, dictionary: true});
		}

		if (method == "addToDictionary") {
			success();
		}
	}
});
