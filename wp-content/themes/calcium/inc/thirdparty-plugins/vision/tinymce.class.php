<?php
class vision_tinymce
{	
	function __construct()
	{
		add_action('admin_init', array( &$this, 'tt_head' ));
		add_action('init', array( &$this, 'tt_tinymce_rich_buttons' ));
	}
	
// --------------------------------------------------------------------------
	
function tt_head()
	{
		// css
		wp_enqueue_style( 'vision-popup', VISION_TINYMCE_URI . '/css/popup.css', false, '1.0', 'all' );
		
		// js
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script( 'vision-jquery-livequery', VISION_TINYMCE_URI . '/js/jquery.livequery.js', false, '1.1.1', false );
		wp_enqueue_script( 'vision-jquery-appendo', VISION_TINYMCE_URI . '/js/jquery.appendo.js', false, '1.0', false );
		wp_enqueue_script( 'vision-popup', VISION_TINYMCE_URI . '/js/popup.js', false, '1.0', false );
	}
	
// --------------------------------------------------------------------------
	
/*--------------------------------------*/
/*	Registers TinyMCE rich editor button
/*--------------------------------------*/	 
	function tt_tinymce_rich_buttons()
	{
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;
	
		if ( get_user_option('rich_editing') == 'true' )
		{
			add_filter( 'mce_external_plugins', array( &$this, 'tt_add_rich_plugins' ) );
			add_filter( 'mce_buttons', array( &$this, 'tt_register_rich_buttons' ) );
		}
	}	

/*--------------------------------------*/
/*	Define TinyMCE rich editor js plugin
/*--------------------------------------*/
	function tt_add_rich_plugins( $plugin_array )
	{
		$plugin_array['visionShortcodes'] = VISION_TINYMCE_URI . '/tinymce-menu.js';
		return $plugin_array;
	}

/*--------------------------------------*/
/*	Adds TinyMCE rich editor buttons
/*--------------------------------------*/	 
	function tt_register_rich_buttons( $buttons )
	{
		array_push( $buttons, "|", 'vision_button' );
		return $buttons;
	}	
}
?>