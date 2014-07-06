<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

global $wp_query;

# Meta Information about WP Posts Query
$max_num_pages = $wp_query->max_num_pages;
$paged = isset($wp_query->query['paged']) ? $wp_query->query['paged'] : 1;

get_header();

?>
<div class="search-bar row">
	<div class="large-8 columns">
		<h1><?php echo sprintf(__("Search results for <span>&quot;%s&quot;</span>", TD), esc_html(get('s'))); ?></h1>
	</div>
	<div class="large-4 columns">
	
		<form class="search-again" action="<?php echo esc_url(home_url('/')); ?>">
			<div class="row collapse">
				<div class="small-9 columns">
				  <input type="text" name="s" placeholder="<?php _e('Search again...', TD); ?>" value="<?php echo esc_html(get('s')); ?>">
				</div>
				
				<div class="small-3 columns">
				  <button type="submit" class="button postfix">
				  	<i class="fi-magnifying-glass size-16"></i>
				  </button>
				</div>
			</div>					
		</form>
	</div>
</div>

<div class="row">
	<div class="large-12 columns">
		<ul class="search-results">
		<?php
		if( ! have_posts()):
		
			?>
			<li class="row no-results">
				There are no results for this term!
			</li>
			<?php	
		
		endif;
		
		$s = get('s');
		
		while(have_posts()): the_post();
			
			$title = get_the_title();
			$permalink = get_permalink();
			
			$has_thumb = has_post_thumbnail();
			
			if( ! $title)
				$title = __('(No title)', TD);
			
			if(strlen($s) > 2)
			{
				$title = preg_replace("/(".str_replace(array('[', ']', '*', '?', '\\', '/'), '', $s).")/i", "<span>$1</span>", $title);
			}
		?>
			<li class="row">
				<?php if($has_thumb): ?>
				<div class="large-1 small-3 columns">
					<a class="th" href="<?php echo $permalink; ?>">
						<?php echo laborator_show_img(get_the_id(), 'search-thumb'); ?>
					</a>		
				</div>
				<?php endif; ?>
				
				<div class="large-<?php echo $has_thumb ? 11 : 12; ?> small-<?php echo $has_thumb ? 9 : 12; ?> columns">				
					<h1>
						<a href="<?php echo $permalink; ?>"><?php echo $title; ?></a>
					</h1>
					<span><?php the_time("d F Y"); ?></span>
				</div>
				
			</li>
		<?php
		endwhile;
		?>
		</ul>
		
		<?php
		if($max_num_pages > 1):
		
			$_from               = 1;
			$_to                 = $max_num_pages;
			$current_page        = $paged ? $paged : 1;
			$numbers_to_show     = 5;
			$pagination_position = 'center';
			
			list($from, $to) = generate_from_to($_from, $_to, $current_page, $max_num_pages, $numbers_to_show);
			
			laborator_show_pagination($current_page, $max_num_pages, $from, $to, $pagination_position);
		
		endif;
		?>
	</div>
</div>
<?php

get_footer();