<?php
/*
	Template Name: Filtered Portfolio
*/

/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

$head_text		= get_field('head_text');
$filter_type    = get_field('filter_type');
$category       = get_field('category');
$selected_items = get_field('selected_items');


the_post();

get_header();

if(trim($head_text))
{
	?>
<div class="row quotes">
	<div class="large-12 columns">
		<?php echo nl2br(trim($head_text)); ?>
	</div>
</div>
<?php
}

get_template_part('tpls/layout-portfolio-items');

get_footer();