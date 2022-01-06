jQuery(function($)
{
	$.validate(); //validation jquery
	$('.popovers').popover({container: 'body', trigger: 'hover', placement: 'top'}); //bootstrap's popover
	$('.tooltips').tooltip(); //bootstrap's tooltip
	$('.mask').inputmask(); //input mask

	/*----- Select2 -----*/
	$(".select-data").select2({
		minimumResultsForSearch: Infinity,
		allowClear: false,
		width: '100%'
	});

	$(".select-all").select2({
		allowClear: true,
		width: '100%'
	});

	$(".dateperiode").datepicker({
		autoclose: true,
		format: "dd-mm-yyyy",
		todayHighlight: true,
		startView: 'year',
	});

	/*----- BootBox Dialog Simpan -----*/
	$(document).on('submit', '.confirm-save', function(e){
	    var currentForm = this;
	    e.preventDefault();
	    bootbox.dialog({
		  	title:"Konfirmasi",
		  	message: "Benar ingin menyimpan data ini ?",
			buttons: {
			    "cancel" : {
			      	"label" : "<i class='ace-icon fa fa-times'></i> Tidak",
			      	"className" : "btn-danger"
			    },
			    "main" : {
			      	"label" : "<i class='ace-icon fa fa-check'></i> Ya, Simpan",
			      	"className" : "btn-primary",
			      	callback:function(result){
			        	if (result) {
									currentForm.submit();
								}
			    	}
			    }
			}
		});
	});

	/*----- BootBox Dialog Update -----*/
	$(document).on('submit', '.confirm-update', function(e){
	    var currentForm = this;
	    e.preventDefault();
	    bootbox.dialog({
		  	title:"Konfirmasi",
		  	message: "Benar ingin merubah data ini ?",
			buttons: {
			    "cancel" : {
			      	"label" : "<i class='ace-icon fa fa-times'></i> Tidak",
			      	"className" : "btn-danger"
			    },
			    "main" : {
			      	"label" : "<i class='ace-icon fa fa-check'></i> Ya, Simpan",
			      	"className" : "btn-primary",
			      	callback:function(result){
			        	if (result) {
									currentForm.submit();
								}
			    	}
			    }
			}
		});
	});

	/*----- BootBox Dialog Edit -----*/
	$(document).on('click', '.confirm-edit', function(e){
		var href = this.href;
	  if (!$(this).data('response'))
	    e.preventDefault();

	  bootbox.dialog({
		 	title: "Konfirmasi",
		  message: "Benar ingin merubah data ini ?",
			buttons: {
			  "cancel" : {
			    "label" : "<i class='fa fa-times'></i> Tidak",
			    "className" : "btn-danger"
			  },
			  "main" : {
			    "label" : "<i class='fa fa-check'></i> Ya, Lanjutkan",
			    "className" : "btn-primary",
			    callback:function(response){
			      if (response) {
							window.location = href;
						}
			    }
			  }
			}
		});
	});

	$(document).on('click', '.confirm-hapus', function(e){
		var href = this.href;
	  if (!$(this).data('response'))
	    e.preventDefault();

	  bootbox.dialog({
		 	title: "Konfirmasi",
		  message: "Benar ingin menghapus data ini ?",
			buttons: {
			  "cancel" : {
			    "label" : "<i class='fa fa-times'></i> Tidak",
			    "className" : "btn-danger"
			  },
			  "main" : {
			    "label" : "<i class='fa fa-check'></i> Ya, Lanjutkan",
			    "className" : "btn-primary",
			    callback:function(response){
			      if (response) {
							window.location = href;
						}
			    }
			  }
			}
		});
	});

	/*----- BootBox Dialog Delete -----*/
	$(document).on('submit', '.confirm-delete', function(e){
	  var currentForm = this;
	  e.preventDefault();

		bootbox.dialog({
		  title: "Konfirmasi",
		  message: "Benar ingin menghapus data ini ?",
			buttons: {
			  "cancel" : {
			    "label" : "<i class='ace-icon fa fa-times'></i> Tidak",
			    "className" : "btn-danger"
			  },
			  "main" : {
			    "label" : "<i class='ace-icon fa fa-check'></i> Ya, Hapus",
			    "className" : "btn-primary",
			    callback:function(result){
			      if (result) {
							currentForm.submit();
						}
			    }
			  }
			}
		});
	});

	/*----- BootBox Dialog Rules -----*/
	$(document).on('submit', '.confirm-rules', function(e){
	  var currentForm = this;
	  e.preventDefault();

		bootbox.dialog({
		  title: "Konfirmasi",
		  message: "Benar ingin merubah/menghapus rules di module ini ?",
			buttons: {
			  "cancel" : {
			    "label" : "<i class='ace-icon fa fa-times'></i> Tidak",
			    "className" : "btn-danger"
			  },
			  "main" : {
			    "label" : "<i class='ace-icon fa fa-check'></i> Ya, Simpan",
			    "className" : "btn-primary",
			    callback:function(result){
			      if (result) {
							currentForm.submit();
						}
			    }
			  }
			}
		});
	});

	/*----- BootBox Dialog Usulkan -----*/
	$(document).on('click', '.confirm-propose', function(e){
		var href = this.href;
	  if (!$(this).data('response'))
	    e.preventDefault();

	  bootbox.dialog({
		 	title: "Konfirmasi",
		  message: "Benar ingin mengusulkan data ini ?",
			buttons: {
			  "cancel" : {
			    "label" : "<i class='fa fa-times'></i> Tidak",
			    "className" : "btn-danger"
			  },
			  "main" : {
			    "label" : "<i class='fa fa-check'></i> Ya, Lanjutkan",
			    "className" : "btn-primary",
			    callback:function(response){
			      if (response) {
							window.location = href;
						}
			    }
			  }
			}
		});
	});

	/*----- BootBox Dialog Edit -----*/
	$(document).on('click', '.confirm-realisasi', function(e){
		var href = this.href;
	  if (!$(this).data('response'))
	    e.preventDefault();

	  bootbox.dialog({
		 	title: "Konfirmasi",
		  message: "Benar ingin membuat realisasi untuk data ini ?",
			buttons: {
			  "cancel" : {
			    "label" : "<i class='fa fa-times'></i> Tidak",
			    "className" : "btn-danger"
			  },
			  "main" : {
			    "label" : "<i class='fa fa-check'></i> Ya, Lanjutkan",
			    "className" : "btn-primary",
			    callback:function(response){
			      if (response) {
							window.location = href;
						}
			    }
			  }
			}
		});
	});

});
