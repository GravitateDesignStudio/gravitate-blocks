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
		'key' => 'field_'.$block.'_repeater',
		'label' => 'Quotes',
		'name' => 'quotes',
		'type' => 'repeater',
		'column_width' => '',
		'sub_fields' => array (
			array (
				'key' => 'field_'.$block.'_quote',
				'label' => 'Quote',
				'name' => 'quote',
				'type' => 'textarea',
				'column_width' => '',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'none',
			),
			array (
				'key' => 'field_'.$block.'_image',
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
				'key' => 'field_'.$block.'_attribution_title',
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
		'button_label' => 'Add Quote',
	),
	array (
	   'key' => 'field_'.$block.'_slider_loop',
	   'label' => 'Slider Loop',
	   'name' => 'slider_loop',
	   'type' => 'true_false',
	   'instructions' => '',
	   'required' => 0,
	   'conditional_logic' => 0,
	   'wrapper' => array (
	       'width' => '',
	       'class' => '',
	       'id' => '',
	   ),
	   'message' => '',
	   'ui' => 1,
	   'ui_on_text' => 'Yes',
	   'ui_off_text' => 'No',
	   'default_value' => 1,
	   'block_option' => 1,
	   'block_data_attribute' => 1,
	),
	array (
	   'key' => 'field_'.$block.'_slider_autoheight',
	   'label' => 'Slider Auto Height',
	   'name' => 'slider_autoheight',
	   'type' => 'true_false',
	   'instructions' => 'Adjusts the height of each slide to fit its container',
	   'required' => 0,
	   'conditional_logic' => 0,
	   'wrapper' => array (
	       'width' => '',
	       'class' => '',
	       'id' => '',
	   ),
	   'message' => '',
	   'ui' => 1,
	   'ui_on_text' => 'Yes',
	   'ui_off_text' => 'No',
	   'default_value' => 1,
	   'block_option' => 1,
	   'block_data_attribute' => 1,
	),
	array (
	    'key' => 'field_'.$block.'_slider_speed',
	    'label' => 'Slider Transition Speed',
	    'name' => 'slider_speed',
	    'type' => 'number',
	    'instructions' => '',
	    'required' => 0,
	    'conditional_logic' => 0,
	    'wrapper' => array (
	        'width' => '',
	        'class' => '',
	        'id' => '',
	    ),
	    'default_value' => '0.5',
	    'placeholder' => '',
	    'prepend' => '',
	    'append' => 'seconds',
	    'min' => '0',
	    'max' => '10',
	    'step' => '0.01',
	    'readonly' => 0,
	    'disabled' => 0,
		'block_option' => 1,
 	    'block_data_attribute' => 1,
	),
	array (
	    'key' => 'field_'.$block.'_slider_autoplay',
	    'label' => 'Slider Transition Delay',
	    'name' => 'slider_autoplay',
	    'type' => 'number',
	    'instructions' => 'Set to 0 to disable.',
	    'required' => 0,
	    'conditional_logic' => 0,
	    'wrapper' => array (
	        'width' => '',
	        'class' => '',
	        'id' => '',
	    ),
	    'default_value' => '6',
	    'placeholder' => '',
	    'prepend' => '',
	    'append' => 'seconds',
	    'min' => '0',
	    'max' => '',
	    'step' => '0.01',
	    'readonly' => 0,
	    'disabled' => 0,
		'block_option' => 1,
 	    'block_data_attribute' => 1,
	),
	array (
	    'key' => 'field_'.$block.'_slider_effect',
	    'label' => 'Slider Effect',
	    'name' => 'slider_effect',
	    'type' => 'radio',
	    'instructions' => '',
	    'required' => 0,
	    'conditional_logic' => 0,
	    'wrapper' => array (
	        'width' => '',
	        'class' => '',
	        'id' => '',
	    ),
	    'choices' => array (
	        'fade' => 'Fade',
	        'slide' => 'Slide'
	    ),
	    'other_choice' => 0,
	    'save_other_choice' => 0,
	    'default_value' => 'fade',
	    'layout' => 'horizontal',
		'block_option' => 1,
 	    'block_data_attribute' => 1,
	),
);

return array (
	'label' => 'Quotes',
	'name' => $block,
	'display' => 'row',
	'min' => '',
	'max' => '',
	'sub_fields' => $block_fields,
	'grav_blocks_settings' => array(
		'icon' => 'gravicon-quotes',
		'description' => '<div class="row">
				<div class="columns medium-6">
					<img src="'.plugins_url().'/gravitate-blocks/grav-blocks/quotes/block.svg">
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
