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
	'name' => 'grid',
	'label' => 'Grid',
	'display' => 'row',
	'sub_fields' => array (
		$block_backgrounds,
		$block_background_image,
		array (
			'key' => 'field_'.$block.'_1',
			'label' => 'Grid Title',
			'name' => 'grid_title',
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
			'label' => 'Grid Items',
			'name' => 'grid_items',
			'type' => 'repeater',
			'column_width' => '',
			'instructions' => '',
			'sub_fields' => array (
				array (
					'key' => 'field_'.$block.'_3',
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
					'key' => 'field_'.$block.'_4',
					'label' => 'Image',
					'name' => 'item_image',
					'instructions' => '',
					'type' => 'image',
					'column_width' => '',
					'save_format' => 'object',
					'library' => 'all',
					'preview_size' => 'medium',
				),
				array (
					'key' => 'field_'.$block.'_5',
					'label' => 'Content',
					'name' => 'item_content',
					'type' => 'wysiwyg',
					'column_width' => '',
					'default_value' => '',
					'toolbar' => 'full',
					'media_upload' => 'no',
				),
			),
			'row_min' => '',
			'row_limit' => '',
			'layout' => 'row',
			'button_label' => 'Add Grid Item',
		),
	),
	'min' => '',
	'max' => '',
);
