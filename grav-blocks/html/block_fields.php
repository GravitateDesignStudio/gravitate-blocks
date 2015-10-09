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
	'label' => 'HTML',
	'name' => $block,
	'display' => 'row',
	'min' => '',
	'max' => '',
	'sub_fields' => array (
		$block_backgrounds,
		$block_background_image,
		array (
			'key' => 'field_'.$block.'_1',
			'label' => 'HTML Column',
			'name' => 'html_column',
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
					'toolbar' => 'full',
					'media_upload' => 'yes',
				),
			),
			'row_min' => '',
			'row_limit' => '3',
			'layout' => 'row',
			'button_label' => 'Add Column',
		),
	),
);