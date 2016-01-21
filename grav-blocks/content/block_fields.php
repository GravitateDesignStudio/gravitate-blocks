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
	'label' => 'Content',
	'name' => $block,
	'display' => 'block',
	'min' => '',
	'max' => '',
	'sub_fields' => array (
		$block_backgrounds,
		$block_background_image,
		array (
			'key' => 'field_'.$block.'_1',
			'label' => 'Content Columns',
			'name' => 'content_column',
			'type' => 'repeater',
			'column_width' => '',
			'sub_fields' => array (
				array (
					'key' => 'field_'.$block.'_2',
					'label' => 'Column',
					'name' => 'column',
					'type' => 'wysiwyg',
					'column_width' => '',
					'default_value' => '',
					'tabs' => 'all',
					'toolbar' => 'full',
					'media_upload' => 'yes',
				),
			),
			'min' => '',
			'max' => '3',
			'layout' => 'block',
			'button_label' => 'Add Column',
		),
	),
	'grav_blocks_settings' => array(
		'icon' => 'testing'
		),
);