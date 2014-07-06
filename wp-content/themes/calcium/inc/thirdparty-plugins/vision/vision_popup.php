<?php

// loads the shortcodes class, wordpress is loaded with it
require_once( 'shortcodes.class.php' );

//prevent direct access to file, only log in user can access.
if(!is_user_logged_in()){
wp_die("Can't load this file directly");
}

// get popup type
$popup = trim( $_GET['popup'] );
$shortcode = new vision_shortcodes( $popup );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<div id="vision-popup">

	<div id="vision-shortcode-wrap"<?php if( $shortcode->no_preview ) : ?> class="vision-shortcode-nopreview-wrap"<?php endif; ?>>
		
		<div id="vision-sc-form-wrap">
		
			<form method="post" id="vision-sc-form">
			
				<table id="vision-sc-form-table">
				
					<?php echo $shortcode->output; ?>
					
					<tbody>
						<tr class="form-row">
							<?php if( ! $shortcode->has_child ) : ?><td class="label">&nbsp;</td><?php endif; ?>
							<td class="field"><a href="#" class="vision-insert button button-primary button-large">Insert Shortcode</a></td>							
						</tr>
					</tbody>
				
				</table>
				<!-- /#vision-sc-form-table -->
				
			</form>
			<!-- /#vision-sc-form -->
		
		</div>
		<!-- /#vision-sc-form-wrap -->
		
		<div id="vision-sc-preview-wrap">
		
			<!-- <div id="vision-sc-preview-head">Shortcode Preview</div> -->
			
			<?php if( $shortcode->no_preview ) : ?>
			<div id="vision-sc-nopreview">This shortcode has no preview</div>		
			<?php else : ?>			
			<iframe src="<?php echo VISION_TINYMCE_URI; ?>/vision_preview.php?sc=" width="249" frameborder="0" id="vision-sc-preview"></iframe>
			<?php endif; ?>
			
		</div>
		<!-- /#vision-sc-preview-wrap -->
		
		<div class="clear"></div>
		
	</div>
	<!-- /#vision-shortcode-wrap -->

</div>
<!-- /#vision-popup -->

</body>
</html>