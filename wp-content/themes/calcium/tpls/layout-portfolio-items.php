<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

global $paged, $taxonomy, $wp_query, $portfolio_items, $filter_type, $category, $selected_items, $cols, $count_items;

wp_enqueue_script(array('isotope', 'calcium-portfolio', 'cycle2'));

$use_isotope		= true;
$pagination_type    = get_data('portfolio_pagination_type');
$rows               = get_data('portfolio_rows');
$cols               = get_data('portfolio_columns');
$category_type		= get_data('portfolio_category_filter_type') == 'Overlay Categories' ? 'overlay' : 'list';
$count_items		= get_data('portfolio_count_items');


$filter = array(
	'post_type'        => 'portfolio',
	'posts_per_page'   => $cols * $rows,
	'paged'			   => $paged
);

# Query (for More pagination
$more_query = array();

if($taxonomy)
{
	$filter[$taxonomy] = $wp_query->query_vars[$taxonomy];
}

if($filter_type)
{
	switch($filter_type)
	{
		case "category":
			
			$filter['tax_query'] = array(
				
				array(
					'taxonomy' => 'portfolio-category',
					'field' => 'id',
					'terms' => $category
				),
			);
			
			$more_query['categories'] = $category;
			break;
		
		case "ids":
			$filter['post__in'] = $selected_items;
			$more_query['ids'] = $selected_items;
			break;
	}
}

$portfolio_items = new WP_Query($filter);

# Meta Information about WP Posts Query
$max_num_pages  = $portfolio_items->max_num_pages;
$paged          = isset($portfolio_items->query['paged']) ? $portfolio_items->query['paged'] : 1;

if($taxonomy == 'portfolio-category')
{
	$more_query['category'] = $wp_query->query_vars[$taxonomy];
}

$more_query = (object) $more_query;
?>
<?php
if(get_data('portfolio_filter') && ! $taxonomy && $category_type == 'list'):

	$portfolio_terms = get_terms('portfolio-category');
	
	?>
	<div class="row">
		<div class="large-12">
		
			<ul class="portfolio-filter-upper">
				<li>
					<a href="<?php echo home_url(); ?>" data-filter="*" class="current" data-no-fso="1">
						<em><?php _e('All Items', TD); ?></em>
						
						<?php if($count_items): ?>
						<span>(<?php echo $portfolio_items->found_posts; ?>)</span>
						<?php endif; ?>
					</a>
				</li>
			<?php
			foreach($portfolio_terms as $term):
			
				?>
				<li>
					<a href="<?php echo get_term_link($term, 'portfolio-category'); ?>" data-filter="cat-<?php echo $term->slug; ?>" data-no-fso="1">
						<em><?php echo $term->name; ?></em>
						
						<?php if($count_items): ?>
						<span>(<?php echo $term->count; ?>)</span>
						<?php endif; ?>
					</a>
				</li>
				<?php
			
			endforeach;
			?>
			</ul>
			
		</div>
	</div>
	<?php

endif;
?>

<section class="portfolio<?php echo $filter['posts_per_page'] < $portfolio_items->found_posts ? ' is-loading' : ''; echo $use_isotope ? ' with-isotope' : ''; ?>">
	
	<div class="portfolio-loading">
		<span>
			<i class="entypo-cw"></i>
			<?php _e('Loading Portfolio Items...', TD); ?>
		</span>
	</div>
	
	<?php 
	# Category Filtering
	if(get_data('portfolio_filter') && ! $taxonomy && $category_type == 'overlay')
		get_template_part('tpls/portfolio-filter');
	?>	
	
	<ul>
	<?php
	if($portfolio_items->have_posts()):
	
		while($portfolio_items->have_posts()): $portfolio_items->the_post();
		
			get_template_part('tpls/portfolio-item');
			
		endwhile;
		
		wp_reset_query();
		wp_reset_postdata();
		
	endif;
	?>
	</ul>
	<div class="clear"></div>
	
	<?php
	
	if($max_num_pages > 1)
	{
		switch($pagination_type)
		{
			case 2:
				?>
				<div class="portfolio-pagination">
					
					<a href="#" class="load-more" data-loading="<?php echo _e('Loading...', TD); ?>" data-rows="<?php echo $rows; ?>" data-cols="<?php echo $cols; ?>" data-paged="2" data-query="<?php echo esc_attr(json_encode($more_query)); ?>">
						<i class="entypo-cw"></i>
						<?php _e('Load More', TD); ?>
					</a>
					
				</div>
				<?php
				break;
			
			default:
			
				?>
				<div class="portfolio-pagination">
				<?php
				$_from               = 1;
				$_to                 = $max_num_pages;
				$current_page        = $paged ? $paged : 1;
				$numbers_to_show     = 5;
				$pagination_position = 'center';
				
				list($from, $to) = generate_from_to($_from, $_to, $current_page, $max_num_pages, $numbers_to_show);
				
				laborator_show_pagination($current_page, $max_num_pages, $from, $to, $pagination_position);
				?>
				</div>
				<?php
		}
	}
	?>
</section>