<?php
/**
 * @package Multiple Image Inserter
 * @version 1.0
 */
/*
Plugin Name: Multiple Image Inserter
Description: Makes it possible to insert multiple images at the same time from the Media Library
Version: 1.0
Author: Christian Wannerstedt @ Kloon Production AB
License: GPL2

Inspired by the Faster Image Insert plugin:
http://wordpress.org/extend/plugins/faster-image-insert/
*/


class MultipleImageInserter {
    public function __construct(){
		add_action('admin_head', array($this, 'mii_admin_head'));
		add_filter('media_upload_gallery', array($this, 'mii_media_upload'));
		add_filter('media_upload_library', array($this, 'mii_media_upload'));
		add_filter('media_upload_image', array($this, 'mii_media_upload'));
    }

	function mii_admin_head(){
		// Add js 
		wp_enqueue_script('multiple-image-inserter', plugins_url('multiple-image-inserter.js', __FILE__));

		// Add css
		wp_enqueue_style('multiple-image-inserter', plugins_url('multiple-image-inserter.css', __FILE__));
	}

	// Filter for media upload popup.
	function mii_media_upload(){
		if (isset($_POST['insertall'])){
	    	$return = $this->mii_form_handler();
	    	if (is_string($return)) echo $return;
	  	}
	}

	// Catches the insert selected images post request.
	function mii_form_handler() {
		global $post_ID, $temp_ID;
	  	$post_id = (int) (0 == $post_ID ? $temp_ID : $post_ID);
	  	check_admin_referer('media-form');

	  	// Modify the insertion string
		if (!empty($_POST['attachments'])){
	    	$result = '';

			// Loop through attachments, and find selected ones
	    	foreach ($_POST['attachments'] as $attachment_id => $attachment){
	      		$attachment = stripslashes_deep($attachment);

	      		if (!empty($attachment['selected'])){
					$html = ' '. wp_get_attachment_image($attachment_id, 'main-image-size');
					$result .= $html .'\\n';
				}
	    	}
			
			// Wrap result in a div
			$result = '<div class="image-list">\\n'. $result .'</div>\\n';
			
			// Pass content to editor
	    	$result = '
			<script type="text/javascript">
			var win = window.dialogArguments || opener || parent || top;
			win.send_to_editor("'. str_replace('\\\n', '\\n', addslashes($result)) .'");
			</script>
		  	';
		  	return $result;
	  	}
	  	return "";
	}
}

$multiple_image_inserter = new MultipleImageInserter();

?>