<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

global $parent_elements_count, $parent_sidebar_icon;

$header_type = get_data('header_type');

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

$parent_elements_count = 0;
$navigation = wp_nav_menu($nav_args);

if(preg_match('#<div class="main-nav">#i', $navigation))
{
	$navigation = preg_replace('#<div class="main-nav"><ul>#', '<ul class="main-nav">', $navigation);
	$navigation = preg_replace('#</li></ul></div>#', '</li></ul>', $navigation);
}

# Custom Logo
$use_uploaded_logo              = get_data('use_uploaded_logo');
$custom_logo_image              = get_data('custom_logo_image');
$custom_logo_image_responsive   = get_data('custom_logo_image_responsive');

$use_uploaded_logo = $use_uploaded_logo && $custom_logo_image;

if(isset($_GET['center-logo']))
{
	$header_type = 'Centered logo';
}
?>
<div class="row nav-menu-env">
	<header class="<?php echo $header_type == 'Centered logo' ? ' centered-logo' : ''; ?>">
	
		<div class="large-12 columns">
		
			<div class="header-container">
			
				<h1 class="logo">
					<a href="<?php echo home_url(); ?>">
						<?php if($use_uploaded_logo): ?>
						
							<?php if($custom_logo_image_responsive): $resp_logo_size = getimagesize(str_replace(home_url('/'), '', $custom_logo_image_responsive)); ?>
							<img src="<?php echo $custom_logo_image_responsive; ?>" class="retina-display" width="<?php echo intval($resp_logo_size[0]/2); ?>" />
							<?php endif; ?>
							
							<img src="<?php echo $custom_logo_image; ?>" />
						<?php else: ?>
							<?php echo get_data('logo_text'); ?>
						<?php endif; ?>
					</a>
				</h1>
				
				<nav class="<?php echo "nav-items-{$parent_elements_count}"; echo $parent_elements_count > 5 ? ' more-than-5' : ''; echo $parent_elements_count > 6 ? ' more-than-6' : ''; ?>">
					<?php echo $navigation; ?>
				</nav>
				
			</div>
		</div>
		
	</header>
</div>
