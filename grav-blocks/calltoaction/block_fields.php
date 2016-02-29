<?php

/*
*
* Gravitate Content Block
*
* Available Variables:
* $block 					= Name of Block Folder
* $block_backgrounds 		= Array for Background Options
* $block_background_image = Array for Background Image Option
*
* This file must return an array();
*
*/

return array (
	'label' => 'Call to Action',
	'name' => $block,
	'display' => 'row',
	'min' => '',
	'max' => '',
	'sub_fields' => array (
		$block_backgrounds,
		$block_background_image,
		array (
			'key' => 'field_'.$block.'_1',
			'label' => 'Title (optional)',
			'name' => 'title',
			'type' => 'text',
			'column_width' => '',
			'default_value' => '',
			'instructions' => 'This is the title of the section.',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'formatting' => 'none', 		// none | html
			'maxlength' => '',
		),
		array (
			'key' => 'field_'.$block.'_2',
			'label' => 'Description (optional)',
			'name' => 'description',
			'type' => 'textarea',
			'instructions' => 'This is the description of the section.',
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'formatting' => 'html',
		),
		array (
			'key' => 'field_'.$block.'_3',
			'label' => 'Buttons',
			'name' => 'buttons',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => '',
			'max' => '',
			'layout' => 'block',
			'button_label' => 'Add Button',
			'sub_fields' => array (
				GRAV_BLOCKS::get_link_fields( 'button' ),
			),
		),
	),
	'grav_blocks_settings' => array(
		'icon' => 'gravicon-cta',
		'description' => '<p>Integer sollicitudin sapien eget tristique sodales. Fusce pellentesque tincidunt nisi vitae mattis. Donec placerat enim sit amet tempor semper. Proin vel gravida odio. Quisque mollis augue eu nisi cursus, eget imperdiet lectus lobortis. Nulla ut ultrices velit, eu pretium eros. Quisque in turpis scelerisque, tempus nulla id, consequat dui.</p><p>Fusce vel consectetur enim. Phasellus nisl enim, tincidunt sed dui vel, dictum ullamcorper arcu. Quisque ex est, tincidunt id quam vitae, viverra laoreet est. Donec venenatis ornare condimentum. Aliquam erat volutpat. Aenean turpis arcu, tincidunt vel malesuada eu, fringilla ac metus. In non lectus sed augue ullamcorper sagittis.</p>'
	),
);
?>