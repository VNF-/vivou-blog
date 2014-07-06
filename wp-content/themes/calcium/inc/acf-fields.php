<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_archives',
		'title' => 'Archives',
		'fields' => array (
			array (
				'key' => 'field_5303ceea3da05',
				'label' => 'Archive Title',
				'name' => 'archive_title',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5303c37f4bae1',
				'label' => 'Post Type',
				'name' => 'archive_post_type',
				'type' => 'select',
				'instructions' => 'Select post type to filter posts from.',
				'choices' => array (
					'post' => 'Posts',
					'portfolio' => 'Portfolio Items',
				),
				'default_value' => '',
				'allow_null' => 0,
				'multiple' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'archives.php',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'the_content',
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_blog',
		'title' => 'Blog',
		'fields' => array (
			array (
				'key' => 'field_53052d3c42d6e',
				'label' => 'Filter Posts',
				'name' => 'filter_posts',
				'type' => 'radio',
				'choices' => array (
					'all' => 'All Posts',
					'category' => 'From Category',
					'post_id' => 'Post IDs',
					'author' => 'Author',
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => 'all',
				'layout' => 'vertical',
			),
			array (
				'key' => 'field_53052d7f42d6f',
				'label' => 'Select Category',
				'name' => 'select_category',
				'type' => 'taxonomy',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_53052d3c42d6e',
							'operator' => '==',
							'value' => 'category',
						),
					),
					'allorany' => 'all',
				),
				'taxonomy' => 'category',
				'field_type' => 'multi_select',
				'allow_null' => 0,
				'load_save_terms' => 0,
				'return_format' => 'object',
				'multiple' => 0,
			),
			array (
				'key' => 'field_53052dd69318a',
				'label' => 'Post IDs',
				'name' => 'post_ids',
				'type' => 'relationship',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_53052d3c42d6e',
							'operator' => '==',
							'value' => 'post_id',
						),
					),
					'allorany' => 'all',
				),
				'return_format' => 'object',
				'post_type' => array (
					0 => 'post',
				),
				'taxonomy' => array (
					0 => 'all',
				),
				'filters' => array (
					0 => 'search',
				),
				'result_elements' => array (
					0 => 'featured_image',
					1 => 'post_type',
					2 => 'post_title',
				),
				'max' => '',
			),
			array (
				'key' => 'field_530530d9c2d13',
				'label' => 'Author',
				'name' => 'author',
				'type' => 'user',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_53052d3c42d6e',
							'operator' => '==',
							'value' => 'author',
						),
					),
					'allorany' => 'all',
				),
				'role' => array (
					0 => 'all',
				),
				'field_type' => 'multi_select',
				'allow_null' => 0,
			),
			array (
				'key' => 'field_53052eb11cebf',
				'label' => 'Posts per Page',
				'name' => 'posts_per_page',
				'type' => 'number',
				'instructions' => 'Leave empty (or <strong>0</strong>) if you want to use default value',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '-1 = Display All',
				'append' => '',
				'min' => '-1',
				'max' => 1000,
				'step' => 1,
			),
			array (
				'key' => 'field_53052f3baa4a1',
				'label' => 'Order By',
				'name' => 'order_by',
				'type' => 'select',
				'choices' => array (
					'default' => 'Default',
					'date' => 'Date',
					'ID' => 'ID',
					'author' => 'Author',
					'title' => 'Title',
					'modified' => 'Modified',
					'rand' => 'Random Order',
				),
				'default_value' => '',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_53052fb9aa4a2',
				'label' => 'Order Direction',
				'name' => 'order_direction',
				'type' => 'select',
				'choices' => array (
					'default' => 'Default',
					'asc' => 'Ascending',
					'desc' => 'Descending',
				),
				'default_value' => '',
				'allow_null' => 0,
				'multiple' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'blog.php',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'the_content',
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_contact-page',
		'title' => 'Contact Page',
		'fields' => array (
			array (
				'key' => 'field_530236fdfb512',
				'label' => 'Address & Info',
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_53023228a3ccf',
				'label' => 'Address',
				'name' => 'address',
				'type' => 'textarea',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'html',
			),
			array (
				'key' => 'field_53023a92a37d7',
				'label' => 'Phone & Email',
				'name' => 'phone_and_email',
				'type' => 'textarea',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'html',
			),
			array (
				'key' => 'field_530236ebfb511',
				'label' => 'Map',
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_53023395423dc',
				'label' => 'Contact Map',
				'name' => 'show_contact_map',
				'type' => 'true_false',
				'message' => '',
				'default_value' => 1,
			),
			array (
				'key' => 'field_530233a4423dd',
				'label' => 'Map Location',
				'name' => 'map_location',
				'type' => 'google_map',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_53023395423dc',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'center_lat' => '',
				'center_lng' => '',
				'zoom' => '',
				'height' => '',
			),
			array (
				'key' => 'field_5303162f01d33',
				'label' => 'Map Height',
				'name' => 'map_height',
				'type' => 'number',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_53023395423dc',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => 300,
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => 0,
				'max' => '',
				'step' => 10,
			),
			array (
				'key' => 'field_5302362abdc29',
				'label' => 'Map Zoom Level',
				'name' => 'map_zoom_level',
				'type' => 'number',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_53023395423dc',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => 10,
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => 0,
				'max' => 20,
				'step' => 1,
			),
			array (
				'key' => 'field_530318334753e',
				'label' => 'Pin Image',
				'name' => 'pin_image',
				'type' => 'image',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_53023395423dc',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'save_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_53031cf79a220',
				'label' => 'Map Style',
				'name' => 'map_style',
				'type' => 'textarea',
				'instructions' => 'You can apply custom style for this map. See the gallery of styles <a href="http://www.mapstylr.com/showcase/" target="_blank">http://www.mapstylr.com/showcase/</a>. Paste JSON here:',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_53023395423dc',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'none',
			),
			array (
				'key' => 'field_530237a71baa8',
				'label' => 'Contact Form',
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_530237b01baa9',
				'label' => 'Use Contact Form',
				'name' => 'use_contact_form',
				'type' => 'true_false',
				'message' => '',
				'default_value' => 1,
			),
			array (
				'key' => 'field_53025dc9c5d1f',
				'label' => 'Form Title',
				'name' => 'contact_form_title',
				'type' => 'text',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_530237b01baa9',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => 'Contact Form',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_530238061baaa',
				'label' => 'Available fields',
				'name' => 'available_fields',
				'type' => 'checkbox',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_530237b01baa9',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'choices' => array (
					'name' => 'Name',
					'email' => 'E-mail',
					'phone' => 'Phone',
					'message' => 'Message',
				),
				'default_value' => 'name
	email
	message',
				'layout' => 'horizontal',
			),
			array (
				'key' => 'field_530239f26b011',
				'label' => 'Required Fields',
				'name' => 'required_fields',
				'type' => 'checkbox',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_530237b01baa9',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'choices' => array (
					'name' => 'Name',
					'email' => 'E-mail',
					'phone' => 'Phone',
					'message' => 'Message',
				),
				'default_value' => 'name
	message',
				'layout' => 'horizontal',
			),
			array (
				'key' => 'field_53025afbe0344',
				'label' => 'Success Message',
				'name' => 'contact_form_success_message',
				'type' => 'textarea',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_530237b01baa9',
							'operator' => '==',
							'value' => '1',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '<h5>Your email has been sent!</h5>
	Thank you for contacting us. We will respond to you as soon as possible.',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'html',
			),
			array (
				'key' => 'field_53023afe51a34',
				'label' => 'Page Layout',
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_53023b3f51a35',
				'label' => 'Page Layout',
				'name' => 'page_layout',
				'type' => 'flexible_content',
				'instructions' => 'You can create custom layout for this page, using layout components. Default structure is applied if you don\'t create your own.',
				'layouts' => array (
					array (
						'label' => 'Address Line',
						'name' => 'address_line',
						'display' => 'row',
						'min' => '',
						'max' => '',
						'sub_fields' => array (
						),
					),
					array (
						'label' => 'Map',
						'name' => 'address_map',
						'display' => 'row',
						'min' => '',
						'max' => '',
						'sub_fields' => array (
						),
					),
					array (
						'label' => 'Contact Form',
						'name' => 'contact_form',
						'display' => 'row',
						'min' => '',
						'max' => '',
						'sub_fields' => array (
						),
					),
					array (
						'label' => 'Client Logos',
						'name' => 'client_logos',
						'display' => 'row',
						'min' => '',
						'max' => '',
						'sub_fields' => array (
						),
					),
					array (
						'label' => 'Separator',
						'name' => 'separator',
						'display' => 'row',
						'min' => '',
						'max' => '',
						'sub_fields' => array (
						),
					),
				),
				'button_label' => 'Add Row',
				'min' => 0,
				'max' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'contact.php',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'the_content',
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_portfolio-filter',
		'title' => 'Portfolio Filter',
		'fields' => array (
			array (
				'key' => 'field_53120eec93f9f',
				'label' => 'Head Text',
				'name' => 'head_text',
				'type' => 'textarea',
				'instructions' => 'This will be used as "Quote" text.',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_5315e1706fa76',
				'label' => 'Filter Type',
				'name' => 'filter_type',
				'type' => 'select',
				'choices' => array (
					'category' => 'By category',
					'ids' => 'Select Items',
				),
				'default_value' => 'category',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_5312078f7ab66',
				'label' => 'Category',
				'name' => 'category',
				'type' => 'taxonomy',
				'instructions' => 'Select one or more categories.',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_5315e1706fa76',
							'operator' => '==',
							'value' => 'category',
						),
					),
					'allorany' => 'all',
				),
				'taxonomy' => 'portfolio-category',
				'field_type' => 'multi_select',
				'allow_null' => 0,
				'load_save_terms' => 0,
				'return_format' => 'id',
				'multiple' => 0,
			),
			array (
				'key' => 'field_531207fd8ea30',
				'label' => 'Selected Items',
				'name' => 'selected_items',
				'type' => 'relationship',
				'instructions' => 'Select portfolio items to include in this page.',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_5315e1706fa76',
							'operator' => '==',
							'value' => 'ids',
						),
					),
					'allorany' => 'all',
				),
				'return_format' => 'id',
				'post_type' => array (
					0 => 'portfolio',
				),
				'taxonomy' => array (
					0 => 'all',
				),
				'filters' => array (
					0 => 'search',
				),
				'result_elements' => array (
					0 => 'featured_image',
					1 => 'post_type',
					2 => 'post_title',
				),
				'max' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'portfolio.php',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'the_content',
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_portfolio-item-details',
		'title' => 'Portfolio Item Details',
		'fields' => array (
			array (
				'key' => 'field_530c568069c61',
				'label' => 'Secondary Title',
				'name' => 'secondary_title',
				'type' => 'text',
				'instructions' => 'If filled, will be displayed inside the item details as title.',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_530d97c9ffccc',
				'label' => 'Client',
				'name' => 'client',
				'type' => 'text',
				'instructions' => 'You can specify client name here.',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_530d97fa041d6',
				'label' => 'Finish Date',
				'name' => 'finish_date',
				'type' => 'date_picker',
				'instructions' => 'Select when the project has completed.',
				'date_format' => 'yy-mm-dd',
				'display_format' => 'MM dd, yy',
				'first_day' => 1,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'portfolio',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}
