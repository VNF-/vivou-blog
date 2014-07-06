<?php
/*
* @since version 2.0
* This file contents old shortcodes, all vision shortcodes are renamed with a prefix of the word vision.
* This will prevent conflict with theme shortcode name.
* All new shortcode usage and function will remain the same, only the shortcode names and functions names are changed.
* Old shortcodes has been modified to exercute new shortcode.
* IMPORTANT, do not remove this file or any codes from this file to remain backward compatibility.
*/


/*-----------------------------------------------------*/
/*	Accordions
/*-----------------------------------------------------*/

function v_truethemes_accordion_wrap( $atts, $content = null ) {
   $new_shortcode = "[vision_accordion_set]".do_shortcode($content)."[/vision_accordion_set]";
   $output = do_shortcode("{$new_shortcode}");
   return $output;
}
add_shortcode('accordion_set', 'v_truethemes_accordion_wrap');


function v_truethemes_accordion_content($atts, $content = null) {
  extract(shortcode_atts(array(
  'title' => '',
  'active' => '',
  ), $atts));

  $new_shortcode = "[vision_accordion title='{$title}' active='{$active}']".do_shortcode($content)."[/vision_accordion]";
  $output = do_shortcode("{$new_shortcode}");

  return $output;
}
add_shortcode('accordion', 'v_truethemes_accordion_content');



/*-----------------------------------------------------*/
/*	Buttons
/*-----------------------------------------------------*/
function v_truethemes_button($atts, $content = null) {
  extract(shortcode_atts(array(
  'size' => '',
  'color' => '',
  'url' => '',
  'target' => '',
	'lightbox_content' => '',
	'lightbox_description' => '',
  ), $atts));
  
  $new_shortcode = "[vision_button url='{$url}' class='button' size='{$size}' color='{$color}' target='{$target}' lightbox_content='{$lightbox_content}' lightbox_description='{$lightbox_description}']".do_shortcode($content)."[/vision_button]";
  $output = do_shortcode("{$new_shortcode}");

  return $output;
}
add_shortcode('button', 'v_truethemes_button');



/*-----------------------------------------------------*/
/*	Blog Posts
/*-----------------------------------------------------*/
function v_truethemes_blog_posts($atts, $content=null) {
extract(shortcode_atts(array(
'title'   => '',
'count'   => '3',
'character_count'   => '115',
'post_category'   => '',
), $atts));

  $new_shortcode = "[vision_blog_posts title='{$title}' count='{$count}' character_count='{$character_count}' post_category='{$post_category}']";
  $output = do_shortcode("{$new_shortcode}");

  return $output;
}
add_shortcode('blog_posts', 'v_truethemes_blog_posts');



/*-----------------------------------------------------*/
/*	Columns
/*-----------------------------------------------------*/
// 6
function v_truethemes_one_sixth( $atts, $content = null ) {
  $new_shortcode = "[vision_one_sixth]".do_shortcode($content)."[/vision_one_sixth]";
  $output = do_shortcode("{$new_shortcode}");
  return $output;
}
add_shortcode('one_sixth', 'v_truethemes_one_sixth');


// 5
function v_truethemes_one_fifth( $atts, $content = null ) {
  $new_shortcode = "[vision_one_fifth]".do_shortcode($content)."[/vision_one_fifth]";
  $output = do_shortcode("{$new_shortcode}");
  return $output;
}
add_shortcode('one_fifth', 'v_truethemes_one_fifth');


// 4
function v_truethemes_one_fourth( $atts, $content = null ) {
  $new_shortcode = "[vision_one_fourth]".do_shortcode($content)."[/vision_one_fourth]";
  $output = do_shortcode("{$new_shortcode}");
  return $output;
}
add_shortcode('one_fourth', 'v_truethemes_one_fourth');


// 3
function v_truethemes_one_third( $atts, $content = null ) {
  $new_shortcode = "[vision_one_third]".do_shortcode($content)."[/vision_one_third]";
  $output = do_shortcode("{$new_shortcode}");
  return $output;
}
add_shortcode('one_third', 'v_truethemes_one_third');


// 2
function v_truethemes_one_half( $atts, $content = null ) {
  $new_shortcode = "[vision_one_half]".do_shortcode($content)."[/vision_one_half]";
  $output = do_shortcode("{$new_shortcode}");
  return $output;
}
add_shortcode('one_half', 'v_truethemes_one_half');


// 2/3
function v_truethemes_two_thirds( $atts, $content = null ) {
  $new_shortcode = "[vision_two_thirds]".do_shortcode($content)."[/vision_two_thirds]";
  $output = do_shortcode("{$new_shortcode}");
  return $output;
}
add_shortcode('two_thirds', 'v_truethemes_two_thirds');


// divider
function v_truethemes_column_break( $atts, $content = null ) {
  $new_shortcode = "[vision_column_break]".do_shortcode($content)."[/vision_column_break]";
  $output = do_shortcode("{$new_shortcode}");
  return $output;
}
add_shortcode('column_break', 'v_truethemes_column_break');



/*-----------------------------------------------------*/
/*	Content Boxes
/*-----------------------------------------------------*/
function vision_old_truethemes_contentbox($atts, $content = null) {
  extract(shortcode_atts(array(
  'style' => '',
  'title' => '',
  ), $atts));
  
  $new_shortcode = "[vision_content_box style='{$style}' title='{$title}']".do_shortcode($content)."[/vision_content_box]";
  $output = do_shortcode("{$new_shortcode}");
  return $output;
}
add_shortcode('content_box', 'vision_old_truethemes_contentbox');



/*-----------------------------------------------------*/
/*	Dividers
/*-----------------------------------------------------*/
function v_truethemes_dividers($atts, $content = null) {
  extract(shortcode_atts(array(
  'style' => '',
  ), $atts));
  
  $new_shortcode = "[vision_divider style='{$style}']";
  $output = do_shortcode("{$new_shortcode}");
  return $output;
}
add_shortcode('divider', 'v_truethemes_dividers');




/*-----------------------------------------------------*/
/*	Dropcaps
/*-----------------------------------------------------*/
function v_truethemes_dropcaps( $atts, $content = null ) {
   extract(shortcode_atts(array(
  'style' => '',
  'color' => '',
  ), $atts));
  
  $new_shortcode = "[vision_dropcap style='{$style}' color='{$color}']".do_shortcode($content)."[/vision_dropcap]";
  $output = do_shortcode("{$new_shortcode}");
  return $output;
}
add_shortcode('dropcap', 'v_truethemes_dropcaps');


/*-----------------------------------------------------*/
/*	Email Encoder
/*-----------------------------------------------------*/
function vision_old_truethemes_mailto( $atts , $content=null ) {

  $new_shortcode = "[vision_mailto]".do_shortcode($content)."[/vision_mailto]";
  $output = do_shortcode("{$new_shortcode}");
  return $output;

}
add_shortcode('mailto', 'vision_old_truethemes_mailto');



/*-----------------------------------------------------*/
/*	Highlight Text
/*-----------------------------------------------------*/
function vision_old_truethemes_highlight($atts, $content = null) {
  extract(shortcode_atts(array(
  'style' => '',
  'color' => '',
  ), $atts));
  
  $new_shortcode = "[vision_highlight color='{$color}' style='{$style}']".do_shortcode($content)."[/vision_highlight]";
  $output = do_shortcode("{$new_shortcode}");
  return $output;
}
add_shortcode('highlight', 'vision_old_truethemes_highlight');



/*-----------------------------------------------------*/
/*	Icons
/*-----------------------------------------------------*/
function v_truethemesicons($atts, $content = null) {
  extract(shortcode_atts(array(
  'url' => '',
  'style' => '',
  'target' => '',
	'lightbox_content' => '',
	'lightbox_description' => '',
  ), $atts));
  
  $new_shortcode = "[vision_icon style='{$style}' url='{$url}' target='{$target}' lightbox_content='{$lightbox_content}' lightbox_description='{$lightbox_description}']".do_shortcode($content)."[/vision_icon]";
  $output = do_shortcode("{$new_shortcode}");
  return $output;
}
add_shortcode('icon', 'v_truethemesicons');




/*-----------------------------------------------------*/
/*	Icons - Minimal
/*-----------------------------------------------------*/
function v_truethemesicons_minimal($atts, $content = null) {
  extract(shortcode_atts(array(
  'url' => '',
  'style' => '',
  'heading' => '',
  'target' => '',
	'lightbox_content' => '',
	'lightbox_description' => '',
  ), $atts));
  
  $new_shortcode = "[vision_minimal_icon style='{$style}' url='{$url}' target='{$target}' lightbox_content='{$lightbox_content}' lightbox_description='{$lightbox_description}']".do_shortcode($content)."[/vision_minimal_icon]";
  $output = do_shortcode("{$new_shortcode}");
  return $output;
}
add_shortcode('minimal_icon', 'v_truethemesicons_minimal');




/*-----------------------------------------------------*/
/*	Notification Boxes
/*-----------------------------------------------------*/
function v_truethemes_notification($atts, $content = null) {
  extract(shortcode_atts(array(
  'style' => '',
  'font_size' => '13px',
  'closeable' => '',
  ), $atts));
  
  
  $new_shortcode = "[vision_notification style='{$style}' font_size='{$font_size}' closeable='{$closeable}']".do_shortcode($content)."[/vision_notification]";
  $output = do_shortcode("{$new_shortcode}");
  return $output;
}
add_shortcode('notification', 'v_truethemes_notification');


/*-----------------------------------------------------*/
/*	Tabs
/*-----------------------------------------------------*/
function v_truethemes_tabs_wrap($atts, $content = null) {
  extract(shortcode_atts(array(
  'style' => '',
  ), $atts));
  
  $new_shortcode = "[vision_tabset style='{$style}']".do_shortcode($content)."[/vision_tabset]";
  $output = do_shortcode("{$new_shortcode}");
  return $output;
}
add_shortcode('tabset', 'v_truethemes_tabs_wrap');



function v_truethemes_tabs_content($atts, $content = null) {
  extract(shortcode_atts(array(
  'title' => '',
  'active' => '',
  ), $atts));
  
  $new_shortcode = "[vision_tab title='{$title}' active='{$active}']".do_shortcode($content)."[/vision_tab]";
  $output = do_shortcode("{$new_shortcode}");
  return $output;
}
add_shortcode('tab', 'v_truethemes_tabs_content');



/*-----------------------------------------------------*/
/*	Testimonials
/*-----------------------------------------------------*/
function v_truethemes_testimonial_wrap( $atts, $content = null ) {
  
  $new_shortcode = "[vision_testimonial_set]".do_shortcode($content)."[/vision_testimonial_set]";
  $output = do_shortcode("{$new_shortcode}");
  return $output;

}
add_shortcode('testimonial_set', 'v_truethemes_testimonial_wrap');



function v_truethemes_testimonial_content($atts, $content = null) {
  extract(shortcode_atts(array(
  'client' => '',
  ), $atts));
  
  $new_shortcode = "[vision_testimonial client='{$client}']".do_shortcode($content)."[/vision_testimonial]";
  $output = do_shortcode("{$new_shortcode}");
  return $output;
  
}
add_shortcode('testimonial', 'v_truethemes_testimonial_content');



/*-----------------------------------------------------*/
/*	Text Styles
/*-----------------------------------------------------*/
function v_truethemes_text($atts, $content = null) {
  extract(shortcode_atts(array(
  'style' => ''
  ), $atts));
  
  $new_shortcode = "[vision_text style='{$style}']".do_shortcode($content)."[/vision_text]";
  $output = do_shortcode("{$new_shortcode}");
  return $output;
  
}
add_shortcode('text', 'v_truethemes_text');

?>