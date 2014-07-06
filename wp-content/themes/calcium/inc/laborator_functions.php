<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */



# GET/POST getter
function get($var)
{
	return isset($_GET[$var]) ? $_GET[$var] : (isset($_REQUEST[$var]) ? $_REQUEST[$var] : '');
}

function post($var)
{
	return isset($_POST[$var]) ? $_POST[$var] : null;
}

function cookie($var)
{
	return isset($_COOKIE[$var]) ? $_COOKIE[$var] : null;
}



# Generate From-To numbers borders
function generate_from_to($from, $to, $current_page, $max_num_pages, $numbers_to_show = 5)
{
	if($numbers_to_show > $max_num_pages)
		$numbers_to_show = $max_num_pages;
	
	
	$add_sub_1 = round($numbers_to_show/2);
	$add_sub_2 = round($numbers_to_show - $add_sub_1);
	
	$from = $current_page - $add_sub_1;
	$to = $current_page + $add_sub_2;
	
	$limits_exceeded_l = FALSE;
	$limits_exceeded_r = FALSE;
	
	if($from < 1)
	{
		$from = 1;
		$limits_exceeded_l = TRUE;
	}
	
	if($to > $max_num_pages)
	{
		$to = $max_num_pages;
		$limits_exceeded_r = TRUE;
	}
	
	
	if($limits_exceeded_l)
	{
		$from = 1;
		$to = $numbers_to_show;
	}
	else
	if($limits_exceeded_r)
	{
		$from = $max_num_pages - $numbers_to_show + 1;
		$to = $max_num_pages;
	}
	else
	{
		$from += 1;
	}
	
	if($from < 1)
		$from = 1;
	
	if($to > $max_num_pages)
	{
		$to = $max_num_pages;
	}
	
	return array($from, $to);
}

# Laborator Pagination
function laborator_show_pagination($current_page, $max_num_pages, $from, $to, $pagination_position = 'full', $numbers_to_show = 5)
{
	$current_page = $current_page ? $current_page : 1;
	
	?>
	<div class="clear"></div>
	
	<!-- pagination -->
	<ul class="pagination<?php echo $pagination_position == 'center' ? ' center' : ($pagination_position == 'right' ? ' right' : ($pagination_position == 'full' ? ' full' : '')); ?>"><!-- add class 'center' or 'right' to position the text (default: left) -->		
	
	<?php if($current_page > 1): ?>
		<li class="first_page"><a href="<?php echo get_pagenum_link(1); ?>"><?php _e('First Page', TD); ?></a></li>
	<?php endif; ?>

	<?php
	
	if($from > floor($numbers_to_show / 2))
	{
		?>
		<li><a href="<?php echo get_pagenum_link(1); ?>"><?php echo 1; ?></a></li>
		<li><span class="dots">...</span></li>
		<?php
	}
	
	for($i=$from; $i<=$to; $i++):
		
		$link_to_page = get_pagenum_link($i);
		$is_active = $current_page == $i;

	?>
		<li<?php echo $is_active ? ' class="active"' : ''; ?>><a href="<?php echo $link_to_page; ?>"><?php echo $i; ?></a></li>
	<?php
	endfor;
		
	
	if($max_num_pages > $to)
	{
		if($max_num_pages != $i):
		?>
			<li><span class="dots">...</span></li>
		<?php
		endif;
		
		?>
		<li><a href="<?php echo get_pagenum_link($max_num_pages); ?>"><?php echo $max_num_pages; ?></a></li>
		<?php
	}
	?>
	
	<?php if($current_page < $max_num_pages): ?>
		<li class="last_page"><a href="<?php echo get_pagenum_link($max_num_pages); ?>"><?php _e('Last Page', TD); ?></a></li>
	<?php endif; ?>
	</ul>
	<!-- end: pagination -->
	<?php 
	
	# Deprecated (the above function displays pagination)
	if(false):
		
		posts_nav_link();
		
	endif;
}



# Get SMOF data
function get_data($var = '')
{
	global $data;
	
	if( ! function_exists('of_get_options'))
		return null;
	
	if( ! $data)
	{
		$data = of_get_options();
	}
	
	if( ! empty($var) && isset($data[$var]))
	{
		return apply_filters("get_data_{$var}", $data[$var]);
	}
	
	return null;
}





// Numbers to words
function number_to_word( $num = '' )
{
	$num	= ( string ) ( ( int ) $num );
	
	if( ( int ) ( $num ) && ctype_digit( $num ) )
	{
		$words	= array( );
		
		$num	= str_replace( array( ',' , ' ' ) , '' , trim( $num ) );
		
		$list1 = array(__('', TD), __('one', TD), __('two', TD), __('three', TD), __('four', TD), __('five', TD), __('six', TD), __('seven', TD), __('eight', TD), __('nine', TD), __('ten', TD), __('eleven', TD), __('twelve', TD), __('thirteen', TD), __('fourteen', TD), __('fifteen', TD), __('sixteen', TD), __('seventeen', TD), __('eighteen', TD), __('nineteen', TD));
		$list2 = array(__('', TD), __('ten', TD), __('twenty', TD), __('thirty', TD), __('forty', TD), __('fifty', TD), __('sixty', TD), __('seventy', TD), __('eighty', TD), __('ninety', TD), __('hundred', TD));
		$list3 = array(__('', TD), __('thousand', TD), __('million', TD), __('billion', TD), __('trillion', TD), __('quadrillion', TD), __('quintillion', TD), __('sextillion', TD), __('septillion', TD), __('octillion', TD), __('nonillion', TD), __('decillion', TD), __('undecillion', TD), __('duodecillion', TD), __('tredecillion', TD), __('quattuordecillion', TD), __('quindecillion', TD), __('sexdecillion', TD), __('septendecillion', TD), __('octodecillion', TD), __('novemdecillion', TD), __('vigintillion', TD));
		
		$num_length	= strlen( $num );
		$levels	= ( int ) ( ( $num_length + 2 ) / 3 );
		$max_length	= $levels * 3;
		$num	= substr( '00'.$num , -$max_length );
		$num_levels	= str_split( $num , 3 );
		
		foreach( $num_levels as $num_part )
		{
			$levels--;
			$hundreds	= ( int ) ( $num_part / 100 );
			$hundreds	= ( $hundreds ? ' ' . $list1[$hundreds] . __(' Hundred', TD) . ( $hundreds == 1 ? '' : 's' ) . ' ' : '' );
			$tens		= ( int ) ( $num_part % 100 );
			$singles	= '';
			
			if( $tens < 20 )
			{
				$tens	= ( $tens ? ' ' . $list1[$tens] . ' ' : '' );
			}
			else
			{
				$tens	= ( int ) ( $tens / 10 );
				$tens	= ' ' . $list2[$tens] . ' ';
				$singles	= ( int ) ( $num_part % 10 );
				$singles	= ' ' . $list1[$singles] . ' ';
			}
			$words[]	= $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_part ) ) ? ' ' . $list3[$levels] . ' ' : '' );
		}
		
		$commas	= count( $words );
		
		if( $commas > 1 )
		{
			$commas	= $commas - 1;
		}
		
		$words	= implode( ', ' , $words );
		
		//Some Finishing Touch
		//Replacing multiples of spaces with one space
		$words	= trim( str_replace( ' ,' , ',' , trim_all( ucwords( $words ) ) ) , ', ' );
		if( $commas )
		{
			$words	= str_replace_last( ',' , __(' and', TD) , $words );
		}
		
		return $words;
	}
	else if( ! ( ( int ) $num ) )
	{
		return __('Zero', TD);
	}
	
	return '';
}

function str_replace_last( $search, $replace, $subject )
{
	if ( !$search || !$replace || !$subject )
		return false;
	
	$index = strrpos( $subject, $search );
	if ( $index === false )
		return $subject;
	
	// Grab everything before occurence
	$pre = substr( $subject, 0, $index );
	
	// Grab everything after occurence
	$post = substr( $subject, $index );
	
	// Do the string replacement
	$post = str_replace( $search, $replace, $post );
	
	// Recombine and return result
	return $pre . $post;
}

function trim_all( $str , $what = NULL , $with = ' ' )
{
	if( $what === NULL )
	{
		//	Character      Decimal      Use
		//	"\0"            0           Null Character
		//	"\t"            9           Tab
		//	"\n"           10           New line
		//	"\x0B"         11           Vertical Tab
		//	"\r"           13           New Line in Mac
		//	" "            32           Space
		
		$what	= "\\x00-\\x20";	//all white-spaces and control chars
	}
	
	return trim( preg_replace( "/[".$what."]+/" , $with , $str ) , $what );
}


// Breadcrumb
function dimox_breadcrumbs($echo = true, $force_use = false)
{
	if( ! get_data('blog_breadcrumb') && ! $force_use)
		return;

	/* === OPTIONS === */
	$text['home']     = 'Home';
	$text['category'] = 'Category: "%s"';
	$text['search']   = 'Search Results for "%s" Query';
	$text['tag']      = 'Tag: "%s"';
	$text['author']   = 'Author: %s';
	$text['404']      = 'Error 404';

	$show_current   = 1;
	$show_on_home   = 0;
	$show_home_link = 1;
	$show_title     = 1;
	$delimiter      = ' &raquo; ';
	$before         = '<span class="current">';
	$after          = '</span>';
	/* === END OF OPTIONS === */

	global $post;
	
	$home_link    = home_url('/');
	$link_before  = '<span>';
	$link_after   = '</span>';
	$link_attr    = '';
	$link         = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
	$parent_id    = $parent_id_2 = $post->post_parent;
	$frontpage_id = get_option('page_on_front');
	
	$output = '';

	if (is_home() || is_front_page()) {

		if ($show_on_home == 1) $output .= '<div class="breadcrumbs"><a href="' . $home_link . '">' . $text['home'] . '</a></div>';

	} else {

		$output .= '<div class="breadcrumb">';
		if ($show_home_link == 1) {
			$output .= '<a href="' . $home_link . '">' . $text['home'] . '</a>';
			if ($frontpage_id == 0 || $parent_id != $frontpage_id) $output .= $delimiter;
		}

		if ( is_category() ) {
			$this_cat = get_category(get_query_var('cat'), false);
			if ($this_cat->parent != 0) {
				$cats = get_category_parents($this_cat->parent, TRUE, $delimiter);
				if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
				$cats = str_replace('</a>', '</a>' . $link_after, $cats);
				if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
				$output .= $cats;
			}
			if ($show_current == 1) $output .= $before . sprintf($text['category'], single_cat_title('', false)) . $after;

		} elseif ( is_search() ) {
			$output .= $before . sprintf($text['search'], get_search_query()) . $after;

		} elseif ( is_day() ) {
			$output .= sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			$output .= sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
			$output .= $before . get_the_time('d') . $after;

		} elseif ( is_month() ) {
			$output .= sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			$output .= $before . get_the_time('F') . $after;

		} elseif ( is_year() ) {
			$output .= $before . get_the_time('Y') . $after;

		} elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				printf($link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
				if ($show_current == 1) $output .= $delimiter . $before . get_the_title() . $after;
			} else {
				$cat = get_the_category(); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, $delimiter);
				if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
				$cats = str_replace('</a>', '</a>' . $link_after, $cats);
				if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
				$output .= $cats;
				if ($show_current == 1) $output .= $before . get_the_title() . $after;
			}

		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object(get_post_type());
			$output .= $before . $post_type->labels->singular_name . $after;

		} elseif ( is_attachment() ) {
			$parent = get_post($parent_id);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			if ($cat) {
				$cats = get_category_parents($cat, TRUE, $delimiter);
				$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
				$cats = str_replace('</a>', '</a>' . $link_after, $cats);
				if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
				$output .= $cats;
			}
			printf($link, get_permalink($parent), $parent->post_title);
			if ($show_current == 1) $output .= $delimiter . $before . get_the_title() . $after;

		} elseif ( is_page() && !$parent_id ) {
			if ($show_current == 1) $output .= $before . get_the_title() . $after;

		} elseif ( is_page() && $parent_id ) {
			if ($parent_id != $frontpage_id) {
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					if ($parent_id != $frontpage_id) {
						$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
					}
					$parent_id = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				for ($i = 0; $i < count($breadcrumbs); $i++) {
					$output .= $breadcrumbs[$i];
					if ($i != count($breadcrumbs)-1) $output .= $delimiter;
				}
			}
			if ($show_current == 1) {
				if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) $output .= $delimiter;
				$output .= $before . get_the_title() . $after;
			}

		} elseif ( is_tag() ) {
			$output .= $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

		} elseif ( is_author() ) {
	 		global $author;
			$userdata = get_userdata($author);
			$output .= $before . sprintf($text['author'], $userdata->display_name) . $after;

		} elseif ( is_404() ) {
			$output .= $before . $text['404'] . $after;

		} elseif ( has_post_format() && !is_singular() ) {
			$output .= get_post_format_string( get_post_format() );
		}

		if ( get_query_var('paged') ) {
			#if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) $output .= ' (';
			$output .= ' <span class="paged">(' . __('Page', TD) . ' ' . get_query_var('paged') . ')</span>';
			#if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) $output .= ')';
		}

		$output .= '</div><!-- .breadcrumbs -->';

	}
	
	if($echo)
		echo $output;
	else
		return $output;
} // end dimox_breadcrumbs()





# Extract Quote Text
function extract_quote_text( & $content)
{
	$bq_len = strlen('<blockquote>');
	
	$bq_open = strpos($content, '<blockquote>') + $bq_len;
	$bq_close = strpos($content, '</blockquote>') - $bq_len;
	
	$quote = substr($content, $bq_open, $bq_close);
	
	if( ! empty($quote))
	{
		$content = str_replace("<blockquote>{$quote}</blockquote>", '', $content);
		
		return $quote;
	}
	
	return '';
}

# Extract Video Link from the content
function extract_video_link( & $content)
{
	$content .= PHP_EOL; # Append new line at the end
	
	$video = array(
		'link' => '',
		'type' => '',
		'thumb' => ''
	);
	
	preg_match("/^(.*?)(\n)/i", $content, $matches);
	
	if(count($matches))
	{
		$video_source = $matches[1];
		
		$video['type'] = 'unknown';
		
		// Handle Youtube Videos
		if(preg_match("/youtube\.com/i", $video_source))
		{
			$video['type'] = 'youtube';
			
			parse_str( parse_url( $video_source, PHP_URL_QUERY ), $youtube_arr );
			
			$v = isset($youtube_arr['v']) ? trim($youtube_arr['v'], '_') : '';
			$video_url = "http://www.youtube.com/v/{$v}";
			
			$video['link'] = $video_url;
			$video['thumb'] = "http://img.youtube.com/vi/{$v}/0.jpg";
			
			$video['source'] = $video_source;
		}
		else
		// Handle Vimeo Videos
		if(preg_match("/vimeo\.com/i", $video_source))
		{
			$video['type'] = 'vimeo';
			
			preg_match("/vimeo\.com\/([0-9]+)/i", $video_source, $matches);
			
			if(count($matches))
			{
				$video_id = $matches[1];
				$video['link'] = "https://player.vimeo.com/video/{$video_id}";
			}
			
			$video['source'] = $video_source;
		}
		
		return $video;
	}
	
	return null;
}

# Extract Audio Shortcode 
function extract_custom_shortcode( & $post_item, $shortcode = 'shortcode')
{
	global $post;
	
	if(preg_match("/^\s*\[".$shortcode."[^\]]+\](.*\[\/".$shortcode."\])?/", $post_item->post_content, $matches))
	{
		$ext_shortcode = $matches[0];
		
		$post_item->post_content = trim(str_replace($ext_shortcode, '', $post_item->post_content));
		
		$post = $post_item;
		
		setup_postdata($post);
		
		return $ext_shortcode;
	}
	
	return '';
}



# Extract First Link from text
function extract_first_link( & $content, $target_blank = true)
{
	$link = "";
	
	$first_line = explode(PHP_EOL, $content);
	
	if(count($first_line))
		$first_line = trim($first_line[0]);
	
	preg_match('/\<a href=\"(.*?)"/', $first_line, $matches);
	
	if(count($matches))
	{
		$link = $matches[1];
	}
	else
	if(preg_match("/^http/", $first_line))
	{
		$link = trim($first_line);
	}
	
	if($link)
	{
		$content = str_replace($first_line, '', $content);
	}
	
	return $link;
}


# Video Frame Display
function laborator_show_video_frame($video_info, $height = 380)
{
	extract($video_info); # $link, $type, $thumb
	
	switch($type)
	{
		case "youtube":
			?>
			<iframe width="100%" height="<?php echo $height; ?>" src="<?php echo $link; ?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
			<?php
			break;
			
		case "vimeo":
			?>
			<iframe width="100%" height="<?php echo $height; ?>" src="<?php echo $link; ?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
			<?php
			break;
	}
}




# Extract Gallery Items
function extract_gallery_images($post_id)
{
	global $post;
	
	$previous_post = $post;
	
	extract(array(
		'order'	  => 'ASC',
		'orderby'	=> 'menu_order ID',
		'id'		 => $post_id,
		'size'	   => 'thumbnail'
	));
	
	$content = get_the_content();
	
	if(preg_match("/^\.*?(\[gallery.*?\])/", $content, $shortcode ))
	{
		$shortcode = trim(str_replace(array('[gallery', ']'), array(''), $shortcode[0]));
		preg_match_all("/(\w+\=\".*?\")/", $shortcode, $attrs);
		
		if(count($attrs) > 0)
		{
			$attrs = $attrs[0];
			$get_posts_params = array('post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby);
			$has_ids = false;
			
			foreach($attrs as $attr)
			{
				$equals_pos = strpos($attr, '=');
				$key = substr($attr, 0, $equals_pos);
				$val = trim(trim(substr($attr, $equals_pos + 1), '"'), "'");
				
				switch($key)
				{
					case "ids":
						$key = "include";
						$has_ids = true;
						break;
				}
				
				$get_posts_params[$key] = $val;
			}
			
			if($has_ids)
			{
				$images = get_posts( $get_posts_params );
				
				if($previous_post)
				{
					$post = $previous_post;
				}
				
				return $images;
			}
		}
	}
	
	$images = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	
	if($previous_post)
	{
		$post = $previous_post;
	}
	
	return $images;
}


# Extract Image Link
function extract_post_image( & $content)
{
	$image = '';
	
	if(preg_match("#<img.*?src=\"(.*?)\" .*?>#", $content, $matches))
	{
		$image = $matches[1];
		$content = str_replace($matches[0], '', $content);
	}
	
	return $image;
}


# Get URL
function laborator_get_url($url)
{
	if( ! function_exists('wp_safe_remote_get'))
	{
		$data_obj = wp_remote_get($url);
		
		return $data_obj;
	}
	
	try 
	{
		$data_obj = wp_safe_remote_get($url);
		
		return $data_obj;
	}
	catch(Exception $e)
	{
		$data_obj = wp_remote_get($url);
		
		return $data_obj;
	}
	
	return new WP_Error("Couldn't fetch the URL contents! Error 1004");
}


# Remove Emoji Chars
function removeEmoji($text)
{
	$clean_text = "";

	// Match Emoticons
	$regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
	$clean_text = preg_replace($regexEmoticons, '', $text);

	// Match Miscellaneous Symbols and Pictographs
	$regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
	$clean_text = preg_replace($regexSymbols, '', $clean_text);

	// Match Transport And Map Symbols
	$regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
	$clean_text = preg_replace($regexTransport, '', $clean_text);

	return $clean_text;
}


# Compress Text Function
function compress_text($buffer) 
{
	/* remove comments */
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	/* remove tabs, spaces, newlines, etc. */
	$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '	', '	'), '', $buffer);
	return $buffer;
}


function show_portfolio_item_details($options)
{	
	global $post;
	
	extract($options);
	
	?>
	<div class="large-<?php echo $has_gallery ? 5 : 12; ?> columns item-details">
		<h1><?php echo $secondary_title ? $secondary_title : $title; ?></h1>
		
		<div class="portfolio-content">
			<?php echo apply_filters('the_content', $post->post_content); ?>
		</div>
			
		<ul class="service-list">
			<?php if($categories_visible && has_term('', 'portfolio-category')): ?>
			<li class="item-categories"><?php _e('Category', TD); ?>: <?php the_terms($id, 'portfolio-category'); ?>
			<?php endif; ?>
			
			<?php if($client_name): ?>
			<li><?php _e('Client', TD); ?>: <span><?php echo $client_name; ?></span></li>
			<?php endif; ?>
			
			<?php if($finish_date): ?>
			<li><?php _e('When', TD); ?>: <span><?php echo date_i18n(get_data('portfolio_date_format'), strtotime($finish_date)); ?></span></li>
			<?php endif; ?>
		</ul>
		
		<?php if($do_share): ?>
		<div class="share-social">
			<div id="fb-root"></div>
			
			<strong><?php _e('Share this:', TD); ?></strong>
			
			<?php if($fb_share): ?>
			<div class="fb-like" data-href="<?php echo $permalink; ?>" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>
			<?php endif; ?>
			
			<?php if($tw_share): ?>
			<a href="https://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a>
			<?php endif; ?>
			
			<?php if($gp_share): ?>
			<div class="g-plusone" data-size="medium" data-annotation="none"></div>
			<?php endif; ?>
			
		</div>
		<?php endif; ?>
	</div>
	<?php
}


# Commenting
$lab_last_comment = '';

function lab_com($new_comment)
{
	global $lab_last_comment;
	
	$lab_last_comment = $new_comment;
	
	return PHP_EOL . '<!-- ' . $lab_last_comment . ' -->' . PHP_EOL;
}


function lab_com_close()
{
	global $lab_last_comment;
	
	$last = $lab_last_comment;
	
	$lab_last_comment = '';
	return PHP_EOL . '<!-- / End: ' . ($last ? $last : 'Of Element') . ' -->' . PHP_EOL;
}


# Compile Custom Skin
function custom_skin_compile($vars = array(), $file = 'css/custom-skin.less')
{
	$result = false;
	
	include_once("lib/less/lessc.inc.php");
	
	$file = THEMEDIR . 'assets/' . $file;
	$file_contents = file_get_contents($file);
	
	foreach($vars as $var => $value)
	{
		if( ! preg_match("/#[a-f0-9]{3}([a-f0-9]{3})?/", $value))
			$value = '#000';
			
		$file_contents = preg_replace("/(@{$var})\s*:\s*\{value\}/i", "$1: $value", $file_contents);
	}
	
	$less = new lessc;
	$css = $less->compile($file_contents);
	
	if($fp = fopen(str_replace(".less", ".css", $file), "w"))
	{
		fwrite($fp, $css);
		fclose($fp);
		
		$result = true;
	}
	
	return $result;
}