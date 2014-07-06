<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

add_action('init', 'laborator_init');

# Base Functionality 
function laborator_init()
{
	# Scripts and Styles
		
		# Styles
		wp_register_style('entypo', THEMEASSETS . 'css/entypo/css/fontello.css', null, null);
		
		wp_register_style('foundation', THEMEASSETS . 'css/foundation.css', null, null);
		wp_register_style('foundation-icons', THEMEASSETS . 'css/foundation-icons/foundation-icons.css', null, null);
		wp_register_style('foundation-component', THEMEASSETS . 'css/menu.css', array('foundation', 'foundation-icons'), null);
		wp_register_style('calcium.admin', THEMEASSETS . 'css/admin.css', null, null);
		wp_register_style('calcium', THEMEASSETS . 'css/main.css', null, null);
		wp_register_style('calcium-custom', THEMEASSETS . 'css/custom-skin.css', null, null);
		wp_register_style('calcium-dark', THEMEASSETS . 'css/dark.css', null, null);
		wp_register_style('stylecss', get_stylesheet_uri(), null, null);
		
		
		wp_register_style('magnific-popup', THEMEASSETS . 'js/magnific/magnific-popup.css', null, null);
		
		#wp_register_style('font-primary', 'http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic', null, null);
		#wp_register_style('font-primary', 'http://fonts.googleapis.com/css?family=Playfair+Display:400,700,900,400italic,700italic,900italic', null, null);
	
	
		# Scripts
		wp_register_script('greensock', THEMEASSETS . 'js/gsap/TweenMax.min.js', null, null, true);
		wp_register_script('greensock_easing', THEMEASSETS . 'js/gsap/easing/EasePack.min.js', null, null, true);
		wp_register_script('greensock_jquery', THEMEASSETS . 'js/gsap/jquery.gsap.min.js', null, null, true);
		
		wp_register_script('classie.js', THEMEASSETS . 'js/classie.js', null, null, true);
		wp_register_script('sidebarEffects.js', THEMEASSETS . 'js/sidebarEffects.js', null, null, true);
		wp_register_script('foundation.min.js', THEMEASSETS . 'js/foundation.min.js', null, null, true);
		wp_register_script('joinable', THEMEASSETS . 'js/joinable.js', null, null, true);
		
		wp_register_script('thumbnails-carousel', THEMEASSETS . 'js/jquery.thumbnails-carousel.js', null, null, true);
		
		
		
		wp_register_script('modernizr', THEMEASSETS . 'js/modernizr.custom.js', null, null, true);
		wp_register_script('magnific-popup', THEMEASSETS . 'js/magnific/jquery.magnific-popup.min.js', null, null, true);
		wp_register_script('isotope', THEMEASSETS . 'js/jquery.isotope.min.js', null, null, true);
		wp_register_script('cycle2', THEMEASSETS . 'js/jquery.cycle2.min.js', null, null, true);
		wp_register_script('calcium-portfolio', THEMEASSETS . 'js/portfolio.js', null, null, true);
		wp_register_script('calcium.custom', THEMEASSETS . 'js/custom.js', null, null, true);
		
		
		// Full Screen Fade Filter
		wp_register_style('fso-style-1', THEMEASSETS . 'js/fso/fso-style-1.css', null, null);
		wp_register_script('fso-filter-1', THEMEASSETS . 'js/fso/fso-filter-1.js', null, null, true);
		
		
	# Register Portfolio Content Type 
	$labels = array(
		'name' 					=> __('Portfolio', TD),
		'singular_name' 		=> __('Portfolio Item', TD),
		'add_new' 				=> __('Add Portfolio Item', TD),
		'add_new_item' 			=> __('Add New Item', TD),
		'edit_item' 			=> __('Edit Item', TD),
		'new_item' 				=> __('New Item', TD),
		'all_items' 			=> __('Portoflio Items', TD),
		'view_item' 			=> __('View Item', TD),
		'search_items' 			=> __('Search Portfolio', TD),
		'not_found' 			=> __('No portfolio items found', TD),
		'not_found_in_trash' 	=> __('No portfolio items found in Trash', TD), 
		'parent_item_colon'		=> '',
		'menu_name' 			=> __('Portfolio', TD)
	);
	
	$portfolio_args = array(
		'labels' 				=> $labels,
		'public' 				=> true,
		'publicly_queryable'	=> true,
		'show_ui' 				=> true, 
		'show_in_menu' 			=> true, 
		'query_var' 			=> 'portfolio',
		'rewrite'				=> array( 'slug' => 'portfolio', 'with_front' => false ),
		'capability_type' 		=> 'post',
		'has_archive' 			=> true, 
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		'supports' 				=> array( 'title', 'editor', 'thumbnail', 'page-attributes', 'excerpt' )
	);
	
	register_post_type('portfolio', $portfolio_args);
	
	
	# Register Portfolio Categories
	$labels = array(
		'name' 					=> __( 'Categories', TD),
		'singular_name' 		=> __( 'Category', TD),
		'search_items' 			=> __( 'Search Categories', TD),
		'all_items' 			=> __( 'All Categories', TD),
		'parent_item' 			=> __( 'Parent Category', TD),
		'parent_item_colon' 	=> __( 'Parent Category:', TD),
		'edit_item' 			=> __( 'Edit Category', TD), 
		'update_item' 			=> __( 'Update Category', TD),
		'add_new_item' 			=> __( 'Add New Category', TD),
		'new_item_name' 		=> __( 'New Category Name', TD),
		'menu_name' 			=> __( 'Categories', TD),
	); 	
	
	register_taxonomy('portfolio-category', array('portfolio'), array(
		'hierarchical'        => true,
		'labels'              => $labels,
		'show_ui'             => true,
		'query_var'           => true,
		'rewrite'             => array( 'slug' => 'portfolio-category' ),
		'show_admin_column'   => true,
		'public'              => true,
		'show_in_nav_menus'   => true
	));
}