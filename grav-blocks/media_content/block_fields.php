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
			'choices' => $column_width_options,
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => '',
			'layout' => 'horizontal',
		),
		array (
			'key' => 'field_'.$block.'_5',
			'label' => 'Link Type',
			'name' => 'link_type',
			'type' => 'radio',
			'layout' => 'horizontal',
			'column_width' => '',
			'instructions' => 'This will turn the image into a link of the chosen type.',
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
			'key' => 'field_'.$block.'_6',
			'label' => 'External Link',
			'name' => 'link_link',
			'type' => 'text',
			'conditional_logic' => array (
				'status' => 1,
				'rules' => array (
					array (
						'field' => 'field_'.$block.'_5',
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
			'key' => 'field_'.$block.'_7',
			'label' => 'Video Link',
			'name' => 'link_video',
			'type' => 'text',
			'conditional_logic' => array (
				'status' => 1,
				'rules' => array (
					array (
						'field' => 'field_'.$block.'_5',
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
			'key' => 'field_'.$block.'_8',
			'label' => 'Page',
			'name' => 'link_page',
			'type' => 'page_link',
			'conditional_logic' => array (
				'status' => 1,
				'rules' => array (
					array (
						'field' => 'field_'.$block.'_5',
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
			'key' => 'field_'.$block.'_9',
			'label' => 'Upload File',
			'name' => 'link_file',
			'type' => 'file',
			'conditional_logic' => array (
				'status' => 1,
				'rules' => array (
					array (
						'field' => 'field_'.$block.'_5',
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
);