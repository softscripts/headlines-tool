var oTable;
jQuery(document).ready(function($){

var _custom_media = true,
      _orig_send_attachment = wp.media.editor.send.attachment;

  jQuery('.meta_upload').click(function(e) {
    var send_attachment_bkp = wp.media.editor.send.attachment;
    var button = $(this);
    var id = button.attr('id').replace('button_', '');
    _custom_media = true;
    wp.media.editor.send.attachment = function(props, attachment){
      if ( _custom_media ) {
        $("#"+id).val(attachment.url).select();
      } else {
        return _orig_send_attachment.apply( this, [props, attachment] );
      };
    }

    wp.media.editor.open(button);
    return false;
  });



	jQuery('.data-form').submit(function(){
		var stat = 1;
		var id =	jQuery(this).attr('id');
		jQuery('.data-required').each(function() {
			var val = jQuery(this).val();
			if(val == '') {
				jQuery(this).addClass('ht-not-valid');
				stat = 0;
			}
			else {
				jQuery(this).removeClass('ht-not-valid');
			}
		});

			if(id == 'entry_action') {
					if(jQuery('#category').val() == "" && jQuery('#category_new').val() == ""){
						jQuery('#category').addClass('ht-not-valid');
						stat = 0;
					}
					else {
						jQuery('#category').removeClass('ht-not-valid');
					}
			}		

		if(stat == 1) {
			return true;
		}
		else {
			return false;
		}

	});


	jQuery('.data-required').keyup(function(){
		var val = jQuery(this).val();
			if(val == '') {
			jQuery(this).addClass('ht-not-valid');
		}
		else {
			jQuery(this).removeClass('ht-not-valid');
		}
	});

	jQuery('[data-dismiss="alert"]').click(function(){
		jQuery(this).parent().remove();
	});

	jQuery('.ht_container .alert').delay(3000).slideUp();

	
	if($('#ht_dyntable').length > 0) {

		  oTable = $('#ht_dyntable').dataTable();

	}

	jQuery("#entry_date").datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true			
	});

	jQuery('.ht_delete').click(function() {
		var con = confirm('Confirm delete?');
		if(con){
			return true;
		}
		else {
			return false;
		}
		
	});

	jQuery('.add-new-category').click(function(){
		jQuery('.new-category').slideDown();
		jQuery('#category_new').focus();
		jQuery(this).hide();
		return false;
	});

	jQuery('#shortcodes_form_default').submit(function(){
		var cat_id = jQuery('#shortcode_category').val();
		var shortcode = '[headlines-tool]';
		if(cat_id != "") {
			shortcode = '[headlines-tool cat='+cat_id+']';
		}
		jQuery('#ht_shortcode').val(shortcode).select().focus();
		return false;
	});

	jQuery('#shortcodes_form_widget').submit(function(){
		var shortcode = '[headlines-tool-widget';
		var sc_limit	= '';
		var sc_link		= ']';
		var shortcode_limit = jQuery('#shortcode_widget_limit').val();
		var shortcode_link	= jQuery('#shortcode_widget_link').val();

		if(shortcode_limit != "") {
			sc_limit = ' limit='+shortcode_limit;
		}

		if(shortcode_link != "") {
			sc_link = ' link='+shortcode_link+']';
		}
		shortcode = shortcode+sc_limit+sc_link;

		jQuery('#ht_shortcode_widget').val(shortcode).select().focus();
		return false;
	});

	jQuery('#ht_shortcode, #ht_shortcode_widget').click(function(){
		jQuery(this).select();
	});

});
