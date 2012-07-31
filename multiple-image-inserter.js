;(function ($, window, document, undefined) {

	$(document).ready(function($){
		
		// Bind current elements and add checkbox
	    $('#media-items .new').each(function(e){
			var id = $(this).parent().attr('id').split('-')[2];
			$(this).prepend('<input type="checkbox" class="item_selection" title="Select items you want to insert" id="attachments[' + id.substring() + '][selected]" name="attachments[' + id + '][selected]" value="selected" /> ');
	    });
	    
	    // Bind future elements and add checkbox
	    $('.ml-submit').live('mouseenter',function(e){
	      	$('#media-items .new').each(function(e) {
	        	var id = $(this).parent().children('input[value="image"]').attr('id').split('-')[2];
	        	$(this).not(":has('input')").prepend('<input type="checkbox" class="item_selection" title="Select items you want to insert" id="attachments[' + id.substring() + '][selected]" name="attachments[' + id + '][selected]" value="selected" /> ');
	      	});
	    });
	    
	    //buttons for enhanced functions
		$('.ml-submit:first').append(
			$('<div>').attr('id', 'mii-button-container').append(
				$('<h4>').text('Insert multiple images')
			).append(
				$('<div>').append(
				    '<input type="submit" class="button savebutton" name="insertall" id="insertall" value="Insert selected images" /> '
				).append(
					'<input type="submit" class="button savebutton" name="invertall" id="invertall" value="Invert selection" /> '
				)
			)
		);
		$('.ml-submit #invertall').click(function(){
			$('#media-items .item_selection').each(function(e){
				if ($(this).is(':checked')) $(this).prop('checked', false);
				else $(this).attr('checked', true);
	        });
	        return false;
		});

	});

}(jQuery, window, document));