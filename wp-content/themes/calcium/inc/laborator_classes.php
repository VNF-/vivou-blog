<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

class Calcium_Walker extends Walker_Nav_Menu
{
	function start_lvl( &$output, $depth = 0, $args = array() )
	{
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul class=\"sub-menu hidden-text\">\n" . '<div class="arrow-up"></div>';
	}
	
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
	{
		global $parent_elements_count, $parent_sidebar_icon;
		
		# Check if is fallback menu
		if(is_array($args))
		{
			$args = (object) $args;
			$item->title = $item->post_title;
		}
		
		# Sidebar Icon
		if( ! $parent_sidebar_icon)
		{
			$output .= '<li class="sidebar-menu'.(get_data('sidebar_menu_icon_position') != 1 ? ' right' : '').'" id="open-sidebar-menu">';
			$output .= '<button data-effect="st-effect-3">Menu</button>';
			$output .= '</li>';
			
			$parent_sidebar_icon = true;
		}
		
		if($depth == 0)
			$parent_elements_count++;
		
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		
		$has_icon = false;
		$has_text_icon = false;
		$icon_class = '';
		
		
		if(preg_match("/icon\-([a-z0-9\-]+)/i", implode(' ', $classes), $matches))
		{
			$has_icon    = true;
			$icon_class  = $matches[1];
			
			if(preg_match("/text\-icon\-([a-z0-9\-]+)/i", implode(' ', $classes), $matches))
				$classes[]   = 'with-icon-text';
			else
				$classes[]   = 'with-icon';
		}

		
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
		

		
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

		
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		
		if($has_icon)
		{
			$item_output .= '<i class="entypo-'.$icon_class.'"></i>';
		}
		
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}