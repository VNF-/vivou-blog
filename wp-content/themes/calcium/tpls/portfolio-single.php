<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

wp_enqueue_script('cycle2');

$portfolio_item_layout = get_data('portfolio_item_layout');

# Next and Previous Links
$prev_post = get_adjacent_post(false, null, 0);
$next_post = get_adjacent_post(false, null, 1);

?>
<section class="portfolio portfolio-single">

	<ul>
	
		<div class="project-open<?php echo " item-layout-{$portfolio_item_layout}"; ?>">
		
			<div class="row">
				
				<?php get_template_part('tpls/portfolio-item-details'); ?>
				
			</div>
			
		</div>

	</ul>
	
</section>

<?php
if($prev_post || $next_post)
{
	?>
	<div class="row prev_next_project">
	
		<div class="large-6 columns">
			<?php if($prev_post): ?>
			<a href="<?php echo get_permalink($prev_post->ID); ?>" class="prev">
				<i class="entypo-left-open"></i>
				<span><?php echo get_the_title($prev_post); ?></span>
			</a>
			<?php endif; ?>
		</div>
		
		<div class="large-6 columns text-right">			
			<?php if($next_post): ?>
			<a href="<?php echo get_permalink($next_post->ID); ?>" class="next">
				<span><?php echo get_the_title($next_post); ?></span>
				<i class="entypo-right-open"></i>
			</a>
			<?php endif; ?>
		</div>
		
	</div>
	<?php
}
?>

<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		socialNetworksInit();
		
		var $gallery = $(".portfolio-single .portfolio-gallery"),
			sw = $gallery.data('switch-interval');
		
		$gallery.preloadAllImages(function()
		{
			$gallery.find('.hidden').removeClass('hidden');
			
			$gallery.cycle({
				speed: 600,
				log: false,
				slides: '> a.img',
				timeout: 1000 * sw,
				pager: $gallery.find('.portfolio-gallery-pager ul'),
				next: $gallery.find('.portfolio-next'),
				prev: $gallery.find('.portfolio-prev'),
				autoHeight: 'container',
				pagerTemplate: '<li><a></a></li>',
				pagerActiveClass: 'current',
				pauseOnHover: true
			});
		});
	});
</script>