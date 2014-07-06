<?php
/*-----------------------------------*/
/*	Accordions
/*-----------------------------------*/
function vision_truethemes_accordion_wrap( $atts, $content = null ) {
   return '[raw]<dl class="vision-accordion">[/raw]' . do_shortcode($content) . '[raw]</dl>[/raw]';
}
add_shortcode('vision_accordion_set', 'vision_truethemes_accordion_wrap');



function vision_truethemes_accordion_content($atts, $content = null) {
  extract(shortcode_atts(array(
  'title' => '',
  'active' => '',
  ), $atts));
  
  if ($active == 'yes'){
  	$output = '[raw]<dt class="current">'.$title.'</dt><dd class="current">[/raw]' . do_shortcode($content) . '[raw]</dd>[/raw]';
  } else{
	$output = '[raw]<dt>'.$title.'</dt><dd>[/raw]' . do_shortcode($content) . '[raw]</dd>[/raw]';
  }
  
  return $output;
}
add_shortcode('vision_accordion', 'vision_truethemes_accordion_content');



/*-----------------------------------*/
/*	Buttons
/*-----------------------------------*/
function vision_truethemes_button($atts, $content = null) {
  extract(shortcode_atts(array(
  'size' => '',
  'color' => '',
  'url' => '',
  'target' => '',
	'lightbox_content' => '',
	'lightbox_description' => '',
  ), $atts));
  
	if(!empty($lightbox_content)) {
		$output = '<a href="'.$lightbox_content.'" class="'.$size.' '.$color.' vision-button" data-gal="prettyPhoto" title="'.$lightbox_description.'">' .do_shortcode($content). '</a>';
		
	} else {
		
  $output = '<a href="'.$url.'" class="'.$size.' '.$color.' vision-button" target="'.$target.'">' .do_shortcode($content). '</a>';
	
	};
	
  return $output;
}
add_shortcode('vision_button', 'vision_truethemes_button');



/*-----------------------------------*/
/*	Blog Posts
/*-----------------------------------*/
function vision_truethemes_blog_posts($atts, $content=null) {
extract(shortcode_atts(array(
'title'   => '',
'count'   => '3',
'character_count'   => '115',
'post_category'   => '',
), $atts));

$title = $title;
$count = $count;
$truethemes_count = 0; $truethemes_col = 0;



global $post;

if ($post_category != ''){
$myposts = new WP_Query('posts_per_page='.$count.'&offset=0&category_name='.$post_category.'');
}else{
$myposts = new WP_Query('posts_per_page='.$count.'&offset=0');
}

//@since version 2.0 declare $output, moved from bottom, so that $title works!
$output = '';

if (!empty($title)) {

	$output .= '[raw]<span class="section_title">'.$title.'</span>[/raw]';
	
	};

if ( $myposts->have_posts() ) : while ( $myposts->have_posts() ) : $myposts->the_post();

		$permalink = get_permalink($post->ID);
	
		
		//remove <!--nextpage--> and show only first page content
		$post_content = explode('<!--nextpage-->',$post->post_content);
		$post_content = (string)$post_content[0];
		$post_content = substr(strip_tags($post_content),0,$character_count);
		$post_content = rtrim($post_content); //remove space from end of string
		$post_content = str_replace("<br>","",$post_content);

    //remove all shortcodes from post content.
		$post_content = strip_shortcodes($post_content);		
		
		//@since version 2.0 moved $output declare to top, so that $title works!
		$output .= '<div class="article_preview">';
		$output .= '[raw]<strong><a href="'.$permalink.'">'.get_the_title().'</a></strong>[/raw]';
		$output .= '[raw]<p>'.$post_content.'...</p>[/raw]';
		$output .= '</div>';
		
endwhile; endif;	
wp_reset_postdata();
return $output;
}
add_shortcode('vision_blog_posts', 'vision_truethemes_blog_posts');


//@since version 2.0 The column css has been changed to .vision prefix, example .vision_one_sixth
/*-----------------------------------*/
/*	Columns
/*-----------------------------------*/
// 6
function vision_truethemes_one_sixth( $atts, $content = null ) {
   return '[raw]<div class="vision_one_sixth">[/raw]' . do_shortcode($content) . '[raw]</div>[/raw]';
}
add_shortcode('vision_one_sixth', 'vision_truethemes_one_sixth');


// 5
function vision_truethemes_one_fifth( $atts, $content = null ) {
   return '[raw]<div class="vision_one_fifth">[/raw]' . do_shortcode($content) . '[raw]</div>[/raw]';
}
add_shortcode('vision_one_fifth', 'vision_truethemes_one_fifth');


// 4
function vision_truethemes_one_fourth( $atts, $content = null ) {
   return '[raw]<div class="vision_one_fourth">[/raw]' . do_shortcode($content) . '[raw]</div>[/raw]';
}
add_shortcode('vision_one_fourth', 'vision_truethemes_one_fourth');


// 3
function vision_truethemes_one_third( $atts, $content = null ) {
   return '[raw]<div class="vision_one_third">[/raw]' . do_shortcode($content) . '[raw]</div>[/raw]';
}
add_shortcode('vision_one_third', 'vision_truethemes_one_third');


// 2
function vision_truethemes_one_half( $atts, $content = null ) {
   return '[raw]<div class="vision_one_half">[/raw]' . do_shortcode($content) . '[raw]</div>[/raw]';
}
add_shortcode('vision_one_half', 'vision_truethemes_one_half');


// 2/3
function vision_truethemes_two_thirds( $atts, $content = null ) {
   return '[raw]<div class="vision_two_thirds">[/raw]' . do_shortcode($content) . '[raw]</div>[/raw]';
}
add_shortcode('vision_two_thirds', 'vision_truethemes_two_thirds');


// divider
function vision_truethemes_column_break( $atts, $content = null ) {
   return '[raw]<div class="vision_column_clear">&nbsp;</div>[/raw]';
}
add_shortcode('vision_column_break', 'vision_truethemes_column_break');



/*-----------------------------------*/
/*	Content Boxes
/*-----------------------------------*/
function vision_truethemes_contentbox($atts, $content = null) {
  extract(shortcode_atts(array(
  'style' => '',
  'title' => '',
  ), $atts));
  
	$output = '<div class="vision-contentbox"><div class="vision-contentbox-title tt-cb-title-'.$style.'"><span>'.$title.'</span></div><div class="vision-contentbox-content tt-content-style-'.$style.'">' .do_shortcode($content). '</div></div>';
  
  return $output;
}
add_shortcode('vision_content_box', 'vision_truethemes_contentbox');



/*-----------------------------------*/
/*	Dividers
/*-----------------------------------*/
function vision_truethemes_dividers($atts, $content = null) {
  extract(shortcode_atts(array(
  'style' => '',
  ), $atts));
  
  $output = '<div class="hr '.$style.'">&nbsp;</div>';
  return $output;
}
add_shortcode('vision_divider', 'vision_truethemes_dividers');



/*-----------------------------------*/
/*	Dropcaps
/*-----------------------------------*/
function vision_truethemes_dropcaps( $atts, $content = null ) {
   extract(shortcode_atts(array(
  'style' => '',
  'color' => '',
  ), $atts));
  
  $output = '<span class="tt-dropcap-'.$color.'"><span class="tt-dropcap-'.$style.'">' .do_shortcode($content). '</span></span>';
  return $output;
}
add_shortcode('vision_dropcap', 'vision_truethemes_dropcaps');



/*-----------------------------------*/
/*	Email Encoder
/*-----------------------------------*/
function vision_truethemes_mailto( $atts , $content=null ) {

	$encodedmail = '';

    for ($i = 0; $i < strlen($content); $i++) $encodedmail .= "&#" . ord($content[$i]) . ';';

  return '<a href="mailto:'.$encodedmail.'">'.$encodedmail.'</a>';

}
add_shortcode('vision_mailto', 'vision_truethemes_mailto');



/*-----------------------------------*/
/*	Highlight Text
/*-----------------------------------*/
function vision_truethemes_highlight($atts, $content = null) {
  extract(shortcode_atts(array(
  'style' => '',
  'color' => '',
  ), $atts));
  
	$output = '<span class="tt-highlight highlight-'.$color.'"><span class="highlight-'.$style.'">' .do_shortcode($content). '</span></span>';
  
  return $output;
}
add_shortcode('vision_highlight', 'vision_truethemes_highlight');



/*-----------------------------------*/
/*	Icons
/*-----------------------------------*/
function vision_truethemesicons($atts, $content = null) {
  extract(shortcode_atts(array(
  'url' => '',
  'style' => '',
  'target' => '',
	'lightbox_content' => '',
	'lightbox_description' => '',
  ), $atts));
  
  if(!empty($url)){
  	$output = '<a href="'.$url.'" class="tt-icon-link tt-icon '.$style.'" target="'.$target.'">' .do_shortcode($content). '</a>';
  }
	
	if(empty($url)){
  	$output = '<p class="tt-icon '.$style.'">' .do_shortcode($content). '</p>';
  }
	
	if(!empty($lightbox_content)){
  	$output = '<a href="'.$lightbox_content.'" class="tt-icon-link tt-icon '.$style.'" data-gal="prettyPhoto" title="'.$lightbox_description.'">' .do_shortcode($content). '</a>';
  }	
  
  return $output;
}
add_shortcode('vision_icon', 'vision_truethemesicons');




/*-----------------------------------*/
/*	Icons - Minimal
/*-----------------------------------*/
function vision_truethemesicons_minimal($atts, $content = null) {
  extract(shortcode_atts(array(
  'url' => '',
  'style' => '',
  'heading' => '',
  'target' => '',
	'lightbox_content' => '',
	'lightbox_description' => '',
  ), $atts));
  
  if(!empty($url)){
  	$output = '<a href="'.$url.'" class="tt-mono-icon mono-'.$style.'" target="'.$target.'">' .do_shortcode($content). '</a>';
  }
	
	if(empty($url)){
  	$output = '<p class="tt-mono-icon mono-'.$style.'">' .do_shortcode($content). '</p>';
  }
	
	if(!empty($lightbox_content)){
  	$output = '<a href="'.$lightbox_content.'" class="tt-mono-icon mono-'.$style.'" data-gal="prettyPhoto" title="'.$lightbox_description.'">' .do_shortcode($content). '</a>';
  }	
  
  return $output;
}
add_shortcode('vision_minimal_icon', 'vision_truethemesicons_minimal');




/*-----------------------------------*/
/*	Notification Boxes
/*-----------------------------------*/
function vision_truethemes_notification($atts, $content = null) {
  extract(shortcode_atts(array(
  'style' => '',
  'font_size' => '13px',
  'closeable' => '',
  ), $atts));
  
  
  if ($closeable == 'true'){
  	$output = '<div class="vision-notification '.$style.' closeable"><div class="closeable-x"><p style="font-size:'.$font_size.';">' .do_shortcode($content). '</p></div></div>';
  } else{
	$output = '<div class="vision-notification '.$style.'"><p style="font-size:'.$font_size.';">' .do_shortcode($content). '</p></div>';
  }
  
  return $output;
}
add_shortcode('vision_notification', 'vision_truethemes_notification');




/*--------------------------------------*/
/*	Pricing Boxes
/*--------------------------------------*/

//styles: true-vision-pricing-style-1, true-vision-pricing-style-2

function vision_truethemes_pricing_box($atts, $content = null) {
  extract(shortcode_atts(array(
  'style' => '',
  'color' => '',
  'plan' => '',
  'currency' => '',
  'price' => '',
  'term' => '',
  'button_label' => '',
  'button_size' => '',
  'button_color' => '',
  'button_url' => '',
  'button_target' => '',
  ), $atts));
	
	if ($style == 'style-1'){
	$output = '<div class="true-vision-pricing-column true-vision-pricing-'.$style.'"><div class="true-vision-pricing-top tt-cb-title-'.$color.'">
	<h2>'.$plan.'</h2>
	<h1><sup>'.$currency.'</sup>'.$price.'</h1>
	<p>'.$term.'</p>
	</div>' 
	.do_shortcode($content). '<hr />
	<a href="'.esc_url( $button_url ).'" class="'.sanitize_html_class( $button_size ).' '.sanitize_html_class( $button_color ).' vision-button" target="'.esc_attr( $button_target ).'">' .$button_label. '</a>
	</div>';
	}
	
	if ($style == 'style-2'){
	$output = '<div class="true-vision-pricing-column true-vision-pricing-'.$style.'"><div class="true-vision-pricing-top tt-cb-title-'.$color.'">
	<h2>'.$plan.'</h2>
	</div>' 
	.do_shortcode($content). '<hr /><h1><sup>'.$currency.'</sup>'.$price.'</h1>
	<p>'.$term.'</p>
	<a href="'.esc_url( $button_url ).'" class="'.sanitize_html_class( $button_size ).' '.sanitize_html_class( $button_color ).' vision-button" target="'.esc_attr( $button_target ).'">' .$button_label. '</a>
	</div>';
	}
	
  
  return $output;
}
add_shortcode('vision_pricing_box', 'vision_truethemes_pricing_box');



/*-----------------------------------*/
/*	Pull-Quotes
/*-----------------------------------*/
function vision_truethemes_pullquotes($atts, $content = null) {
  extract(shortcode_atts(array(
  'style' => '',
  'align' => '',
  ), $atts));
  
	$output = '<div class="vision-pullquote-'.$style.' align'.$align.'">' .do_shortcode($content). '</div>';
  
  return $output;
}
add_shortcode('vision_pullquote', 'vision_truethemes_pullquotes');



/*-----------------------------------*/
/*	Social Icons
/*-----------------------------------*/
function vision_truethemes_social($atts, $content = null) {
  extract(shortcode_atts(array(
  'design' => '',
  'icon_style' => '',
  'twitter' => '',
  'facebook' => '',
  'dribbble' => '',
  'linkedin' => '',
  'vimeo' => '',
  'flickr' => '',
  'youtube' => '',
  'pinterest' => '',
  'google' => '',
  'rss' => '',
  'mail' => '',
  'skype' => '',
  'wordpress' => '',
  'instagram' => '',
  ), $atts));
  
  //check for round and add inline-css
  if ($icon_style == 'round') {
	$icon_output = ' style="font-weight:bold;"';
	$round_class = ' vs-round';
		}else{
			$icon_output = '';
			$round_class = '';
		}
  
  
  
	$output = '<ul class="vision-social vs-'.$design.$round_class.'">';
	
	if ($twitter != ''){
	$output .= '<li><a href="'.$twitter.'" class="ss-icon vs-twitter"><span'.$icon_output.'>&#xF611;</span></a></li>';
	}
	if ($facebook != ''){
	$output .= '<li><a href="'.$facebook.'" class="ss-icon vs-facebook"><span'.$icon_output.'>&#xF610;</span></a></li>';
	}
	if ($dribbble != ''){
	$output .= '<li><a href="'.$dribbble.'" class="ss-icon vs-dribbble"><span'.$icon_output.'>&#xF660;</span></a></li>';
	}
	if ($linkedin != ''){
	$output .= '<li><a href="'.$linkedin.'" class="ss-icon vs-linkedin"><span'.$icon_output.'>&#xF612;</span></a></li>';
	}
	if ($vimeo != ''){
	$output .= '<li><a href="'.$vimeo.'" class="ss-icon vs-vimeo"><span'.$icon_output.'>&#xF631;</span></a></li>';
	}
	if ($flickr != ''){
	$output .= '<li><a href="'.$flickr.'" class="ss-icon vs-flickr"><span'.$icon_output.'>&#xF640;</span></a></li>';
	}
	if ($youtube != ''){
	$output .= '<li><a href="'.$youtube.'" class="ss-icon vs-youtube"><span'.$icon_output.'>&#xF630;</span></a></li>';
	}
	if ($pinterest != ''){
	$output .= '<li><a href="'.$pinterest.'" class="ss-icon vs-pinterest"><span'.$icon_output.'>&#xF650;</span></a></li>';
	}
	if ($google != ''){
	$output .= '<li><a href="'.$google.'" class="ss-icon vs-google"><span'.$icon_output.'>&#xF613;</span></a></li>';
	}
	if ($rss != ''){
	$output .= '<li><a href="'.$rss.'" class="ss-icon vs-rss"><span'.$icon_output.'>&#xE310;</span></a></li>';
	}
	if ($mail != ''){
	$output .= '<li><a href="'.$mail.'" class="ss-icon vs-mail"><span'.$icon_output.'>&#x2709;</span></a></li>';
	}
	if ($skype != ''){
	$output .= '<li><a href="'.$skype.'" class="ss-icon vs-skype"><span'.$icon_output.'>&#xF6A0;</span></a></li>';
	}
	if ($wordpress != ''){
	$output .= '<li><a href="'.$wordpress.'" class="ss-icon vs-wordpress"><span'.$icon_output.'>&#xF621;</span></a></li>';
	}
	if ($instagram != ''){
	$output .= '<li><a href="'.$instagram.'" class="ss-icon vs-instagram"><span'.$icon_output.'>&#xF641;</span></a></li>';
	}
	
	$output .= '</ul>';
	
	
	
	
  
  return $output;
}
add_shortcode('vision_social', 'vision_truethemes_social');


/*-----------------------------------*/
/*	Tabs
/*-----------------------------------*/
function vision_truethemes_tabs_wrap($atts, $content = null) {
  extract(shortcode_atts(array(
  'style' => '',
  ), $atts));
  
  if ($style == 'vertical'){
  	$output = '[raw]<dl class="vision-tabs-vertical">[/raw]' .do_shortcode($content). '[raw]</dl>[/raw]';
  } else{
	$output = '[raw]<dl class="vision-tabs-horizontal">[/raw]' .do_shortcode($content). '[raw]</dl>[/raw]';  
  }
  
  return $output;
}
add_shortcode('vision_tabset', 'vision_truethemes_tabs_wrap');



function vision_truethemes_tabs_content($atts, $content = null) {
  extract(shortcode_atts(array(
  'title' => '',
  'active' => '',
  ), $atts));
  
	if($_GET && isset($_GET['tab'])){
	/*
	Added Sept 25 2013. This makes the tabs linkable, meaning that links can be set that display a specific tab on the page regardless of the active tab on the post.
	*/
		$active = 'no';
		if($_GET['tab'] == $title){
			$active = 'yes';
		}
	}  
  
  if ($active == 'yes'){
  	$output = '[raw]<dt class="current">'.$title.'</dt><dd class="current">[/raw]' . do_shortcode($content) . '[raw]</dd>[/raw]';
  } else{
	$output = '[raw]<dt>'.$title.'</dt><dd>[/raw]' . do_shortcode($content) . '[raw]</dd>[/raw]';
  }
  
  return $output;
}
add_shortcode('vision_tab', 'vision_truethemes_tabs_content');



/*-----------------------------------*/
/*	Testimonials
/*-----------------------------------*/
function vision_truethemes_testimonial_wrap( $atts, $content = null ) {
   return '[raw]<div class="vision-testimonials">[/raw]' . do_shortcode($content) . '[raw]</div>[/raw]';
}
add_shortcode('vision_testimonial_set', 'vision_truethemes_testimonial_wrap');


function vision_truethemes_testimonial_content($atts, $content = null) {
  extract(shortcode_atts(array(
  'client' => '',
  ), $atts));
  

	$output = '[raw]<div class="vision-testimonial"><blockquote>' . do_shortcode($content) . '</blockquote><strong class="vision-client_identity">'.$client.'</strong></div>[/raw]';
  
  return $output;
}
add_shortcode('vision_testimonial', 'vision_truethemes_testimonial_content');



/*-----------------------------------*/
/*	Text Styles
/*-----------------------------------*/
function vision_truethemes_text($atts, $content = null) {
  extract(shortcode_atts(array(
  'style' => ''
  ), $atts));
  
  $output = '<div class="'.$style.'"><p>' .do_shortcode($content). '</p></div>';
  return $output;
}
add_shortcode('vision_text', 'vision_truethemes_text');


?>