<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

# Page Title optimized for better seo
add_filter('wp_title', 'filter_wp_title');

function filter_wp_title( $title )
{
	global $page, $paged;
	
	$separator = '-';
	
	if ( is_feed() )
		return $title;
	
	$site_description = get_bloginfo( 'description' );
	
	$filtered_title = $title . get_bloginfo( 'name' );
	$filtered_title .= ( ! empty( $site_description ) && ( is_home() || is_front_page() ) ) ? ' '.$separator.' ' . $site_description: '';
	$filtered_title .= ( 2 <= $paged || 2 <= $page ) ? ' '.$separator.' ' . sprintf( __( 'Page %s', TD), max( $paged, $page ) ) : '';
	
	return $filtered_title;
}


# Laborator Theme Options Translate
add_filter('admin_menu', 'laborator_add_menu_classes', 100);

function laborator_add_menu_classes($items)
{
	global $submenu;
	
	foreach($submenu as $menu_id => $sub)
	{
		if($menu_id == 'laborator_options')
		{
			$submenu[$menu_id][0][0] = 'Theme Options';
		}
	}

	return $submenu;
}


# Excerpt Length & More
add_filter('excerpt_length', create_function('', 'return 100;'));
add_filter('excerpt_more', create_function('', 'return "&hellip;";'));


# Comments
function laborator_comment_fields($fields)
{
	foreach($fields as $field_type => $field_html)
	{
		preg_match("/<label(.*?)>(.*?)\<\/label>/", $field_html, $html_label);
		preg_match("/<input(.*?)\/>/", $field_html, $html_input);
		
		$html_label = strip_tags($html_label[2]);
		$html_input = $html_input[0];
		
		$html_input = str_replace("<input", '<input class="text_field" placeholder="'.esc_attr($html_label).'" ', $html_input);
		$fields[$field_type] = "<div class=\"comment_field\">
	{$html_input}
</div>";
	}
	
	
	return $fields;
}

function laborator_comment_before_fields()
{
	echo '<div class="author_info">';
}

function laborator_comment_after_fields()
{
	echo '</div>';
}


# Body Classes
add_filter('body_class', 'sidebar_menu_position');

function sidebar_menu_position($classes)
{
	if(get_data('sidebar_menu_position') != 1)
	{
		$classes[] = 'right-sidebar';
	}
	else
	{
		$classes[] = 'left-sidebar';
	}
	
	return $classes;
}


// Thumbnails
if(function_exists('add_theme_support'))
{
	add_filter('manage_posts_columns', 'lab_column_thumbnail_add', 5);
	add_action('manage_posts_custom_column', 'lab_column_thumbnail', 5, 2);
}

function lab_column_thumbnail_add($columns)
{
	$new_column = array();
	$new_column['cb'] = $columns['cb'];
	$new_column['lab_post_thumbnail'] = __('Image', TD);
	
	$columns = array_merge($new_column, $columns);
	
	return ($columns);
}
function lab_column_thumbnail($column_name, $id)
{
	if ($column_name === 'lab_post_thumbnail')
		echo the_post_thumbnail(array(80, 50));
}



# Theme Skins
add_filter('of_options_before_save', 'laborator_skins_compile');

function laborator_skins_compile($data)
{
	if(isset($data['skin_custom']) && $data['skin_custom'])
	{
		custom_skin_compile(array(
			'link_color_hover' => $data['skin_color_link_color_hover'],
			'link_color_hover_text' => $data['skin_color_link_color_hover_text']
		));
	}
	
	return $data;
}