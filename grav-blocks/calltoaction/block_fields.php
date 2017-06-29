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

$gforms = array(0 => '- None');

foreach(GRAV_BLOCKS::get_gravity_forms() as $gform)
{
	$gforms[$gform['id']] = $gform['title'];
}


$block_fields = array(
	array (
		'key' => 'field_'.$block.'_1',
		'label' => 'Title (optional)',
		'name' => 'title',
		'type' => 'text',
		'column_width' => '',
		'default_value' => '',
		'instructions' => 'This block is deprecated, please use the new version.',
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
		'min' => '1',
		'max' => '',
		'layout' => 'block',
		'button_label' => 'Add Button',
		'sub_fields' => array(
			GRAV_BLOCKS::get_link_fields( 'button')
		),
	),
	array (
	    'key' => 'field_'.$block.'_form',
	    'label' => 'Form',
	    'name' => 'form',
	    'type' => 'select',
	    'instructions' => '',
	    'required' => 0,
	    'conditional_logic' => 0,
	    'wrapper' => array (
	        'width' => '',
	        'class' => '',
	        'id' => '',
	    ),
	    'choices' => $gforms,
	    'default_value' => array (
	    ),
	    'allow_null' => 0,
	    'multiple' => 0,         // allows for multi-select
	    'ui' => 0,               // creates a more stylized UI
	    'ajax' => 0,
	    'placeholder' => '',
	    'disabled' => 0,
	    'readonly' => 0,
	),
	array (
		'key' => 'field_'.$block.'_center_content',
		'label' => 'Center Content',
		'name' => 'center',
		'type' => 'true_false',
		'message' => '',
		'default_value' => 0,
	),
);

return array (
	'label' => 'Call to Action (D)',
	'name' => $block,
	'display' => 'row',
	'min' => '',
	'max' => '',
	'sub_fields' => $block_fields,
	'grav_blocks_settings' => array(
		'version' => '1.0',
		'icon' => 'gravicon-cta',
		'deprecated' => 1,
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
