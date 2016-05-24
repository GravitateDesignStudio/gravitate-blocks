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
		'label' => 'Description (optional)',
		'name' => 'description',
		'type' => 'textarea',
		'instructions' => 'This is the description of the section.',
		'default_value' => '',
		'placeholder' => '',
		'maxlength' => '',
		'rows' => '',
		'formatting' => 'html',
	),
	array (
		'key' => 'field_'.$block.'_3',
		'label' => 'Buttons',
		'name' => 'buttons',
		'type' => 'repeater',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array (
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'collapsed' => '',
		'min' => '',
		'max' => '',
		'layout' => 'block',
		'button_label' => 'Add Button',
		'sub_fields' => array (
			GRAV_BLOCKS::get_link_fields( 'button' ),
		),
	),
);
$sub_fields = array_merge(GRAV_BLOCKS::get_additional_fields(), $block_fields);

return array (
	'label' => 'Call to Action',
	'name' => $block,
	'display' => 'row',
	'min' => '',
	'max' => '',
	'sub_fields' => $sub_fields,
	'grav_blocks_settings' => array(
		'icon' => 'gravicon-cta',
		'description' => '<div class="row">
				<div class="columns medium-6">
					<img src="'.plugins_url().'/gravitate-blocks/grav-blocks/calltoaction/cta.svg">
				</div>
				<div class="columns medium-6">
					<p>With this block, you can create buttons&nbsp;for any needed conversion. Whether it’s to direct the user to the contact page or download a white-paper, this block will allow multiple buttons, each with the ability to link to a current page on the site, a specified URL, a file to download, or video to play in a modal.</p>
					<p><strong>Available Fields:</strong></p>
					<ul>
						<li>Title</li>
						<li>Description</li>
						<li>Background</li>
						<li>Buttons <em>( Multiple )</em></li>
					</ul>
				</div>
			</div>'
	),
);
?>
