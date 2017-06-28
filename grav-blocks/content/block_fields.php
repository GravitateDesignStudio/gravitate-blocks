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


$block_fields = array(
	array (
		'key' => 'field_'.$block.'_1',
		'label' => 'Content Columns',
		'name' => 'content_column',
		'type' => 'repeater',
		'column_width' => '',
		'instructions' => 'This block is deprecated, please use the new version.',
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
		'min' => '1',
		'max' => '3',
		'layout' => 'block',
		'button_label' => 'Add Column',
	),
);

return array (
	'label' => 'Content (D)',
	'name' => $block,
	'display' => 'block',
	'min' => '',
	'max' => '',
	'sub_fields' => $block_fields,
	'grav_blocks_settings' => array(
		'version' => '1.0',
		'icon' => 'gravicon-content-1col',
		'deprecated' => 1,
		// 'group' => 'Deprecated',
		'description' => '<div class="row"><div class="columns medium-6"><img src="'.plugins_url().'/gravitate-blocks/grav-blocks/content/content_1.svg"><img src="'.plugins_url().'/gravitate-blocks/grav-blocks/content/content_2.svg"><img src="'.plugins_url().'/gravitate-blocks/grav-blocks/content/content_3.svg"></div><div class="columns medium-6"><p>Our most basic block. This block allows for the use of one, two or three columns of WordPress WYSIWYGs ( What You See Is What You Get ). The WYSIWYG allows you to add most of the basic types of content from images, to paragraph text as well as H1 – H6 headings. You can also create ordered and unordered lists as well as do type treatments like <strong>bold</strong> and <em>italic</em>.</p>
<p>While this block is very capable and can allow for a range of content types and layouts the control of the layout is not as precise. The tendency would be to try and use this block for much of your layouts, however with the research and strategy that has gone into each one of our blocks we highly suggest looking into them for their abilities to display your content in atheistically pleasing and user friendly way.</p></div></div>'
	),
);
