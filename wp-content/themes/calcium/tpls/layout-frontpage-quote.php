<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

$text_quote	= get_data('frontpage_text_quote');

?>
<div class="row quotes">
	<div class="large-12 columns">
		<?php echo nl2br(trim($text_quote)); ?>
	</div>
</div>
