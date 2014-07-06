<?php


/*
*  get_field_reference()
*
*  This function will find the $field_key that is related to the $field_name.
*  This is know as the field value reference
*
*  @type	function
*  @since	3.6
*  @date	29/01/13
*
*  @param	mixed	$field_name: the name of the field - 'sub_heading'
*  @param	int		$post_id: the post_id of which the value is saved against
*
*  @return	string	$return:  a string containing the field_key
*/

function get_field_reference( $field_name, $post_id )
{
	// cache
	$found = false;
	$cache = wp_cache_get( 'field_reference/post_id=' .  $post_id . '/name=' .  $field_name, 'acf', false, $found );

	if( $found )
	{
		return $cache;
	}
	
	
	// vars
	$return = '';

	
	// get field key
	if( is_numeric($post_id) )
	{
		$return = get_post_meta($post_id, '_' . $field_name, true); 
	}
	elseif( strpos($post_id, 'user_') !== false )
	{
		$temp_post_id = str_replace('user_', '', $post_id);
		$return = get_user_meta($temp_post_id, '_' . $field_name, true); 
	}
	else
	{
		$return = get_option('_' . $post_id . '_' . $field_name); 
	}
	
	
	// set cache
	wp_cache_set( 'field_reference/post_id=' .  $post_id . '/name=' .  $field_name, $return, 'acf' );
		
	
	// return	
	return $return;
}


/*
*  get_field()
*
*  This function will return a custom field value for a specific field name/key + post_id.
*  There is a 3rd parameter to turn on/off formating. This means that an Image field will not use 
*  its 'return option' to format the value but return only what was saved in the database
*
*  @type	function
*  @since	3.6
*  @date	29/01/13
*
*  @param	string		$field_key: string containing the name of teh field name / key ('sub_field' / 'field_1')
*  @param	mixed		$post_id: the post_id of which the value is saved against
*  @param	boolean		$format_value: whether or not to format the value as described above
*
*  @return	mixed		$value: the value found
*/
 
function get_field( $field_key, $post_id = false, $format_value = true ) 
{
	// vars
	$return = false;
	$options = array(
		'load_value' => true,
		'format_value' => $format_value
	);

	
	$field = get_field_object( $field_key, $post_id, $options);
	
	
	if( is_array($field) )
	{
		$return = $field['value'];
	}
	
	
	return $return;
	 
}


/*
*  get_field_object()
*
*  This function will return an array containing all the field data for a given field_name
*
*  @type	function
*  @since	3.6
*  @date	3/02/13
*
*  @param	string		$field_key: string containing the name of teh field name / key ('sub_field' / 'field_1')
*  @param	mixed		$post_id: the post_id of which the value is saved against
*  @param	array		$options: an array containing options
*			boolean		+ load_value: load the field value or not. Defaults to true
*			boolean		+ format_value: format the field value or not. Defaults to true
*
*  @return	array		$return: an array containin the field groups
*/

function get_field_object( $field_key, $post_id = false, $options = array() )
{
	// filter post_id
	$post_id = apply_filters('acf/get_post_id', $post_id );
	$field = false;
	$orig_field_key = $field_key;
	
	
	// defaults for options
	$defaults = array(
		'load_value'	=>	true,
		'format_value'	=>	true,
	);
	
	$options = array_merge($defaults, $options);
	
	
	// is $field_name a name? pre 3.4.0
	if( strpos($field_key, "field_") === false )
	{
		// get field key
		$field_key = get_field_reference( $field_key, $post_id );
	}
	
	
	// get field
	if( strpos($field_key, "field_") !== false )
	{
		$field = apply_filters('acf/load_field', false, $field_key );
	}
	
	
	// validate field
	if( !$field )
	{
		// treat as text field
		$field = array(
			'type' => 'text',
			'name' => $orig_field_key,
			'key' => 'field_' . $orig_field_key,
		);
		$field = apply_filters('acf/load_field', $field, $field['key'] );
	}


	// load value
	if( $options['load_value'] )
	{
		$field['value'] = apply_filters('acf/load_value', false, $post_id, $field);
		
		
		// format value
		if( $options['format_value'] )
		{
			$field['value'] = apply_filters('acf/format_value_for_api', $field['value'], $post_id, $field);
		}
	}


	return $field;

}