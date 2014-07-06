<?php
/*
	Template Name: Contact
*/

/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */


get_header();


# Page Layout
$default_page_layout = array (
	array ('acf_fc_layout' => 'address-line'),
	array ('acf_fc_layout' => 'address-map'),
	array ('acf_fc_layout' => 'contact-form'),
	array ('acf_fc_layout' => 'client-logos'),
);

$page_layout = get_field('page_layout');

if( ! is_array($page_layout) || ! count($page_layout))
	$page_layout = $default_page_layout;
	

# Render Page Layout
foreach($page_layout as $pl)
{
	$page_layout_id = $pl['acf_fc_layout'];
	$page_layout_id = str_replace('_', '-', $page_layout_id);
	
	get_template_part("tpls/layout-{$page_layout_id}");
}


get_footer();