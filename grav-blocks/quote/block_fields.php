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
		'key' => 'field_'.$block.'_01',
		'label' => 'Quoted Text',
		'name' => 'quoted_text',
		'type' => 'textarea',
		'column_width' => '',
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'formatting' => 'none',
		'maxlength' => '',
	),
	array (
		'key' => 'field_'.$block.'_02',
		'label' => 'Attribution',
		'name' => 'attribution',
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
		'key' => 'field_'.$block.'_03',
		'label' => 'Center Text',
		'name' => 'center',
		'type' => 'true_false',
		'message' => '',
		'default_value' => 0,
	),
);

return array (
	'label' => 'Quote',
	'name' => $block,
	'display' => 'row',
	'min' => '',
	'max' => '',
	'sub_fields' => $block_fields,
	'grav_blocks_settings' => array(
		'icon' => 'gravicon-quote',
		'description' => '<div class="row">
				<div class="columns medium-6">
					<img src="'.plugins_url().'/gravitate-blocks/grav-blocks/quote/quote.svg">
				</div>
				<div class="columns medium-6">
					<p>When you have those amazing quotes from die hard customers, make sure you display them with the importance they deserve. This block allows for the quote, attribution and ability to center the text.</p>
					<p><strong>Available Fields:</strong></p>
					<ul>
						<li>Background</li>
						<li>Quoted Text</li>
						<li>Attribution</li>
						<li>Ability to center text <em>( default is left-aligned )</em></li>
					</ul>
				</div>
			</div>'
	),
);

?>
