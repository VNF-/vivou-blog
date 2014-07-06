<?php
/**
 *	Calcium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

$use_contact_form   = get_field('use_contact_form');
$available_fields   = get_field('available_fields');
$required_fields    = get_field('required_fields');
$success_message 	= get_field('contact_form_success_message');
$form_title 		= get_field('contact_form_title');

if( ! $use_contact_form)
	return;

$field_names = array(
	'name'     => __('Name', TD),
	'email'    => __('E-mail', TD),
	'phone'    => __('Phone Number', TD),
	'message'  => __('Message', TD),
);

$fields_count = count($available_fields);
$cols_count = $fields_count == 2 && in_array('message', $available_fields) ? 12 : 6;
?>
<div class="row contact-form">
	
	<div class="success-message">
		<div class="large-12 columns">
			<div class="alert-box success"><?php echo nl2br($success_message); ?></div>
		</div>
	</div>
	
	<form method="post" data-check="<?php echo wp_create_nonce("contact-form"); ?>">
		<div class="large-12 columns">
		
			<?php if($form_title): ?>
			<h4><?php echo $form_title ?></h4>
			<?php endif; ?>
								
		</div>
		<div class="large-<?php echo $cols_count; ?> columns">
			<?php foreach($available_fields as $field_name): if($field_name == 'message'){ $has_message_field = $field_name; continue; } ?>
			<input type="text" placeholder="<?php echo (in_array($field_name, $required_fields) ? '* ' : '') . esc_attr($field_names[$field_name]); ?>:"<?php echo in_array($field_name, $required_fields) ? ' data-required="1"' : ''; ?> name="<?php echo $field_name; ?>" />
			<?php endforeach; ?>
		</div>
		
		<div class="large-<?php echo $cols_count; ?> columns">
			<?php if(isset($has_message_field)): ?>
			<textarea  type="text" placeholder="<?php echo $field_names[$has_message_field]; ?>:"<?php echo in_array($has_message_field, $required_fields) ? ' data-required="1"' : ''; ?> name="<?php echo $has_message_field; ?>" class="fields_count_<?php echo $fields_count - 1; ?>"></textarea>
			<?php endif; ?>
			
			<input type="submit" value="<?php _e('Send', TD); ?>" class="send" name="submit" />
		</div>
	</form>
	
	<div class="spinner">
		<div class="double-bounce1"></div>
		<div class="double-bounce2"></div>
	</div>
</div>