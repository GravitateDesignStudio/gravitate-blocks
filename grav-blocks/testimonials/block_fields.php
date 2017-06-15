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
		'label' => 'Testimonials',
		'name' => 'testimonials',
		'type' => 'repeater',
		'column_width' => '',
		'sub_fields' => array (
			array (
				'key' => 'field_'.$block.'_2',
				'label' => 'Testimonial',
				'name' => 'testimonial',
				'type' => 'textarea',
				'column_width' => '',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'none',
			),
			array (
				'key' => 'field_'.$block.'_3',
				'label' => 'Image',
				'name' => 'image',
				'type' => 'image',
				'instructions' => '(Optional)',
				'column_width' => '',
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_'.$block.'_4',
				'label' => 'Attribution Title',
				'name' => 'attribution',
				'type' => 'text',
				'instructions' => '(Optional)',
				'column_width' => '',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_'.$block.'_attribution_sub_title',
				'label' => 'Attribution Sub Title',
				'name' => 'attribution_sub_title',
				'type' => 'text',
				'instructions' => '(Optional)',
				'column_width' => '',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
		),
		'min' => '1',
		'max' => '',
		'layout' => 'row',
		'button_label' => 'Add Testimonial',
	),
);

return array (
	'label' => 'Testimonials',
	'name' => $block,
	'display' => 'row',
	'min' => '',
	'max' => '',
	'sub_fields' => $block_fields,
	'grav_blocks_settings' => array(
		'icon' => 'gravicon-testimonials',
		'description' => '<div class="row">
				<div class="columns medium-6">
					<img src="'.plugins_url().'/gravitate-blocks/grav-blocks/testimonials/testimonials.svg">
				</div>
				<div class="columns medium-6">
					<p>If you have the need to display multiple quotes with the ability to add an image to each one, such as a business logo. This block is the best choice for that.</p>
					<p><strong>Available Fields:</strong></p>
					<ul>
						<li>Background</li>
						<li>Testimonials <em>( multiple )</em>
							<ul>
								<li>Testimonials</li>
								<li>Image</li>
								<li>Attribution</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>'
	),
);
