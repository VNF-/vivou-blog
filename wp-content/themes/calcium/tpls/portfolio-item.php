<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

global $cols;

$id                 = get_the_id();
$title              = get_the_title();
$permalink          = get_permalink();
$excerpt            = get_the_excerpt();
$content            = get_the_content();
$secondary_title    = get_field('secondary_title');
$client_name		= get_field('client');
$finish_date 		= get_field('finish_date');

if(function_exists('laborator_get_likes'))
{
	$liked              = laborator_item_is_liked();
	$likes				= laborator_get_likes();
}

$categories			= get_the_terms($id, 'portfolio-category');
$category_classes	= array();


# Data
$portfolio_columns      = isset($cols) ? $cols : get_data('portfolio_columns');
$portfolio_item_layout  = get_data('portfolio_item_layout');
$categories_visible     = get_data('portfolio_categories_visible');
$direct_link            = get_data('portfolio_linking_type') == 'Direct Link to Item';

$thumb_size = 'portfolio-thumb-1';

if(is_array($categories) && count($categories))
{
	foreach($categories as $term)
	{
		$category_classes[] = "cat-" . $term->slug;
	}
}

$categories_str		= implode(' ', $category_classes);

# Layout Class Columns
$layout_columns = 'large-3 medium-4 small-12 columns';
$excerpt_length = 20;

switch($portfolio_columns)
{
	case 3: $layout_columns = 'large-4 medium-4 small-12 columns'; $thumb_size = 'portfolio-thumb-3-cols'; $excerpt_length = 35; break;
	case 2: $layout_columns = 'large-6 medium-6 small-12 columns'; $thumb_size = 'portfolio-thumb-2-cols'; $excerpt_length = 40; break;
		
}

# Portfolio Thumbnail
if(has_post_thumbnail())
{
	$image  = laborator_img($id, $thumb_size);
}
else
{
	$portfolio_images 	= gb_field('portfolio_images');
	$has_gallery		= count($portfolio_images);
	
	if($has_gallery)
	{
		$image = $portfolio_images[0];
		$image = laborator_img($image->guid, $thumb_size);
	}
}

$excerpt = wp_trim_words($excerpt, $excerpt_length, '&hellip;');

$portfolio_class = 'portfolio-item';

if( ! $categories_visible)
	$portfolio_class .= ' no-categories';
	
if($direct_link)
	$portfolio_class .= ' direct-link';
?>
<li class="<?php echo $layout_columns; ?> hidden<?php echo $categories_str ? " {$categories_str}" : ''; ?>">

	<div <?php echo post_class($portfolio_class); ?> data-id="<?php echo $id; ?>" data-name="<?php echo $post->post_name; ?>">
	
		<a href="<?php echo $permalink; ?>" class="image show-details preload-img">
			<img src="<?php echo $image; ?>" />
		</a>
		
		<div class="project-info">
			<h4>
				<a href="<?php echo $permalink; ?>" class="show-details"><?php echo $title; ?></a>
			</h4>
			
			<p><?php echo $excerpt; ?></p>
			
			<?php if($categories_visible && has_term('', 'portfolio-category')): ?>
			<div class="categories item-categories"><?php the_terms($id, 'portfolio-category'); ?></div>
			<?php endif; ?>
			
			<?php if(function_exists('laborator_get_likes')): ?>
			<a href="#" class="like<?php echo $liked ? ' liked' : ''; echo $likes ? ' has-likes' : ''; ?>" data-id="<?php echo $id; ?>" data-verify="<?php echo laborator_likes_nonce(); ?>">
				<i class="like-hover"></i>
				<span><?php echo number_format($likes, 0); ?></span>
			</a>
			<?php endif; ?>
			
			<div class="opened-arrow"></div>
		</div>
		
		<div class="opened-arrow"></div>
		
	</div>
	
	<div class="project-open<?php echo " item-layout-{$portfolio_item_layout}"; ?>">
	
		<a class="close" href="#"></a>
		
		<div class="row">
			
			<?php get_template_part('tpls/portfolio-item-details'); ?>
			
		</div>
	</div><!-- / Open Project -->
	
</li>