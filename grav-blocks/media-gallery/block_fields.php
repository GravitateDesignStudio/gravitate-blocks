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
	'label' => 'Media Gallery',
	'display' => 'block',
	'sub_fields' => array (
		$block_backgrounds,
		$block_background_image,
		array (
			'key' => 'field_'.$block.'_1',
			'label' => 'Gallery Title',
			'name' => 'gallery_title',
			'type' => 'text',
			'column_width' => '',
			'default_value' => '',
			'instructions' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'formatting' => 'none',
			'maxlength' => '',
		),
		array (
			'key' => 'field_'.$block.'_2',
			'label' => 'Gallery Items',
			'name' => 'gallery_items',
			'type' => 'repeater',
			'column_width' => '',
			'instructions' => '',
			'sub_fields' => array (
				array (
					'key' => 'field_'.$block.'_8',
					'label' => 'Item Title',
					'name' => 'item_title',
					'type' => 'text',
					'column_width' => '',
					'default_value' => '',
					'instructions' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_'.$block.'_9',
					'label' => 'Image',
					'name' => 'item_image',
					'instructions' => '',
					'type' => 'image',
					'column_width' => '',
					'save_format' => 'object',
					'library' => 'all',
					'preview_size' => 'medium',
				),
				GRAV_BLOCKS::get_link_fields( 'link', '', false ),
				array (
					'key' => 'field_'.$block.'_10',
					'label' => 'Content',
					'name' => 'item_content',
					'type' => 'textarea',
					'column_width' => '',
					'default_value' => '',
				),
			),
			'min' => '',
			'max' => '',
			'layout' => 'row',
			'button_label' => 'Add Gallery Item',
		),
	),
	'min' => '',
	'max' => '',
	'grav_blocks_settings' => array(
		'icon' => 'gravicon-grid_on',
		'group' => 'test',
		'description' => '<h2>Testing stuff</h2>'
	),
);
