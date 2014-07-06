<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

get_header();

if(is_front_page() && get_data('use_frontpage'))
{
	get_template_part('tpls/frontpage-main');
}
else
{
	# Show posts from the blog 
	global $wp_query, $custom_query_vars;
	
	$custom_query_vars = $wp_query->query_vars;
	
	get_template_part('blog');
}

get_footer();