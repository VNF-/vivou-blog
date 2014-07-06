<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

the_post();

get_header();

?>
<section class="page">
	
	<div class="row">
		
		<?php the_content(); ?>
		
	</div>
	
</section>
<?php

get_footer();