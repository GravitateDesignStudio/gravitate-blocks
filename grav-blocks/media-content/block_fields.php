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
	'name' => $block,
	'label' => 'Media with Content',
	'display' => 'row',
	'sub_fields' => array (
		$block_backgrounds,
		$block_background_image,
		array (
			'key' => 'field_'.$block.'_4',
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
			'choices' => GRAV_BLOCKS::column_width_options(),
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => '',
			'layout' => 'horizontal',
		),
		GRAV_BLOCKS::get_link_fields( 'link', '', false ),
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
	),
	'min' => '',
	'max' => '',
	'grav_blocks_settings' => array(),
);