<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>> <!--<![endif]-->
<head>

	<!-- Page Meta -->
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width">
	
	<title><?php wp_title('|', true, 'right'); ?></title>

	<?php wp_head(); ?>
	
</head>
<body <?php body_class(); ?>>

<?php if( ! defined("NO_HEADER")): ?>
<div id="container" class="container">

	<div class="pusher">
		<!-- sidebar nav -->
		<?php get_template_part('tpls/nav-sidebar'); ?>
		
		
		<!-- main content -->
		<div class="st-content">
		
			<div class="st-content-inner">
				
				<?php get_template_part('tpls/nav-menu'); ?>
	
	<?php endif; ?>