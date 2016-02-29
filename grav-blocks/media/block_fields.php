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
	'label' => 'Media',
	'name' => $block,
	'display' => 'row',
	'min' => '',
	'max' => '',
	'sub_fields' => array (
		$block_backgrounds,
		$block_background_image,
		array (
			'key' => 'field_'.$block.'_1',
			'label' => 'Full Width Image',
			'name' => 'full_width_image',
			'type' => 'image',
			'column_width' => '',
			'save_format' => 'object',
			'preview_size' => 'medium',
			'library' => 'all',
		),
		array (
			'key' => 'field_'.$block.'_2',
			'label' => 'Add Padding',
			'name' => 'padding',
			'type' => 'true_false',
			'column_width' => '',
			'message' => '',
			'default_value' => 0,
		),
		GRAV_BLOCKS::get_link_fields( 'link', '', false),
	),
	'grav_blocks_settings' => array(
		'icon' => 'gravicon-media',
	),
);