<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

# Laborator Menu Page
add_action('admin_menu', 'laborator_menu_page');

function laborator_menu_page()
{
	add_menu_page('Laborator', 'Laborator', 'edit_theme_options', 'laborator_options', 'laborator_main_page');
	
	if(get('page') == 'laborator_options')
	{
		wp_redirect( admin_url('themes.php?page=optionsframework') );
	}
}

function laborator_options()
{
	wp_redirect( admin_url('themes.php?page=optionsframework') );
}


# Enqueue Scritps
add_action('wp_enqueue_scripts', 'laborator_wp_enqueue_scripts');
add_action('wp_footer', 'laborator_wp_enqueue_scripts_custom');
add_action('wp_print_scripts', 'laborator_wp_print_scripts');
add_action('admin_print_styles', 'laborator_admin_print_styles');


add_action('admin_enqueue_scripts', 'laborator_admin_enqueue_scripts');

function laborator_wp_enqueue_scripts()
{	
	$font_overrides = array(
		"Playfair Display"	=> "Playfair+Display:400,700,900,400italic,700italic,900italic",
		"Roboto"			=> "Roboto:400,700,400italic,700italic",
		"Montserrat"		=> "Montserrat:400,700",
		"Open Sans"			=> "Open+Sans:400italic,700italic,400,700"
	);
	
	$primary_font  = get_data('primary_font');
	$font          = isset($font_overrides[$primary_font]) ? $font_overrides[$primary_font] : reset($font_overrides);
	
	$font_url = "//fonts.googleapis.com/css?family={$font}";
	
	# Custom Font
	$use_custom_font       = get_data('use_custom_font');
	$custom_font_family    = get_data('custom_font_family');
	$custom_font_url       = get_data('custom_font_url');
	
	
	if($use_custom_font && $custom_font_family && $custom_font_url)
	{
		$font_url = $custom_font_url;
		add_filter('get_data_primary_font', create_function('$val', 'return "'.$custom_font_family.'";'));
	}
	
	# Styles
	wp_enqueue_style('font-primary', $font_url, null, null, null);
	
	wp_enqueue_style('entypo');
	wp_enqueue_style('foundation-component');
	wp_enqueue_style('calcium');
	
	if(get_data('skin_type') == 'Dark')
		wp_enqueue_style('calcium-dark');
	
	if(get_data('skin_custom'))
		wp_enqueue_style('calcium-custom');	
		
	wp_enqueue_style('stylecss');
	
	
	# Scripts
	wp_enqueue_script('jquery');
	wp_enqueue_script('greensock');
	wp_enqueue_script('joinable');
	//wp_enqueue_script('classie.js');
	//wp_enqueue_script('sidebarEffects.js');
	//wp_enqueue_script('foundation.min.js');
	
	if ( is_singular() && comments_open() && get_option('thread_comments') )
		wp_enqueue_script( 'comment-reply' );
}

function laborator_wp_print_scripts()
{
	global $font_overrides;
	
	?>
<script type="text/javascript">
var ajaxurl = ajaxurl || '<?php echo esc_attr( admin_url("admin-ajax.php") ); ?>';
</script>
<?php
	
	if( ! get_data('sidebar_menu_enabled')):
	?>
<style>
.st-content-inner > .row > header .header-container > nav .main-nav > li.sidebar-menu { display: none; }
.st-content-inner > .row > header .header-container > nav .main-nav { margin-top: -20px; }
</style>
<?php
	endif;
	
	
	$primary_font = get_data('primary_font');
	
	if($primary_font != 'none' && ! is_admin() && basename($_SERVER['PHP_SELF']) != 'wp-login.php'):
	?>
<style>body, button, input { font-family: <?php echo $primary_font; ?>, serif;}</style>
<?php
	endif;
	
	$custom_css = get_data('custom_css');
	
	if(trim($custom_css))
	{
		echo "<style>".compress_text($custom_css)."</style>";
	}
}

function laborator_wp_enqueue_scripts_custom()
{
	wp_enqueue_script('calcium.custom');
}

function laborator_admin_enqueue_scripts()
{
	wp_enqueue_style('calcium.admin');
}

function laborator_admin_print_styles()
{
?>
<style>
	
#toplevel_page_laborator_options .wp-menu-image {
	background: url(<?php echo get_template_directory_uri(); ?>/assets/images/laborator-icon-adminmenu16-sprite.png) no-repeat 11px 8px !important;
}

#toplevel_page_laborator_options .wp-menu-image:before {
	display: none;
}

#toplevel_page_laborator_options .wp-menu-image img {
	display: none;
}

#toplevel_page_laborator_options:hover .wp-menu-image, #toplevel_page_laborator_options.wp-has-current-submenu .wp-menu-image {
	background-position: 11px -24px !important;
}

</style>
<?php
}


# WP Footer
add_action('wp_footer', 'laborator_wp_footer', 100);

function laborator_wp_footer()
{
	?>
<script type="text/javascript">
//	jQuery(document).foundation();
</script>
<?php

	
	if($google_analytics = get_data('google_analytics'))
	{
		echo $google_analytics;
	}
}



# Ajax Contact Form
add_action('wp_ajax_cf_process', 'laborator_cf_process');
add_action('wp_ajax_nopriv_cf_process', 'laborator_cf_process');

function laborator_cf_process()
{
	$resp = array('success' => false);
	
	$verify	= post('verify');
	
	$name	  = post('name');
	$email	 = post('email');
	$phone	 = post('phone');
	$message   = post('message');

	$field_names = array(
		'name'	 => __('Name', TD),
		'email'	=> __('E-mail', TD),
		'phone'	=> __('Phone Number', TD),
		'message'  => __('Message', TD),
	);
	
	if(wp_verify_nonce($verify, 'contact-form'))
	{
		$admin_email = get_option('admin_email');
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$email_subject = "[" . get_bloginfo("name") . "] New contact form message submitted.";
		$email_message = "New message has been submitted on your website contact form. IP Address: {$ip}\n\n=====\n\n";
		
		foreach($_POST as $key => $val)
		{
			if(in_array($key, array('action', 'verify')))
			{
				continue;
			}
			
			$field_label = isset($field_names[$key]) ? $field_names[$key] : ucfirst($key);
			
			$email_message .= "{$field_label}:\n" . ($val ? $val : '/') . "\n\n";
		}
		
		$email_message .= "=====\n\nThis email has been automatically send from Contact Form.";
		
		$headers = array();
		
		if($email)
		{
			$headers[] = "Reply-To: <{$email}>";
		}
		
		wp_mail($admin_email, $email_subject, $email_message, $headers);
		
		$resp['success'] = true;
	}
	
	echo json_encode($resp);
	exit;
}



# Comment rendering
function laborator_list_comments_open($comment, $args, $depth)
{
	global $post, $wpdb, $comment_index;
		
	$comment_ID 			= $comment->comment_ID;
	$comment_author 		= $comment->comment_author;
	$comment_author_url		= $comment->comment_author_url;
	$comment_author_email	= $comment->comment_author_email;
	$comment_date 			= $comment->comment_date;
	
	$avatar					= preg_replace("/\s?(height='[0-9]+'|width='[0-9]+')/", "", get_avatar($comment));
	
	$comment_timespan 		= human_time_diff(strtotime($comment_date), time());
	
	$link 					= '<a href="' . $comment_author_url . '" target="_blank">';
	
	if($comment_author_url)
	{
		$avatar = $link . $avatar . '</a>';
	}
	
	?>
	
	<div class="comment-entry">
		<div class="row">
			<div <?php comment_class("comment-container"); ?> id="comment-<?php echo $comment_ID; ?>">
			
				<div class="comments-number-env">
					<div class="comment-number">
						<?php
						echo $link;
						echo $comment_index > 9 ? $comment_index : "0{$comment_index}";
						echo '</a>';
						?>
					</div>
				</div>
				
				<div class="comment-content-env">
					
					<div class="comment-inner">
						<h3>
							<?php echo $comment_author_url ? ($link . $comment_author . '</a>') : $comment_author; ?>
							<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( '<span>Reply</span>', TD), 'depth' => $depth, 'max_depth' => $args['max_depth'], 'before' => '' ) ), $comment, $post ); ?>
							
							<span class="date">
								<?php echo $comment_timespan . ' ' . __('ago', TD); ?>
							</span>
						</h3>
						
						<div class="comment-content">
							<?php comment_text(); ?>
						</div>
					</div>
				
				</div>
				
			</div>
		</div><!-- end: Comment entry -->
	</div>
	<?php
	
	$comment_index++;
	
}

function laborator_list_comments_close()
{
}


# Commenting Rules
function laborator_commenting_rules()
{
	?>
	<div class="rules" style="padding-bottom: 15px">
		<h5><?php _e('Rules of the Blog', TD); ?></h5>
		<p><?php _e('Do not post violating content, tags like bold, italic and underline are allowed that means HTML can be used while commenting. Lorem ipsum dolor sit amet conceur half the time you know i know what.', TD); ?></p>
	</div>
	<?php
}




// JS File on Widgets
add_action('load-widgets.php', 'me_widgets_js_file');

function me_widgets_js_file()
{
	$js_file_path = THEMEURL . "assets/js/laborator-widgets.js";
	
	wp_enqueue_script('laborator_widgets_js_file', $js_file_path);
}



// Portfolio AJAX
add_action('wp_ajax_portfolio_get_items', 'laborator_portfolio_more');
add_action('wp_ajax_nopriv_portfolio_get_items', 'laborator_portfolio_more');

function laborator_portfolio_more()
{
	global $cols;
	
	$resp = array(
		'success' => false
	);
	
	$rows  = post('rows');
	$cols  = post('cols');
	$paged = post('paged');
	$query = post('query');
	
	if($rows && $cols && $paged)
	{
		$filter = array(
			'post_type'        => 'portfolio',
			'posts_per_page'   => $cols * $rows,
			'paged'			   => $paged
		);
		
		# By Category
		if(isset($query['category']))
		{
			$filter['portfolio-category'] = $query['category'];
		}
		
		# By Multiple Categories
		if(isset($query['categories']))
		{
			$filter['tax_query'] = array(
				array(
					'taxonomy' => 'portfolio-category',
					'field' => 'id',
					'terms' => $query['categories']
				),
			);
		}
		
		# By Post Ids
		if(isset($query['ids']))
		{
			$filter['post__in'] = $query['ids'];
		}
		
		$portfolio_items = new WP_Query($filter);
		
		$resp['success'] = true;

		$resp['have_items'] = false;
		$resp['have_more'] = false;
		
		if($portfolio_items->have_posts())
		{
			$resp['have_items'] = true;
			$resp['have_more'] = $rows * $cols <= $portfolio_items->post_count;
			
			ob_start();
			
			while($portfolio_items->have_posts()): $portfolio_items->the_post();
			
				get_template_part('tpls/portfolio-item');
				
			endwhile;
			
			$contents = ob_get_clean();
			
			$resp['items'] = compress_text($contents);
		}
	}
	
	echo json_encode($resp);
	die();
}



# Contact Widget
add_action('wp_ajax_send_via_contact_widget', 'contact_widget_process');
add_action('wp_ajax_nopriv_send_via_contact_widget', 'contact_widget_process');

function contact_widget_process()
{
	$resp = array('success' => false);
	
	$verify	= post('verify');
	
	$name	  = post('name');
	$email	 = post('email');
	$phone	 = post('phone');
	$message   = post('message');

	$field_names = array(
		'name'    => __('Name', TD),
		'email'   => __('E-mail', TD),
		'message' => __('Message', TD),
	);
	
	if(wp_verify_nonce($verify, 'contact-form'))
	{
		$admin_email = get_option('admin_email');
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$email_subject = "[" . get_bloginfo("name") . "] New contact request message submitted via Contact Widget.";
		$email_message = "New message has been submitted on your website contact form. IP Address: {$ip}\n\n=====\n\n";
		
		foreach(array('name' => $name, 'email' => $email, 'message' => $message) as $key => $val)
		{
			$field_label = isset($field_names[$key]) ? $field_names[$key] : ucfirst($key);
			$email_message .= "{$field_label}:\n" . ($val ? $val : '/') . "\n\n";
		}
		
		$email_message .= "=====\n\nThis email has been automatically send from Contact Form Widget.";
		
		$headers = array();
		
		if($email)
		{
			$headers[] = "Reply-To: <{$email}>";
		}
		
		wp_mail($admin_email, $email_subject, $email_message, $headers);
		
		$resp['success'] = true;
	}
	
	echo json_encode($resp);
	die();
}



# Register Theme
add_action( 'tgmpa_register', 'calcium_register_required_plugins' );

function calcium_register_required_plugins()
{

	$plugins = array(

		array(
			'name'     				=> 'Vision - Shortcodes',
			'slug'     				=> 'vision',
			'source'   				=> THEMEDIR . 'inc/thirdparty-plugins/vision.zip',
			'required' 				=> true,
			'version' 				=> '',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> ''
		),

		array(
			'name'     				=> 'Advanced Custom Fields',
			'slug'     				=> 'advanced-custom-fields',
			'source'   				=> THEMEDIR . 'inc/thirdparty-plugins/advanced-custom-fields.zip',
			'required' 				=> true,
			'version' 				=> '',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> ''
		),

		array(
			'name'     				=> 'ACF Flexible Content (Add on)',
			'slug'     				=> 'acf-flexible-content',
			'source'   				=> THEMEDIR . 'inc/thirdparty-plugins/acf-flexible-content.zip',
			'required' 				=> true,
			'version' 				=> '',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> ''
		),

		array(
			'name'     				=> 'ACF Location Field (Add on)',
			'slug'     				=> 'advanced-custom-fields-location-field-add-on',
			'source'   				=> THEMEDIR . 'inc/thirdparty-plugins/acf-location-field-add-on.zip',
			'required' 				=> true,
			'version' 				=> '',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> ''
		),
		
		array(
			'name'                   => 'Envato WordPress Toolkit',
			'slug'                   => 'envato-wordpress-toolkit',
			'source'                 => THEMEDIR . 'inc/thirdparty-plugins/envato-wordpress-toolkit.zip',
			'required'               => false,
			'version'                => '',
			'force_activation'       => false,
			'force_deactivation'     => false,
		),
	);

	$theme_text_domain = TD;
	
	$config = array(
		'domain'                              => $theme_text_domain, 
		'default_path'                        => '',
		'parent_menu_slug'                    => 'themes.php',
		'parent_url_slug'                     => 'themes.php',
		'menu'                                => 'install-required-plugins',
		'has_notices'                         => true,
		'is_automatic'                        => false,
		'message'                             => '',
		'strings'                             => array(
			'page_title'                         => __( 'Install Required Plugins', $theme_text_domain ),
			'menu_title'                         => __( 'Install Plugins', $theme_text_domain ),
			'installing'                         => __( 'Installing Plugin: %s', $theme_text_domain ),
			'oops'                               => __( 'Something went wrong with the plugin API.', $theme_text_domain ),
			'notice_can_install_required'        => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ),
			'notice_can_install_recommended'     => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ),
			'notice_cannot_install'              => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ),
			'notice_can_activate_required'       => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ),
			'notice_can_activate_recommended'    => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), 
			'notice_cannot_activate'             => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ),
			'notice_ask_to_update'               => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ),
			'notice_cannot_update'               => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ),
			'install_link'                       => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link'                      => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                             => __( 'Return to Required Plugins Installer', $theme_text_domain ),
			'plugin_activated'                   => __( 'Plugin activated successfully.', $theme_text_domain ),
			'complete'                           => __( 'All plugins installed and activated successfully. %s', $theme_text_domain ), 
			'nag_type'                           => 'updated'
		)
	);

	tgmpa( $plugins, $config );
}



# Admin Bar Links
add_action('admin_bar_menu', "laborator_admin_bar_menu", 10000);

function laborator_admin_bar_menu()
{
    global $wp_admin_bar;
    
    if ( !is_super_admin() || !is_admin_bar_showing() )
        return;
	
	$root      = 'site-name';

	$item_id   = 1;
	
	# Theme Options
	$wp_admin_bar->add_menu( array(
		'parent'  => $root,
		'id'      => $root . '-' . $item_id++,
		'title'   => "Theme Options",
		'href'    => admin_url('themes.php?page=optionsframework'),
		'meta'    => "" ) 
	);
}