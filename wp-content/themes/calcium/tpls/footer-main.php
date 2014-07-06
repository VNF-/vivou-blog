<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

$social_class_names = array(
	'fb'   => 'facebook',
	'tw'   => 'twitter',
	'drb'  => 'dribbble',
	'vm'   => 'vimeo',
	'lin'  => 'linkedin',
	'yt'   => 'youtube',
	'ig'   => 'instagram',
	'pi'   => 'pinterest',
);
$footer_social_order = get_data('footer_social_order');

if(is_array($footer_social_order) && isset($footer_social_order['visible']))
	$social_networks = $footer_social_order['visible'];
else
	$social_networks = array();

?>
<div class="row">
	<footer class="footer-block">
	
		<div class="large-6 columns">
			<?php echo do_shortcode(get_data('footer_text')); ?>
		</div>
		
		<div class="large-6 columns social-networks">
			<?php
			foreach($social_networks as $social_network => $sn_name):
				if( ! isset($social_class_names[$social_network]))
					continue;
				
				$sn_id = $social_class_names[$social_network];
			?>
			<a href="<?php echo get_data("footer_social_{$social_network}"); ?>" class="<?php echo $sn_id ?>"><i class="fi-social-<?php echo $sn_id; ?> size-24"></i></a>
			<?php 
			endforeach; 
			?>
		</div>
		
	</footer>
</div>