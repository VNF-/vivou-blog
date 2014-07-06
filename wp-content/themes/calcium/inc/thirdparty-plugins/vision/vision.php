<?php
/*
Plugin Name: Vision
Plugin URI: http://truethemes.net
Description: Bring your website to life with this powerful Shortcodes Manager. Add beautiful elements such as Buttons, Tabs, Accordions, and much more. Once installed, a new button will be added directly to the default Wordpress WYSIWYG Content Editor.
Author: TrueThemes
Version: 3.0.2
Author URI: http://truethemes.net
*/

/*----------------------------*/
/*	Load Localization
/*----------------------------*/
load_plugin_textdomain( 'vision', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );


/*----------------------------*/
/*	Define File Paths
/*----------------------------*/
define('VISION_TINYMCE_URI', WP_PLUGIN_URL . '/vision');
define('VISION_TINYMCE_PATH', WP_PLUGIN_DIR . '/vision');


/*----------------------------*/
/*	Load TinyMCE dialog
/*----------------------------*/
require_once( VISION_TINYMCE_PATH . '/tinymce.class.php' ); // TinyMCE wrapper class
new vision_tinymce();


/*----------------------------*/
/*	Load Shortcodes
/*----------------------------*/
require_once( VISION_TINYMCE_PATH . '/vision-old-shortcodes.php' );	// old vision shortcodes (before 2.0) keep file for backward compatible.
require_once( VISION_TINYMCE_PATH . '/vision-shortcodes.php' );	// new vision shortcodes, only renamed, functions and usage remains the same.


/*----------------------------*/
/*	Setup and Load Scripts
/*----------------------------*/
function vision_enqueue_script(){
	
//register scripts
wp_register_script( 'vision-shortcodes', VISION_TINYMCE_URI . '/js/vision-shortcodes.js',array('jquery'), '3.0', $infooter = true );
wp_register_script( 'truethemes-lightbox', VISION_TINYMCE_URI . '/js/jquery.prettyPhoto.js',array('jquery'), '3.1.3', $infooter = true );
wp_register_style( 'vision-shortcodes', VISION_TINYMCE_URI . '/vision-shortcodes.css');
wp_register_style( 'vision-social', VISION_TINYMCE_URI . '/webfonts/ss-social.css');

//load scripts
	if(!is_admin()){
		wp_enqueue_script( 'truethemes-lightbox'); // This scriptmust be first,
		wp_enqueue_script( 'vision-shortcodes'); // follow by this which contains the prettyphoto init script.
		wp_enqueue_style('vision-shortcodes'); // css in html head
		wp_enqueue_style('vision-social'); // ss-social icon font
	}
}
add_action('init','vision_enqueue_script');


/*----------------------------*/
/*	IE-specific scripts
/*----------------------------*/
function vision_hook_scripts(){
?>
<!--[if lt IE 9]>
<link rel="stylesheet" href="<?php echo plugins_url(); ?>/vision/css/IE.css" />
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script type="text/javascript" src="<?php echo plugins_url(); ?>/vision/js/IE.js"></script>
<![endif]-->
<?php
}
add_action('wp_head','vision_hook_scripts',10);


// formatter moved from vision-shortcodes.php @since version 2.0
// this formatter only formats codes with raw tag and does not affect theme content.
if(!function_exists('my_formatter')){

/*----------------------------*/
/*	Shortcode Formatter
/*----------------------------*/
function vision_my_formatter($content) {
	$new_content = '';
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

	foreach ($pieces as $piece) {
		if (preg_match($pattern_contents, $piece, $matches)) {
			$new_content .= $matches[1]; //matches the raw tags.
		} else {
		    //This will leave all default wordpress formatting in-tact.
			$new_content .= $piece;
		}
	}

	return $new_content;
}

add_filter('the_content', 'vision_my_formatter', 99);
add_filter('widget_text', 'vision_my_formatter', 99);

}
?>