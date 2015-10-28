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


$column_width_options = array(
		2 => 'Small',
		5 => 'Medium',
		8 => 'Large',
		6 => 'Half',
	);

return array (
	'name' => $block,
	'label' => 'Content With Image',
	'display' => 'row',
	'sub_fields' => array (
		$block_backgrounds,
		$block_background_image,
		array (
			'key' => 'field_'.$block.'_1',
			'label' => 'Image Placement',
			'name' => 'image_placement',
			'prefix' => '',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'column_width' => '',
			'choices' => array (
				'left' => 'Left',
				'right' => 'Right',
			),
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => '',
			'layout' => 'horizontal',
		),
		array (
			'key' => 'field_'.$block.'_2',
			'label' => 'Image Size',
			'name' => 'image_size',
			'prefix' => '',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'column_width' => '',
			'choices' => $column_width_options,
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => '',
			'layout' => 'horizontal',
		),
		array (
			'key' => 'field_'.$block.'_3',
			'label' => 'Content',
			'name' => 'content',
			'prefix' => '',
			'type' => 'wysiwyg',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'column_width' => '',
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'full',
			'media_upload' => 0,
		),
		array (
			'key' => 'field_'.$block.'_4',
			'label' => 'Images',
			'name' => 'images',
			'prefix' => '',
			'type' => 'repeater',
			'instructions' => 'If more than one image is uploaded, image area will become a slider.',
			'required' => 0,
			'conditional_logic' => 0,
			'column_width' => '',
			'min' => '',
			'max' => '',
			'layout' => 'row',
			'button_label' => 'Add Image',
			'sub_fields' => array (
				array (
					'key' => 'field_'.$block.'_5',
					'label' => 'Image',
					'name' => 'image',
					'prefix' => '',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'column_width' => '',
					'return_format' => 'array',
					'preview_size' => 'medium',
					'library' => 'all',
				),
			),
		),
	),
	'min' => '',
	'max' => '',
);