<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */
 
?>
<div class="blog single">

	<?php get_template_part('tpls/blog-post'); ?>
	

	<?php if( ! is_attachment() && get_data('blog_author_info')) get_template_part('tpls/blog-post-author'); ?>

	
	<?php comments_template(); ?>
	
</div>
