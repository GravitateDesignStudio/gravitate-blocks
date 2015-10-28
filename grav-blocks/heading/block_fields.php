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
	'label' => 'Heading',
	'name' => $block,
	'display' => 'row',
	'min' => '',
	'max' => '',
	'sub_fields' => array (
		$block_backgrounds,
		$block_background_image,
		array (
			'key' => 'field_'.$block.'_1',
			'label' => 'Heading',
			'name' => 'heading',
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
			'key' => 'field_'.$block.'_2',
			'label' => 'Sub Heading',
			'name' => 'sub-heading',
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
			'key' => 'field_'.$block.'_3',
			'label' => 'Center Text',
			'name' => 'center',
			'type' => 'true_false',
			'message' => '',
			'default_value' => 0,
		),
	),
);