<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

global $parent_sidebar_icon;

$theme_location = 'main-menu';

$nav_args = array(
	'theme_location'   => $theme_location,
	'container'        => '',
	'menu_class'       => 'main-nav',
	'walker'		   => new Calcium_Walker(),
	'echo'			   => false,
	'link_before'	   => '<span>',
	'link_after'	   => '</span>'
);

$navigation = wp_nav_menu($nav_args);
$parent_sidebar_icon = '';
?>
<!-- Sidebar Menu Push -->
<nav id="main-sidebar" class="st-menu st-effect-3">
	
	<div class="mobile-menu-container show-for-small-only">
		<?php echo $navigation; ?>
	</div>

	<?php 
	if(get_data('sidebar_menu_enabled'))
		dynamic_sidebar('main_sidebar'); 
	?>
	
</nav>
<!-- End of: Sidebar Menu Push -->