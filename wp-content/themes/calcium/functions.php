<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */
 

# Constants
define('THEMEDIR', 		get_template_directory() . '/');
define('THEMEURL', 		get_template_directory_uri() . '/');
define('THEMEASSETS',	THEMEURL . 'assets/');
define('WPURL', 		site_url('/'));
define('URL', 			home_url('/'));
define('TD', 			'calcium');
define('DEV_MODE',		0);


# Theme Content Width
$content_width = ! isset($content_width) ? 960 : $content_width;


# Theme Textdomain
load_theme_textdomain(TD, get_template_directory() . '/languages');


# Register Menus
register_nav_menus(
	array(
		'main-menu' => 'Main Menu'
	)
);


# Theme Support
add_theme_support('menus');
add_theme_support('widgets');
add_theme_support('automatic-feed-links');
add_theme_support('post-thumbnails');
add_theme_support('featured-image');
add_theme_support('post-formats', array('video', 'quote', 'image', 'link', 'gallery', 'audio'));


# Load Files
include(THEMEDIR . 'inc/lib/smof/smof.php');

# Laborator - WP Related
include(THEMEDIR . 'inc/laborator_functions.php');
include(THEMEDIR . 'inc/laborator_init.php');
include(THEMEDIR . 'inc/laborator_actions.php');
include(THEMEDIR . 'inc/laborator_filters.php');
include(THEMEDIR . 'inc/laborator_classes.php');
include(THEMEDIR . 'inc/laborator_shortcodes.php');


if(class_exists('acf'))
{
	# Make it LITE
	if(! get_data('acf_lite_disable'))
		define('ACF_LITE', true);
}
else
if( ! is_admin())
{
	# Load get_field function
	include(THEMEDIR . 'inc/lib/acf-functions.php' );
}


include(THEMEDIR . 'inc/acf-fields.php' );

include(THEMEDIR . 'inc/lib/zebra.php');
include(THEMEDIR . 'inc/lib/class-tgm-plugin-activation.php');
include(THEMEDIR . 'inc/lib/laborator/laborator_image_resizer.php');
include(THEMEDIR . 'inc/lib/laborator/laborator_dataopt.php');
include(THEMEDIR . 'inc/lib/laborator/laborator_tgs.php');
include(THEMEDIR . 'inc/lib/laborator/laborator_gallerybox.php');

if(get_data('portfolio_likes'))
	include(THEMEDIR . 'inc/lib/laborator/laborator_likes.php');
	
include(THEMEDIR . 'inc/laborator_data_blocks.php');

include(THEMEDIR . 'inc/lib/widgets/laborator_twitter.php');
include(THEMEDIR . 'inc/lib/widgets/laborator_instagram.php');
include(THEMEDIR . 'inc/lib/widgets/laborator_subscribe.php');

# Laborator SEO
if( ! defined("WPSEO_PATH"))
	include('inc/lib/laborator/laborator_seo.php');


# Thumbnail Sizes
$blog_thumbnail_height = ($bth = get_data('blog_thumbnail_height')) && is_numeric($bth) && $bth > 100 ? $bth : 220;

laborator_img_add_size('blog-thumb-1', 790, $blog_thumbnail_height, 4);
laborator_img_add_size('blog-thumb-2', 790, 0, 3);

laborator_img_add_size('search-thumb', 70, 70, 1);

laborator_img_add_size('gallery-thumb-1', 80, 80, 1);

laborator_img_add_size('portfolio-thumb-2', 500, 0, 0);
laborator_img_add_size('portfolio-thumb-3', 940, 0, 0);

laborator_img_add_size('portfolio-thumb-1', 405, 285, 4);
laborator_img_add_size('portfolio-thumb-2-cols', 712, 501, 4);
laborator_img_add_size('portfolio-thumb-3-cols', 475, 334, 4);



# Gallery Boxes
new GalleryBox('portfolio_images', array('title' => 'Item Images', 'post_types' => array('portfolio')));

# Like Support
if(function_exists('laborator_add_like_support'))
	laborator_add_like_support('portfolio');


# Main Sidebar Widget
$main_sidebar = array(
	'id' => 'main_sidebar',
	'name' => 'Main Sidebar',
	
	'before_widget' => '<div class="menu-widget %2$s %1$s">',
	'after_widget' => '</div>',
	
	'before_title' => '<h2>',
	'after_title' => '</h2>'
);

register_sidebar($main_sidebar);