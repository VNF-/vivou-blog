<?php
/*
	General Template for Post Archive
*/

/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */
 
global $wp_query, $custom_query_vars;

$custom_query_vars = $wp_query->query_vars;

get_template_part('blog');

