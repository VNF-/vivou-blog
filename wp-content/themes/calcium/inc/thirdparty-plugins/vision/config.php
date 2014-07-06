<?php

# start: modified by Arlind Nushi

/*---------------------------------------*/
/* Laborator - Columns
/*---------------------------------------*/
$tt_shortcodes['lab-columns'] = array(
	'params' => array(),
	'shortcode' => ' {{child_shortcode}} ',
	'no_preview' => true,
	
	
	'child_shortcode' => array(
	
		'params' => array(
		
			'column' => array(
				'type'  => 'text',
				'label' => __('Column Type'),
				'desc'  => '',
				'std'   => '12',
				'desc'  => 'Enter numeric value between 1 and 12'
			),
			
			'content'=> array(
				'std'   => '',
				'type'  => 'textarea',
				'label' => __('Column Content'),
				'desc'  => '(you can also leave this field blank and insert the content later)',
			)
		),
		
		'shortcode' => '[lab_column size_lg="{{column}}" size_md="{{column}}" size_sm="{{column}}"]{{content}}[/lab_column] ',
		
		'clone_button' => __('+ Add Another Column')
	)
);


/*---------------------------------------*/
/* Laborator - Alerts
/*---------------------------------------*/
$tt_shortcodes['lab-alert'] = array(
	'params' => array(
					
		'type' => array(
			'type' => 'select',
			'label' => __('Type'),
			'options' => array(
				'default'   => 'Default',
				'info'      => 'Information',
				'success'   => 'Success',
				'warning'   => 'Warning',
				'error'     => 'Error',
				'secondary' => 'Secondary',
			)
		),
			
		'content' => array(
			'std'   => 'Your custom alert message here...',
			'type'  => 'textarea',
			'label' => __('Alert Text'),
			'desc'  => 'Enter the alert message.',
		)
	),
		
	'shortcode' => '[lab_alert type="{{type}}"]{{content}}[/lab_alert]',
);


/*---------------------------------------*/
/* Laborator - Button
/*---------------------------------------*/
$tt_shortcodes['lab-button'] = array(
	'params' => array(
			
		'content' => array(
			'std'   => 'Sample Button',
			'type'  => 'text',
			'label' => __('Button Text'),
			'desc'  => '',
		),
			
		'size' => array(
			'type'  => 'select',
			'label' => __('Button Size'),
			'options' => array(
				'small' => 'Normal',
				'tiny' => 'Tiny',
				'large' => 'Large'
			)
		),
			
		'href' => array(
			'std'   => 'http://',
			'type'  => 'text',
			'label' => __('Button Link'),
			'desc'  => '',
		),
			
		'new_window' => array(
			'checkbox_text'   => 'Open in New Window',
			'std' => '',
			'type'  => 'checkbox',
			'label' => __('Target'),
			'desc'  => '',
		),
	),
		
	'shortcode' => '[lab_button href="{{href}}" size="{{size}}" new_window="{{new_window}}"]{{content}}[/lab_button]',
);




/*---------------------------------------*/
/* Laborator - Pricing Box
/*---------------------------------------*/
$tt_shortcodes['lab-pricing-box'] = array(
	'params' => array(),
	'shortcode' => ' {{child_shortcode}} ',
	'no_preview' => true,
	
	// can be cloned and re-arrange
	'child_shortcode' => array(
		'params' => array(
		
			'column' => array(
				'type' => 'select',
				'label' => __('Width'),
				'desc' => 'Select a width for this pricing box.',
				'options' => array(
					'8' => 'One Half (8 cols)',
					'4' => 'One Third (4 cols)',
					'3' => 'One Fourth (3 cols)'
				)
			),
		
			'head_title' => array(
				'std' => 'pro',
				'type' => 'text',
				'label' => __('Head Title'),
				'desc' => __('ie. basic, pro, premium')
			),
	
			'currency' => array(
				'std' => '$',
				'type' => 'text',
				'label' => __('Currency Symbol'),
				'desc' => __('ie. $, &euro;')
			),
		
			'price' => array(
				'std' => '29',
				'type' => 'text',
				'label' => __('Price'),
				'desc' => __('ie. 29')
			),
	
			'term' => array(
				'std' => 'per month',
				'type' => 'text',
				'label' => __('Term'),
				'desc' => __('ie. per month, per year')
			),
	
			'button_label' => array(
				'std' => 'Sign up',
				'type' => 'text',
				'label' => __('Button Label'),
				'desc' => __('ie. sign up, learn more')
			),
	
			'button_size' => array(
				'type' => 'select',
				'label' => __('Button Size'),
				'options' => array(
					'small' => 'Normal',
					'tiny' => 'Tiny',
					'large' => 'Large'
				)
			),
			
	
			'button_url' => array(
				'std' => 'http://www.',
				'type' => 'text',
				'label' => __('Button URL'),
				'desc' => __('ie. http://www.your-website.com/purchase')
			),
		
			'button_target' => array(
				'type' => 'select',
				'label' => __('Button Target'),
				'desc' => __('"_self" opens URL in same window &nbsp; / &nbsp; "_blank" opens URL in new window'),
				'options' => array(
					'_self' => '_self',
					'_parent' => '_parent',
					'_blank' => '_blank',
					'_top' => '_top',
			)),
			
			
			'description' => array(
					'std' => '<li>50 GB Sample item 1</li>' . PHP_EOL . '<li>100 Emails Sample item 2</li>' . PHP_EOL . '<li>Another great feature</li>',
					'type' => 'textarea',
					'label' => __('Description'),
			),
		
			'selected_plan' => array(
				'type' => 'select',
				'label' => __('Selected Plan?'),
				'desc' => __('If you select "Yes" it will be highlighted with different color.'),
				'options' => array(
					'no' => 'No',
					'yes' => 'Yes'
			)),
			
		),
		
		'shortcode' => '[lab_column size_lg="{{column}}" size_md="{{column}}" size_sm="12"] [lab_pricing_box head_title="{{head_title}}" currency="{{currency}}" price="{{price}}" term="{{term}}" button_label="{{button_label}}" button_size="{{button_size}}" button_url="{{button_url}}" button_target="{{button_target}}" selected_plan="{{selected_plan}}"] {{description}} [/lab_pricing_box][/lab_column]',
		'clone_button' => __('+ Add Another Pricing Box')
	)
);


/*---------------------------------------*/
/* Laborator - Tabs
/*---------------------------------------*/
$tt_shortcodes['lab-tabs'] = array(

	'params' => array(
		'type' => array(
			'type' => 'select',
			'label' => __('Choose Type'),
			'desc' => 'Choose between types: Tabs and Accordions.',
			'options' => array(
				'tabs' => 'Tabs',
				'accordion' => 'Accordion',
			)
		),
	),
	'shortcode' => '[lab_tabs type="{{type}}"] {{child_shortcode}} [/lab_tabs]',
	'no_preview' => true,
	
	// can be cloned and re-arranged
	'child_shortcode' => array(
		'params' => array(
			'title' => array(
				'type' => 'text',
				'label' => __('Tab Title'),
				'std' => ''
			),
			
			'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __('Tab Content'),
			),
			
			'active' => array(
			'type' => 'select',
			'label' => __('Active Tab?'),
			'desc' => __('Should this tab be active by default?'),
			'options' => array(
				'no' => 'No',
				'yes' => 'Yes',
			)),
		),
		'shortcode' => '[lab_tab title="{{title}}" active="{{active}}"] {{content}} [/lab_tab] ',
		'clone_button' => __('+ Add Another Tab')
	)
);
# end: modified by Arlind Nushi