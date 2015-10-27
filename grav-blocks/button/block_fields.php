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
	'label' => 'Button',
	'name' => $block,
	'display' => 'row',
	'min' => '',
	'max' => '',
	'sub_fields' => array (
		$block_backgrounds,
		$block_background_image,
		array (
			'key' => 'field_'.$block.'_1',
			'label' => 'Title (optional)',
			'name' => 'title',
			'type' => 'text',
			'column_width' => '',
			'default_value' => '',
			'instructions' => 'This is the title of the section.',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'formatting' => 'none', 		// none | html
			'maxlength' => '',
		),
		array (
			'key' => 'field_'.$block.'_2',
			'label' => 'Subtitle (optional)',
			'name' => 'subtitle',
			'type' => 'textarea',
			'instructions' => 'This is the subtitle or description of the section.',
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'formatting' => 'html',
		),
		array (
			'key' => 'field_'.$block.'_3',
			'label' => 'Button Text',
			'name' => 'button_text',
			'type' => 'text',
			'column_width' => '',
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'formatting' => 'none',
			'maxlength' => '',
		),
		array (
			'key' => 'field_'.$block.'_4',
			'label' => 'Button Type',
			'name' => 'button_type',
			'type' => 'select',
			'column_width' => '',
			'choices' => array (
				'page' => 'Page',
				'link' => 'Link',
				'file' => 'File',
			),
			'default_value' => '',
			'allow_null' => 0,
			'multiple' => 0,
		),
		array (
			'key' => 'field_'.$block.'_5',
			'label' => 'Button Link',
			'name' => 'button_link',
			'type' => 'text',
			'conditional_logic' => array (
				'status' => 1,
				'rules' => array (
					array (
						'field' => 'field_'.$block.'_4',
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
			'key' => 'field_'.$block.'_6',
			'label' => 'Button Page',
			'name' => 'button_page',
			'type' => 'page_link',
			'conditional_logic' => array (
				'status' => 1,
				'rules' => array (
					array (
						'field' => 'field_'.$block.'_4',
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
			'name' => 'button_file',
			'type' => 'file',
			'conditional_logic' => array (
				'status' => 1,
				'rules' => array (
					array (
						'field' => 'field_'.$block.'_4',
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
	),
);
?>