jQuery(document).ready(function(){
	jQuery("input[id*=checkboxall]").click(function() {
		var checked_status = this.checked;
		jQuery("input[id*=checklist]").each(function() {
			this.checked = checked_status;
		});
	});
	
	jQuery("input[id*=checkinvert]").click(function() {
		this.checked = false;
	
		jQuery("input[id*=checklist]").each(function() {
			var status = this.checked;
			
			if (status == true) {
				this.checked = false;
			} else {
				this.checked = true;
			}
		});
	});
});

function slideshow_submitserial(form) {
	jQuery('#slideshow_submitserial_button').prop('disabled', true);
	jQuery('#slideshow_submitserial_loading').show();
	var formdata = jQuery(form).serialize();

	jQuery.post(slideshowajax + '?action=slideshow_serialkey', formdata, function(response) {
		jQuery('#slideshow_submitserial').html(response);
		jQuery.colorbox.resize();
	});
}

function slideshow_deleteserial() {
	jQuery('#slideshow_submitserial_loading').show();
	jQuery('#slideshow_deleteserial_button').prop('disabled', true);

	jQuery.post(slideshowajax + '?action=slideshow_serialkey&delete=1', false, function(response) {
		jQuery.colorbox.close(); parent.location.reload(1);
	});
}

function jqCheckAll(checker, formid, name) {					
	jQuery('input:checkbox[name="' + name + '[]"]').each(function() {
		jQuery(this).attr("checked", checker.checked);
	});
}