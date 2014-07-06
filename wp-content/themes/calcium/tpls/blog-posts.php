<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

global $custom_query_vars, $paged;

$filter = array(
	'post_type' => 'post',
	'paged' => $paged
);


# Blog Meta
if(is_page())
{
	$filter_posts	   = get_field('filter_posts');
	$select_category   = get_field('select_category');
	$post_ids		   = get_field('post_ids');
	$authors		   = get_field('author');
	
	$posts_per_page    = get_field('posts_per_page');
	$order_by          = get_field('order_by');
	$order_direction   = get_field('order_direction');
	
	if($filter_posts && in_array($filter_posts, array('category', 'post_id', 'author')))
	{
		switch($filter_posts)
		{
			case "category":
				if(count($select_category))
				{
					$cat_ids = array();
					
					foreach($select_category as $term)
					{
						$cat_ids[] = $term->term_id;
					}
					
					$filter['category__in'] = $cat_ids;
				}
				break;
			
			case "post_id":
				if(count($post_ids))
				{
					$post_ids_arr = array();
					
					foreach($post_ids as $item)
					{
						$post_ids_arr[] = $item->ID;
					}
					
					$filter['post__in'] = $post_ids_arr;
				}
				break;
			
			case "author":
				if(count($author))
				{
					$author_ids = array();
					
					foreach($authors as $a)
					{
						$author_ids[] = $a['ID'];
					}
					
					$filter['author__in'] = $author_ids;
				}
				break;
		}
	}
	
	if($posts_per_page)
		$filter['posts_per_page'] = $posts_per_page;
	
	if($order_by && $order_by != 'default')
		$filter['orderby'] = $order_by;
	
	if($order_direction && $order_direction != 'default')
		$filter['order'] = $order_direction;
}

if(isset($custom_query_vars) && is_array($custom_query_vars))
{
	$filter = array_merge($filter, $custom_query_vars);
}

$blog = new WP_Query($filter);

# Meta Information about WP Posts Query
$max_num_pages  = $blog->max_num_pages;
$paged          = isset($blog->query['paged']) ? $blog->query['paged'] : 1;


get_template_part("tpls/layout-breadcrumb");
?>

<div class="blog">
	
	<?php
	
	if(is_author()):
	
		get_template_part('tpls/blog-post-author');
		
	endif;
	
	
	while($blog->have_posts()): $blog->the_post();
		
		global $post;
		
		get_template_part("tpls/blog-post");
		
	endwhile;

	if($max_num_pages > 1):
	
		$_from               = 1;
		$_to                 = $max_num_pages;
		$current_page        = $paged ? $paged : 1;
		$numbers_to_show     = 5;
		$pagination_position = 'center';
		
		list($from, $to) = generate_from_to($_from, $_to, $current_page, $max_num_pages, $numbers_to_show);
		
		laborator_show_pagination($current_page, $max_num_pages, $from, $to, $pagination_position);
	
	endif;
	
	wp_reset_postdata();
	wp_reset_query();
	?>
	
</div>