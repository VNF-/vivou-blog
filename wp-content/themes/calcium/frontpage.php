<?php
/*
	Template Name: Frontpage
*/

/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

get_header();

if(is_tax('portfolio-category'))
	get_template_part('portfolio');
else
	get_template_part('tpls/frontpage-main');

get_footer();