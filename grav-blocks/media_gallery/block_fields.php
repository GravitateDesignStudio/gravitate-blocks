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
	'display' => 'row',
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
				array (
					'key' => 'field_'.$block.'_3',
					'label' => 'Link Type',
					'name' => 'link_type',
					'type' => 'radio',
					'layout' => 'horizontal',
					'column_width' => '',
					'choices' => array (
						'none' => 'None',
						'page' => 'Page',
						'video' => 'Video',
						'link' => 'External',
						'file' => 'File',
					),
					'default_value' => 'none',
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_'.$block.'_4',
					'label' => 'External Link',
					'name' => 'link_link',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_'.$block.'_3',
								'operator' => '==',
								'value' => 'link',
							),
						),
						'allorany' => 'all',
					),
					'column_width' => '',
					'default_value' => '',
					'placeholder' => 'http://',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_'.$block.'_5',
					'label' => 'Video Link',
					'name' => 'link_video',
					'type' => 'text',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_'.$block.'_3',
								'operator' => '==',
								'value' => 'video',
							),
						),
						'allorany' => 'all',
					),
					'column_width' => '',
					'default_value' => '',
					'placeholder' => 'http://',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
				),
				array (
					'key' => 'field_'.$block.'_6',
					'label' => 'Page',
					'name' => 'link_page',
					'type' => 'page_link',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_'.$block.'_3',
								'operator' => '==',
								'value' => 'page',
							),
						),
						'allorany' => 'all',
					),
					'column_width' => '',
					'post_type' => array (
						0 => 'all',
					),
					'allow_null' => 0,
					'multiple' => 0,
				),
				array (
					'key' => 'field_'.$block.'_7',
					'label' => 'Upload File',
					'name' => 'link_file',
					'type' => 'file',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_'.$block.'_3',
								'operator' => '==',
								'value' => 'file',
							),
						),
						'allorany' => 'all',
					),
					'column_width' => '',
					'save_format' => 'url',
					'library' => 'all',
				),
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
);
