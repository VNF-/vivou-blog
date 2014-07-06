<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

global $portfolio_items, $count_items;

wp_enqueue_script(array('modernizr', 'fso-filter-1'));
wp_enqueue_style(array('fso-style-1'));

$portfolio_terms = get_terms('portfolio-category');

?>
<!-- open/close -->
<button id="portfolio-filter" type="button"></button>

<div class="fso-overlay overlay-hugeinc hidden">

	<button type="button" class="overlay-close">Close</button>
	
	<nav>
		<ul>
			<li>
				<a href="<?php echo home_url(); ?>" data-filter="*" class="current">
					<em><?php _e('All Items', TD); ?></em>
					
					<?php if($count_items): ?>
					<span><?php echo $portfolio_items->found_posts; ?></span>
					<?php endif; ?>
				</a>
			</li>
		<?php
		foreach($portfolio_terms as $term):
		
			?>
			<li>
				<a href="<?php echo get_term_link($term, 'portfolio-category'); ?>" data-filter="cat-<?php echo $term->slug; ?>">
					<em><?php echo $term->name; ?></em>
					
					<?php if($count_items): ?>
					<span><?php echo $term->count; ?></span>
					<?php endif; ?>
				</a>
			</li>
			<?php
		
		endforeach;
		?>
		</ul>
	</nav>
	
</div>