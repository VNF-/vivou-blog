<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

$id                 = get_the_id();
$title              = get_the_title();
$permalink          = get_permalink();
$excerpt            = get_the_content();
$secondary_title    = get_field('secondary_title');
$client_name		= get_field('client');
$finish_date 		= get_field('finish_date');

$portfolio_images 	= gb_field('portfolio_images');
$has_gallery		= count($portfolio_images);

# Data
$portfolio_autoswitch   = get_data('portfolio_autoswitch');
$portfolio_item_layout  = get_data('portfolio_item_layout');
$categories_visible     = get_data('portfolio_categories_visible');

$portfolio_autoswitch   = $portfolio_autoswitch == 'Disable Autoswitch' ? 0 : $portfolio_autoswitch;

$thumb_size             = 'portfolio-thumb-1';
$gallery_thumb_size     = 'portfolio-thumb-2';

if(in_array($portfolio_item_layout, array('top', 'bottom')))
	$gallery_thumb_size = 'portfolio-thumb-3';

# Share
$portfolio_share_networks = get_data('portfolio_share_networks');
$fb_share = isset($portfolio_share_networks['facebook']) && $portfolio_share_networks['facebook'];
$tw_share = isset($portfolio_share_networks['twitter']) && $portfolio_share_networks['twitter'];
$gp_share = isset($portfolio_share_networks['google']) && $portfolio_share_networks['google'];

$do_share = $fb_share || $tw_share || $gp_share;

$details_arr = array(
	'id'                   => $id,
	'title'                => $title,
	'secondary_title'      => $secondary_title,
	'content'			   => get_the_content(),
	'permalink'            => $permalink,
	'has_gallery'          => $has_gallery,
	'client_name'          => $client_name,
	'finish_date'          => $finish_date,
	'do_share'             => $do_share,
	'fb_share'             => $fb_share,
	'tw_share'             => $tw_share,
	'gp_share'             => $gp_share,
	'categories_visible'   => $categories_visible
);

?>

<?php if($portfolio_item_layout != 'bottom') show_portfolio_item_details($details_arr); ?>

<?php if($has_gallery): ?>
<div class="large-7 columns item-gallery">

	<div class="portfolio-gallery" data-switch-interval="<?php echo $portfolio_autoswitch; ?>">
		<?php 				
		$i = 0;
		
		foreach($portfolio_images as $portfolio_image):
			
			$alt = $portfolio_image->_wp_attachment_image_alt;
			$is_video = false;
			
			if(preg_match("/(vimeo\.com|youtube\.com)/i", $alt))
			{
				$is_video = true;
			}
				
			wp_enqueue_script('magnific-popup');
			wp_enqueue_style('magnific-popup');
			
			?>
			<a href="<?php echo $is_video ? $alt : $portfolio_image->guid; ?>"<?php if($is_video): ?> data-video-url="<?php echo $alt; ?>"<?php endif; ?> title="<?php echo esc_attr($portfolio_image->post_title); ?>" class="img<?php echo $i > 0 ? ' hidden' : ''; ?>">
				<?php echo laborator_show_img($portfolio_image->guid, $gallery_thumb_size); ?>
				
				<?php if($is_video): ?>
				<i class="entypo-play"></i>
				<?php endif; ?>
			</a>
			<?php
			
			$i++;
			
		endforeach;
		
		if(count($portfolio_images) > 1):
		?>
		<div class="portfolio-gallery-pager dotstyle dotstyle-smalldotstroke">
			<ul></ul>
		</div>
		
		<a class="portfolio-next">
			<span></span>
		</a>
		<a class="portfolio-prev">
			<span></span>
		</a>
		<?php 
		endif; 
		?>
	</div>
	
</div>
<?php endif; ?>

<?php if($portfolio_item_layout == 'bottom') show_portfolio_item_details($details_arr); ?>