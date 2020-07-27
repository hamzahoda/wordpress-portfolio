jQuery(window).load(function(){
	
	jQuery(document).on("change", ".sc_select", function(){
		var val =jQuery(this).val();
				send_to_editor(val);
				return false;
	});
	
});