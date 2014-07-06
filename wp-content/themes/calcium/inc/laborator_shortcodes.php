<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */


# Column
add_shortcode('lab_column', 'shortcode_lab_column');

function shortcode_lab_column($atts, $content = '')
{
	extract(shortcode_atts(array(
		'size_lg' => 12,
		'size_md' => 12,
		'size_sm' => 12
	), $atts));
	
	
	$size_lg = intval($size_lg);
	$size_md = intval($size_md);
	$size_sm = intval($size_sm);
	
	$class = '';	
	$class .= ' small-' . $size_sm;
	$class .= ' medium-' . $size_md;
	$class .= ' large-' . $size_lg;
		
	
	$output = lab_com('Column Content');
	$output .= '<div class="content-column ' . trim($class) . ' columns">';
	$output .= do_shortcode($content);
	$output .= '</div>';
	$output .= lab_com_close();
	
	return $output;
}


# Clear
add_shortcode('lab_clear', 'shortcode_lab_clear');

function shortcode_lab_clear()
{
	return '<div class="clear"></div>';
}


# Breadcrumb
add_shortcode('lab_breadcrumb', 'shortcode_lab_breadcrumb');

function shortcode_lab_breadcrumb()
{
	return '<div class="large-12 columns breadcrumb-env-shortcode">' . dimox_breadcrumbs(false, true) . '</div>';
}


# Alert
add_shortcode('lab_alert', 'shortcode_lab_alert');


function shortcode_lab_alert($atts, $content = '')
{
	extract(shortcode_atts(array(
		'type' => 'default'
	), $atts));
	
	$class = '';
	
	$type = strtolower($type);
	
	if(in_array($type, array('info', 'success', 'warning', 'error', 'secondary')))
	{
		$class = $type;
	}
	
	$output = lab_com('Alert Box');
	$output .= '<div data-alert class="alert-box' . ($class ? " {$class}" : '') . '">';
	$output .= trim($content);
	$output .= '<a href="#" class="close">&times;</a>';
	$output .= '</div>';
	$output .= lab_com_close();
	
	return $output;
}



# Button
add_shortcode('lab_button', 'shortcode_lab_button');

function shortcode_lab_button($atts, $content = '')
{
	extract(shortcode_atts(array(
		'size' => 'small',
		'href' => 'http://',
		'new_window' => false
	), $atts));
	
	$size = strtolower($size);
	
	if( ! in_array($size, array('small', 'tiny', 'large')))
		$size = 'small';
	
	$output = lab_com('Button');
	$output .= '<a href="' . esc_attr($href) . '"' . ($new_window == 'on' ? (' target="_blank"') : '') . ' class="button ' . $size . '">' . $content . '</a>';
	$output .= lab_com_close();
	
	return $output;
}



# Pricing Box
add_shortcode('lab_pricing_box', 'shortcode_lab_pricing_box');

function shortcode_lab_pricing_box($atts, $content = '')
{
	extract(shortcode_atts(array(
		'head_title'      => '', 
		'currency'        => '', 
		'price'           => '', 
		'term'            => '', 
		'button_label'    => '', 
		'button_size'     => '', 
		'button_url'      => '', 
		'button_target'   => '',
		'selected_plan'	  => ''
	), $atts));
	
	
	$output = lab_com('Pricing Box');
	$output .= '<ul class="pricing-table'.($selected_plan == 'yes' ? ' selected-table' : '').'">' . PHP_EOL;
	
	$output .= '<li class="title">' . $head_title . '</li>' . PHP_EOL;
	$output .= '<li class="price">' . $currency . $price . '</li>' . PHP_EOL;
	$output .= '<li class="description">' . $term . '</li>' . PHP_EOL;
	
	$features = explode(PHP_EOL, strip_tags(trim($content), '<li><strong>'));
	
	foreach($features as $feature)
	{
		$output .= trim(str_replace('<li>', '<li class="bullet-item">', $feature)) . PHP_EOL;
	}
	
	$output .= '<li class="cta-button"><a class="button ' . $button_size . '" href="' . $button_url . '" target="' . $button_target . '">' . $button_label . '</a></li>' . PHP_EOL;
	$output .= '</ul>';
	$output .= lab_com_close();
	
	return $output;
}


# Tabs and Accordions
add_shortcode('lab_tabs', 'shortcode_lab_tabs');
add_shortcode('lab_tab', 'shortcode_tab');

function shortcode_tab($atts, $content = '')
{
	return array($atts, $content);
}

function shortcode_lab_tabs($atts, $content = '')
{
	extract(shortcode_atts(array('type' => 'tabs'), $atts));
	
	$shortcode_pattern = get_shortcode_regex();
	
	preg_match_all( "/$shortcode_pattern/s", $content, $tabs_matches);
	
	$tabs = array();
	
	if(count($tabs_matches))
	{
		foreach($tabs_matches[0] as $i => $tab)
		{
			$tab_content = $tabs_matches[5][$i];
			$tab_vars = $tabs_matches[3][$i];
			$tab_atts = array();
			
			
			// Add args
			foreach(explode(" ", trim($tab_vars)) as $arg)
				$tab_atts = array_merge($tab_atts, wp_parse_args($arg));
				
			# Title Separately
			if( preg_match("/title=\"(.*?)\"/i", $tab_vars, $title_matches) )
			{
				$tab_atts['title'] = $title_matches[1];
			}
			
			// Strip quotes
			foreach($tab_atts as $i => $val)
				$tab_atts[$i] = trim($val, '"');
			
			$tabs[] = array('id' => 'tb-' . mt_rand(1000000,9000000), 'content' => $tab_content, 'attrs' => $tab_atts);
		}
	}
	
	
	if($type == 'accordion')
	{	
		$output = lab_com('Accordions');
		$output .= '<dl class="accordion">' . PHP_EOL;
		
		foreach($tabs as $i => $tab)
		{
			$output .= "\t" . '<dd>' . PHP_EOL;
			$output .= "\t\t" . '<a href="#' . $tab['id'] . '">' . $tab['attrs']['title'] . '</a>' . PHP_EOL;
			$output .= "\t\t" . '<div id="' . $tab['id'] .'" class="content' . (isset($tab['attrs']['active']) && $tab['attrs']['active'] == 'yes' ? ' active' : '') . '">' . do_shortcode($tab['content']) .  ' </div>' . PHP_EOL;
			$output .= "\t" . '</dd>' . PHP_EOL;
		}
		
		$output .= '</dl>' . PHP_EOL;
		$output .= lab_com_close();
		
		return $output;
	}
	
	
	$output = lab_com('Tabs');
	$output .= '<dl class="tabs">' . PHP_EOL;
	
	foreach($tabs as $i => $tab)
	{
		$output .= "\t" . '<dd' . (isset($tab['attrs']['active']) && $tab['attrs']['active'] == 'yes' ? ' class="active"' : '') . '><a href="#' . $tab['id'] . '">' . $tab['attrs']['title'] . '</a></dd>' . PHP_EOL;
	}
	
	$output .= '</dl>' . PHP_EOL;
	$output .= '<div class="tabs-content">' . PHP_EOL;
	
	foreach($tabs as $i => $tab)
	{
		$output .= "\t" . '<div class="content' . (isset($tab['attrs']['active']) && $tab['attrs']['active'] == 'yes' ? ' active' : '') . '" id="' . $tab['id'] . '">' . do_shortcode($tab['content']) . '</div>' . PHP_EOL;
	}
	
	$output .= '</div>' . PHP_EOL;	
	$output .= lab_com_close();
	
	return $output;
}