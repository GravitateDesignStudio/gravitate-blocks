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

$plugins_url = plugins_url();

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
		'icon' => 'gravicon-content-1col',
		'description' => '<div class="row"><div class="columns medium-6"><img src="'.$plugins_url.'/gravitate-blocks/grav-blocks/content/content_1.svg"><img src="'.$plugins_url.'/gravitate-blocks/grav-blocks/content/content_2.svg"><img src="'.$plugins_url.'/gravitate-blocks/grav-blocks/content/content_3.svg"></div><div class="columns medium-6"><p>Integer sollicitudin sapien eget tristique sodales. Fusce pellentesque tincidunt nisi vitae mattis. Donec placerat enim sit amet tempor semper. Proin vel gravida odio. Quisque mollis augue eu nisi cursus, eget imperdiet lectus lobortis. Nulla ut ultrices velit, eu pretium eros. Quisque in turpis scelerisque, tempus nulla id, consequat dui.</p><p>Fusce vel consectetur enim. Phasellus nisl enim, tincidunt sed dui vel, dictum ullamcorper arcu. Quisque ex est, tincidunt id quam vitae, viverra laoreet est. Donec venenatis ornare condimentum. Aliquam erat volutpat. Aenean turpis arcu, tincidunt vel malesuada eu, fringilla ac metus. In non lectus sed augue ullamcorper sagittis.</p></div></div>'
	),
);