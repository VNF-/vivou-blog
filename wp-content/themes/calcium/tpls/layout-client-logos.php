<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

$client_logos = get_all_client_logos();

wp_enqueue_script('thumbnails-carousel');

?>
<div class="row">
	<ul class="clients-carousel small-block-grid-2 medium-block-grid-4">
	<?php
	$i = 0;
	foreach($client_logos as $logo):
		
		$link = $logo['link'];
		$blank_page = $logo['blank_page'];
		$logo_image = $logo['logo_image'];
		
		if(is_array($logo_image) && count($logo_image)):
		
		?>
		<li<?php echo $i >= 4 ? ' class="hidden"' : ''; ?>>
			<a href="<?php echo $link; ?>"<?php echo $blank_page ? ' target="_blank"' : ''; ?>>
				<img src="<?php echo site_url($logo_image['th']); ?>" alt="" title="<?php echo esc_attr($logo['name']); ?>" />
			</a>
		</li>
		<?php
		
			$i++;
		endif;
		
	endforeach;
	?>
	</ul>
</div>