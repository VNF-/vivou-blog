<?php
/**
 *	Laborator DataOpt Blocks
 *	
 *	Laborator.co
 *	www.laborator.co 
 */



// ! Clients Logo Carousel Block
$fields = array();

$fields['logo_image'] 	= array('field_type' => 'image', 'field_name' => 'Logo Image', 'required' => true, 'image_sizes' => array('th' => array(135, 50, true, 3)), 'desc' => 'Maximum width for an image is 135px');
$fields['name']			= array('field_type' => 'text', 'field_name' => 'Name', 'required' => true);
$fields['link'] 		= array('field_type' => 'text', 'field_name' => 'Link', 'required' => false, 'placeholder' => 'http://');
$fields['blank_page']	= array('field_type' => 'checkbox', 'field_name' => 'Open link in new window', 'params' => array('checked' => false));
#$fields['category']	 	= array('field_type' => 'text', 'field_name' => 'Category', 'desc' => '(Optional) If you want to group features, give this logo a common name with other related logos.', 'required' => false, 'params' => array('heading' => 'Category Filtering'));

$clients_carousel_instance = new LaboratorDataOpt(array(
	'parent_slug'				=> 'laborator_options', 
	'menu_slug' 				=> 'laborator_client_module', 
	'access_global'				=> 'laborator_clients_carousel',
	'title' 					=> 'Client Logos', 
	'fields' 					=> $fields,
	'table_fields'				=> array('logo_image' => array('width' => 160), 'name', 'category'),
	'sortable'					=> true,
	'sortable_column' 			=> -1,
	'order' 					=> 'ASC',
	'labels'					=> array(
									'singluar' => 'Client Logo',
									'add_new' => 'Add Client'
								),
	'on_edit_return_to_main'	=> false
));

function get_all_client_logos()
{
	global $clients_carousel_instance;
	
	return $clients_carousel_instance->get_entries();
}