<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

$homepage_blocks = get_data('homepage_blocks');
$homepage_blocks = $homepage_blocks['visible'];

unset($homepage_blocks['placebo']);

foreach($homepage_blocks as $layout_id => $name)
{
	get_template_part("tpls/layout-{$layout_id}");
}