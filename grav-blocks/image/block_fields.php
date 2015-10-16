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
	'label' => 'Image',
	'name' => $block,
	'display' => 'row',
	'min' => '',
	'max' => '',
	'sub_fields' => array (
		$block_backgrounds,
		$block_background_image,
		array (
			'key' => 'field_'.$block.'_01',
			'label' => 'Add Padding',
			'name' => 'padding',
			'type' => 'true_false',
			'column_width' => '',
			'message' => '',
			'default_value' => 0,
		),
		array (
			'key' => 'field_'.$block.'_02',
			'label' => 'Full Width Image',
			'name' => 'full_width_image',
			'type' => 'image',
			'column_width' => '',
			'save_format' => 'object',
			'preview_size' => 'medium',
			'library' => 'all',
		),
	),
);