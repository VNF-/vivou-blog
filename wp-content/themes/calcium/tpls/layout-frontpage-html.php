<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

$html_content = get_data('frontpage_custom_html');


?>
<section class="html-content-block">

	<div class="row">
		<?php echo do_shortcode($html_content); ?>
	</div>
	
</section>