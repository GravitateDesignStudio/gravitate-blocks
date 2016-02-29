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
	'label' => 'Testimonials',
	'name' => $block,
	'display' => 'row',
	'min' => '',
	'max' => '',
	'sub_fields' => array (
		$block_backgrounds,
		$block_background_image,
		array (
			'key' => 'field_'.$block.'_1',
			'label' => 'Testimonials',
			'name' => 'testimonials',
			'type' => 'repeater',
			'column_width' => '',
			'sub_fields' => array (
				array (
					'key' => 'field_'.$block.'_2',
					'label' => 'Testimonial',
					'name' => 'testimonial',
					'type' => 'textarea',
					'column_width' => '',
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => '',
					'formatting' => 'none',
				),
				array (
					'key' => 'field_'.$block.'_3',
					'label' => 'Image',
					'name' => 'image',
					'type' => 'image',
					'instructions' => '(Optional)',
					'column_width' => '',
					'save_format' => 'object',
					'preview_size' => 'thumbnail',
					'library' => 'all',
				),
				array (
					'key' => 'field_'.$block.'_4',
					'label' => 'Attribution',
					'name' => 'attribution',
					'type' => 'text',
					'instructions' => '(Optional)',
					'column_width' => '',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
			),
			'min' => '',
			'max' => '',
			'layout' => 'row',
			'button_label' => 'Add Testimonial',
		),
	),
	'grav_blocks_settings' => array(
		'icon' => 'gravicon-testimonial',
	),
);