<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{


/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

// Set the Options Array
global $of_options;
$of_options = array();

$of_options[] = array( 	"name" 		=> "Home Settings",
						"type" 		=> "heading"
				);
				
$of_options[] = array( 	"name" 		=> "Enable Frontpage",
						"desc" 		=> "When you check this box, you will use the structured homepage modules (<strong>Homepage Layout</strong>) otherwise in your frontpage will appear posts from the blog.",
						"id" 		=> "use_frontpage",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);

$frontpage_widgets = array(
			"visible" => array (
				"placebo"           => "placebo",
				"frontpage-quote"   => "Text Quote",
				"portfolio-items"   => "Portfolio Items",
				"blog-and-contact"  => "Blog &amp; Contact",
			),
			
			"hidden" => array (
				"placebo"           => "placebo",
				"client-logos"      => "Client Logos",
				"frontpage-html"    => "Custom HTML"
			),
);
				
$of_options[] = array( 	"name" 		=> "Homepage Layout",
						"desc" 		=> "Organize how you want the layout to appear on the homepage.",
						"id" 		=> "homepage_blocks",
						"std" 		=> $frontpage_widgets,
						"type" 		=> "sorter"
				);
				
$of_options[] = array( 	"name" 		=> "Text Quote",
						"desc" 		=> "Mainly used to describe the site slogan, or used as portfolio title.",
						"id" 		=> "frontpage_text_quote",
						"std" 		=> "Your custom quote goes here...",
						"type" 		=> "textarea"
				);
				
$of_options[] = array( 	"name" 		=> "Blog Widget",
						"desc" 		=> "Blog widget title.",
						"id" 		=> "frontpage_blog_title",
						"std" 		=> "Blog",
						"type" 		=> "text"
				);
				
$of_options[] = array( 	"desc" 		=> "Blog posts count.",
						"id" 		=> "frontpage_blog_posts_count",
						"std" 		=> 4,
						"type" 		=> "select",
						"options" 	=> array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10)
				);
				
$of_options[] = array( 	"name" 		=> "Contact Form Widget",
						"desc" 		=> "Contact form widget title.",
						"id" 		=> "frontpage_contact_title",
						"std" 		=> "Write us",
						"type" 		=> "text"
				);
				
$of_options[] = array( 	"name" 		=> "Custom HTML Content",
						"desc" 		=> "Add your own HTML content to display in homepage. Also you can use shortcodes.",
						"id" 		=> "frontpage_custom_html",
						"std" 		=> "",
						"type" 		=> "textarea"
				);

$of_options[] = array( 	"name" 		=> "General Settings",
						"type" 		=> "heading"
				);
				
$of_options[] = array( 	"name" 		=> "Header Type",
						"desc" 		=> "Choose between two types of headers.",
						"id" 		=> "header_type",
						"std" 		=> "Logo on the left",
						"type" 		=> "select",
						"options" 	=> array("Logo on the left", "Centered logo")
				);

$of_options[] = array(  "name"   	=> "Site Logo",
						"desc"   	=> "Enter the text that will appear as logo.",
						"id"   		=> "logo_text",
						"std"   	=> get_bloginfo('title'),
						"type"   	=> "text"
					);

$of_options[] = array(
						"desc"   	=> "Uploaded Logo",
						"id"   		=> "use_uploaded_logo",
						"std"   	=> 0,
						"folds"  	=> 1,
						"on"  		=> "Yes",
						"off"  		=> "No",
						"type"   	=> "switch"
					);

$of_options[] = array(	"name" 		=> "Custom Logo Upload",
						"desc" 		=> "Upload your custom logo image if you want to use it instead of the default site title text. You can also input the logo URL to this field.",
						"id" 		=> "custom_logo_image",
						"std" 		=> "",
						"type" 		=> "media",
						"mod" 		=> "min",
						"fold" 		=> "use_uploaded_logo"
					);

$of_options[] = array(
						"desc" 		=> "Responsive Logo Image, generally used for Retina Displays to show smoother pixels. Retina logo should be the double width/height of normal logo.",
						"id" 		=> "custom_logo_image_responsive",
						"std" 		=> "",
						"type" 		=> "media",
						"mod" 		=> "min",
						"fold" 		=> "use_uploaded_logo"
					);
				
$of_options[] = array( 	"name" 		=> "Sidebar Menu",
						"desc" 		=> "Enable or disable sidebar menu.",
						"id" 		=> "sidebar_menu_enabled",
						"std" 		=> 1,
						"on" 		=> "Enable",
						"off" 		=> "Disable",
						"type" 		=> "switch",
						"folds"		=> true
					);
					
$url =  ADMIN_DIR . 'assets/images/';
				
$of_options[] = array( 	"name" 		=> "Sidebar Menu Icon Position",
						"desc" 		=> "Select where sidebar menu icon is placed in the menu.",
						"id" 		=> "sidebar_menu_icon_position",
						"std" 		=> 0,
						"on" 		=> "Left",
						"off" 		=> "Right",
						"type" 		=> "switch",
						"fold"		=> "sidebar_menu_enabled"
				);
				
$of_options[] = array( 	"name" 		=> "Sidebar Menu Position",
						"desc" 		=> "Select where sidebar menu is placed in the container.",
						"id" 		=> "sidebar_menu_position",
						"std" 		=> 0,
						"on" 		=> "Left",
						"off" 		=> "Right",
						"type" 		=> "switch",
						//"fold"		=> "sidebar_menu_enabled"
				);

$of_options[] = array( 	"name" 		=> "Social Networks",
						"desc" 		=> "Facebook",
						"id" 		=> "footer_social_fb",
						"std" 		=> "",
						"plc"		=> "http://facebook.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Twitter",
						"id" 		=> "footer_social_tw",
						"std" 		=> "",
						"plc"		=> "http://twitter.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "LinkedIn",
						"id" 		=> "footer_social_lin",
						"std" 		=> "",
						"plc"		=> "http://linkedin.com/in/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "YouTube",
						"id" 		=> "footer_social_yt",
						"std" 		=> "",
						"plc"		=> "http://youtube.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Vimeo",
						"id" 		=> "footer_social_vm",
						"std" 		=> "",
						"plc"		=> "http://vimeo.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Dribble",
						"id" 		=> "footer_social_drb",
						"std" 		=> "",
						"plc"		=> "http://dribbble.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Instagram",
						"id" 		=> "footer_social_ig",
						"std" 		=> "",
						"plc"		=> "http://instagram.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Dribble",
						"id" 		=> "footer_social_pi",
						"std" 		=> "",
						"plc"		=> "http://pinterest.com/username",
						"type" 		=> "text"
				);
				

$social_networks_ordering = array(
			"visible" => array (
				"placebo"	=> "placebo",
				"fb"   	 	=> "Facebook",
				"tw"   	 	=> "Twitter",
			),
			
			"hidden" => array (
				"placebo"   => "placebo",
				"lin"       => "LinkedIn",
				"yt"        => "YouTube",
				"vm"        => "Vimeo",
				"drb"       => "Dribbble",
				"ig"        => "Instagram",
				"pi"        => "Pinterest",
			),
);
				
$of_options[] = array( 	"name" 		=> "Social Networks Ordering",
						"desc" 		=> "Set the appearing order of social networks in the footer",
						"id" 		=> "footer_social_order",
						"std" 		=> $social_networks_ordering,
						"type" 		=> "sorter"
				);
				
$of_options[] = array( 	"name" 		=> "Tracking Code",
						"desc" 		=> "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template.",
						"id" 		=> "google_analytics",
						"std" 		=> "",
						"type" 		=> "textarea"
				);
				
$of_options[] = array( 	"name" 		=> "Footer Text",
						"desc" 		=> "Copyrights text in the footer.",
						"id" 		=> "footer_text",
						"std" 		=> "&copy; Calcium WordPress Theme.",
						"type" 		=> "textarea"
				);

if(class_exists('acf'))
{
				
$of_options[] = array( 	"name" 		=> "Advanced Custom Fields",
						"desc" 		=> "Enable Advanced Custom Fields Plugin in the admin menu (if you need to edit anything).",
						"id" 		=> "acf_lite_disable",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);
}

				
$of_options[] = array( 	"name" 		=> "Blog",
						"type" 		=> "heading"
				);
				
$of_options[] = array( 	"name" 		=> "Toggle Blog Functionality",
						"desc" 		=> "Breadcrumb (Shown on posts listing)",
						"id" 		=> "blog_breadcrumb",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);
				
$of_options[] = array( 	"desc" 		=> "Thumbnails (Post featured image)",
						"id" 		=> "blog_thumbnails",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);
				
$of_options[] = array( 	"desc" 		=> "Author Info (Shown on single post)",
						"id" 		=> "blog_author_info",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);
				
$of_options[] = array( 	"desc" 		=> "Category (Shown everywhere)",
						"id" 		=> "blog_category",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);
				
$of_options[] = array( 	"desc" 		=> "Tags (Shown on single post)",
						"id" 		=> "blog_tags",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"name" 		=> "Thumbnail Height",
						"desc" 		=> "Featured image default thumbnail height. This setting is not applied when using post format <strong>Image</strong>.",
						"id" 		=> "blog_thumbnail_height",
						"std" 		=> "",
						"plc"		=> "Default is applied: 220",
						"type" 		=> "text"
				);
				
$of_options[] = array( 	"name"		=> "Blog Post Content",
						"desc" 		=> "View blog post with full content like its reading as single post.",
						"id" 		=> "blog_view_more",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);
				
$of_options[] = array( 	"name" 		=> "Portfolio",
						"type" 		=> "heading"
				);
					
$of_options[] = array( 	"name" 		=> "Columns Layout",
						"desc" 		=> "Choose your preferred columns layout for portfolio items.",
						"id" 		=> "portfolio_columns",
						"std" 		=> "4",
						"type" 		=> "images",
						"options" 	=> array(
							'4'	 	=> $url . '4-col-portfolio.png',
							'3' 	=> $url . '3-col-portfolio.png',
							'2' 	=> $url . '2-col-portfolio.png',
						)
				);
					
$of_options[] = array( 	"name" 		=> "Item Details Layout",
						"desc" 		=> "Select portfolio item details layout to display.",
						"id" 		=> "portfolio_item_layout",
						"std" 		=> "left",
						"type" 		=> "images",
						"options" 	=> array(
							'left' 	=> $url . '2cl.png',
							'right' => $url . '2cr.png',
							'top' 	=> $url . '2ct.png',
							'bottom'=> $url . '2cb.png',
						)
				);
				
$of_options[] = array( 	"name" 		=> "Item Details",
						"desc" 		=> "There are two choies, view portfolio item details with dropdown or with direct link.",
						"id" 		=> "portfolio_linking_type",
						"std" 		=> "Open Info in Dropdown",
						"type" 		=> "select",
						"options" 	=> array("Open Info in Dropdown", "Direct Link to Item")
				);
				
$of_options[] = array( 	"name" 		=> "Pagination Settings",
						"desc" 		=> "Select the number of portfolio rows to display on frontpage.",
						"id" 		=> "portfolio_rows",
						"std" 		=> 4,
						"type" 		=> "select",
						"options" 	=> array(1, 2, 3, 4, 5, 6)
				);
				
$of_options[] = array( 
						"desc" 		=> "<strong>Portfolio Pagination Type</strong><br />Choose between pagination types for the portfolio items.",
						"id" 		=> "portfolio_pagination_type",
						"std" 		=> 2,
						"type" 		=> "radio",
						"options" 	=> array(1 => "Normal", 2 => "Endless Scroll")
				);
				
$of_options[] = array( 	"name" 		=> "Gallery Auto Switch",
						"desc" 		=> "Portfolio item images time to auto-switch images in seconds.",
						"id" 		=> "portfolio_autoswitch",
						"std" 		=> 5,
						"type" 		=> "select",
						"options" 	=> array(2, 3, 4, 5, 6, 7, 8, 9, 10, "Disable Autoswitch")
				);

$of_options[] = array( 	"name" 		=> "Sharing",
						"desc" 		=> "Check social networks to allow sharing of portfolio items. Check none to disable.",
						"id" 		=> "portfolio_share_networks",
						"std" 		=> array("facebook","twitter"),
						"type" 		=> "multicheck",
						"options" 	=> array(
							"facebook" => "Facebook",
							"twitter" => "Twitter",
							"google" => "Google+"
						)
				);
				
$of_options[] = array( 	"name" 		=> "Likes",
						"desc" 		=> "Enable or disable portfolio item likes feature.",
						"id" 		=> "portfolio_likes",
						"std" 		=> 1,
						"type" 		=> "switch"
				);
				
$of_options[] = array( 	"name" 		=> "Category Filtering",
						"desc" 		=> "Enable or disable portfolio gallery filtering feature.",
						"id" 		=> "portfolio_filter",
						"std" 		=> 1,
						"type" 		=> "switch",
						"folds"		=> 1
				);
				
$of_options[] = array( 	"name" 		=> "Category Filter Type",
						"desc" 		=> "Select between two types/positions of category filter.",
						"id" 		=> "portfolio_category_filter_type",
						"std" 		=> 5,
						"type" 		=> "select",
						"options" 	=> array("Overlay Categories", "Upper List of Categories"),
						"fold"		=> "portfolio_filter"
				);
				
$of_options[] = array( 	"name" 		=> "Count Items",
						"desc" 		=> "Show items count for each category",
						"id" 		=> "portfolio_count_items",
						"std" 		=> 1,
						"type" 		=> "switch",
						"fold"		=> "portfolio_filter"
				);
				
$of_options[] = array( 	"name" 		=> "Item Category",
						"desc" 		=> "Show or hide portfolio categories inside an item.",
						"id" 		=> "portfolio_categories_visible",
						"std" 		=> 1,
						"type" 		=> "switch"
				);

$of_options[] = array( 	"name" 		=> "Date Format",
						"desc" 		=> "Date format for 'When' field, enter your own format based on PHP <a href='http://php.net/date' target='_blank'>date format</a>.",
						"id" 		=> "portfolio_date_format",
						"std" 		=> "F Y",
						"plc"		=> "(PHP Date Format)",
						"type" 		=> "text"
				);
				
$of_options[] = array( 	"name" 		=> "Styling Options",
						"type" 		=> "heading"
				);
				
$of_options[] = array( 	"name" 		=> "Skin Type",
						"desc" 		=> "Select default skin to use for Calcium theme.",
						"id" 		=> "skin_type",
						"std" 		=> "Light",
						"type" 		=> "select",
						"options" 	=> array("Light", "Dark")
				);
				
$is_writtable_custom_skin = '';

if( ! is_writable(THEMEDIR . 'assets/css/custom-skin.less'))
{
	$is_writtable_custom_skin = '<div title="Location:'."\n".THEMEASSETS.'css/custom-skin.css" style="color: #c00; padding-bottom: 10px;">Warning: <strong>custom-skin.css</strong> is not writable, skin cannot be compiled!</div> ';
}
				
$of_options[] = array( 	"name" 		=> "Custom Hover Color",
						"desc" 		=> "Create custom hover color for portfolio items and relevant theme colors.",
						"id" 		=> "skin_custom",
						"std" 		=> 0,
						"type" 		=> "switch",
						"on"		=> "Yes",
						"off"		=> "No",
						"folds"		=> true
				);
				
$of_options[] = array( 	"name" 		=> "Link Background Color",
						"desc" 		=> $is_writtable_custom_skin . "Main color (named as color 1).",
						"id" 		=> "skin_color_link_color_hover",
						"std" 		=> "#ffba00",
						"type" 		=> "color",
						"fold"		=> "skin_custom"
				);
				
$of_options[] = array( 	"name" 		=> "Link Text Color",
						"desc" 		=> "Main color (named as color 2).",
						"id" 		=> "skin_color_link_color_hover_text",
						"std" 		=> "#ffffff",
						"type" 		=> "color",
						"fold"		=> "skin_custom"
				);
				
$of_options[] = array( 	"name" 		=> "Primary Font",
						"desc" 		=> "Choose primary font to use with Calcium theme.",
						"id" 		=> "primary_font",
						"std" 		=> "Playfair Display",
						"type" 		=> "select_google_font",
						"preview" 	=> array(
										"text" => "This is sample text how this font looks like!",
										"size" => "22px"
						),
						"options" 	=> array(
										"none"                => "Select a font",
										"Playfair Display"    => "Playfair Display",
										"Roboto"              => "Roboto",
										"Montserrat"          => "Montserrat",
										"Open Sans"           => "Open Sans",
						)
				);

$of_options[] = array(	"name"   	=> "Use Custom Font",
						"desc"   	=> "You can load different font style from <a href='http://www.google.com/fonts/' target='_blank'>Google Webfonts</a>",
						"id"   		=> "use_custom_font",
						"std"   	=> 0,
						"on"  		=> "Yes",
						"off"  		=> "No",
						"type"   	=> "switch",
						"folds"  	=> 1,
				);

$of_options[] = array( 	"name" 		=> "Font Family",
						"desc" 		=> "Enter font family name as given on Google Webfonts (without ending semicolon ;).",
						"id" 		=> "custom_font_family",
						"std" 		=> "",
						"plc"		=> "Example: 'Montserrat', serif",
						"type" 		=> "text",
						"fold"		=> "use_custom_font"
				);

$of_options[] = array( 	"name" 		=> "Font Family",
						"desc" 		=> "Enter font URL path given from Google Webfonts.",
						"id" 		=> "custom_font_url",
						"std" 		=> "",
						"plc"		=> "http://fonts.googleapis.com/css?family=Font-Name",
						"type" 		=> "text",
						"fold"		=> "use_custom_font"
				);

$of_options[] = array( 	"name" 		=> "Custom CSS",
						"desc" 		=> "Add your own custom CSS to replace or add theme styles.",
						"id" 		=> "custom_css",
						"std" 		=> "",
						"plc"		=> ".some-class { font-size: 12px; } ...",
						"type" 		=> "textarea"
				);
						
// Backup Options
$of_options[] = array( 	"name" 		=> "Backup Options",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-slider.png"
				);
				
$of_options[] = array( 	"name" 		=> "Backup and Restore Options",
						"id" 		=> "of_backup",
						"std" 		=> "",
						"type" 		=> "backup",
						"desc" 		=> 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
				);
				
$of_options[] = array( 	"name" 		=> "Transfer Theme Options Data",
						"id" 		=> "of_transfer",
						"std" 		=> "",
						"type" 		=> "transfer",
						"desc" 		=> 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".',
				);
				
	}//End function: of_options()
}//End chack if function exists: of_options()
?>
