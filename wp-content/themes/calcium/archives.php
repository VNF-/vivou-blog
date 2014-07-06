<?php
/*
	Template Name: Archive
*/

/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

global $custom_query_vars;

# Meta
$archive_title = get_field('archive_title');
$archive_post_type = get_field('archive_post_type');

# Fetch Posts
$filter = array(
	'post_type' => $archive_post_type,
	'posts_per_page' => -1,
	'orderby' => 'date',
	'order' => 'desc',
	'post_status' => 'publish'
);

if(isset($custom_query_vars) && is_array($custom_query_vars))
{
	$filter = array_merge($filter, $custom_query_vars);
}

$archive = new WP_Query($filter);

# Other Info
$years = array();

foreach($archive->posts as $archive_post)
{
	$year = get_the_time("Y", $archive_post);
	
	if( ! isset($years[$year]))
		$years[$year] = array();
		
	$years[$year][] = $archive_post;
}

krsort($years);


get_header();


?>
<div class="archives row">
	<div class="large-12 columns">
		<h1><?php echo $archive_title; ?></h1>
	</div>
</div>

<div class="row archives-list">
	
	<?php
	if( ! $archive->have_posts()):
		
		?>
		<div class="row article year-row">
			<div class="large-3  medium-3 small-4 columns">
				<div class="months">
					<h1><?php echo date("Y"); ?></h1>
				</div>
			</div>
	
			<div class="large-8  medium-8 small-8 columns">
				<div class="title number-words">
					<?php _e('There are no items in this archive!', TD); ?>
				</div>
			</div>
			
		</div><!-- end: Row -->
		<?php
		
	endif;
	
	foreach($years as $year => $year_posts):
		
		$last_month = '';
		$last_date = '';
		
		if( ! count($year_posts))
			continue;
		
	?>
	<div class="row article year-row">
		<div class="large-3  medium-3 small-4 columns">
			<div class="months">
				<h1><?php echo $year; ?></h1>
			</div>
		</div>

		<div class="large-8  medium-8 small-8 columns">
			<div class="title number-words">
				<?php echo number_to_word($year); ?>
			</div>
		</div>
		
	</div><!-- end: Row -->
	
		<?php
		
		foreach($year_posts as $archive_post)
		{
			$current_month = get_the_time("F", $archive_post);
			$current_date = get_the_time("j", $archive_post);
			
			if($current_month == $last_month)
				$current_month = '';
			
			?>
			<div class="row article <?php echo $current_month ? 'month-row' : 'article'; echo $last_date == $current_date && ! $current_month ? ' no-date' : ''; ?>">
				<div class="large-3 medium-3 small-12 columns">
					<div class="months">
						<h1><?php echo $current_month ? $current_month : '&nbsp;'; ?></h1>
					</div>								
				</div>
				
				<div class="large-1  medium-1 small-2 columns">
					<div class="day">
						<?php echo $current_date; ?>
					</div>
				</div>
				<div class="large-8  medium-8 small-10 columns">
					<a href="<?php echo get_permalink($archive_post); ?>" class="title"><?php echo $archive_post->post_title ? get_the_title($archive_post) : __('(No title)', TD); ?></a>
				</div>
			</div><!-- end: Row -->
			<?php
			
			if($current_month)
				$last_month = $current_month;
			
			$last_date = $current_date;
		}
		?>
		
	<?php 
	endforeach; 
	?>
										
</div>
<?php

get_footer();