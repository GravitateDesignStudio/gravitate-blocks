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
	    'key' => 'field_'.$block.'_instructions',
	    'label' => 'Instructions',
	    'name' => 'instructions',
	    'type' => 'message',
	    'instructions' => 'To get the coordinates of your location, use <a href="http://www.latlong.net/convert-address-to-lat-long.html" target="_blank">Get Lat Long from Address</a>.',
	    'required' => 0,
	    'conditional_logic' => 0,
	    'wrapper' => array (
	        'width' => '',
	        'class' => '',
	        'id' => '',
	    ),
	    'message' => '',
	    'new_lines' => 'wpautop',    // wpautop | br | ''
	    'esc_html' => 0,             // uses the WordPress esc_html function
	),
	array (
		'key' => 'field_'.$block.'_format',
		'label' => 'Format',
		'name' => 'format',
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
			'map' => 'Map Only',
			'small-map' => 'Small Map w/ Content',
			// 'large-map' => 'Large Map w/ Content'
		),
		'other_choice' => 0,
		'save_other_choice' => 0,
		'default_value' => 'map',
		'layout' => 'horizontal',
	),
	array (
	    'key' => 'field_'.$block.'_map_position',
	    'label' => 'Map Position',
	    'name' => 'map_position',
	    'type' => 'radio',
	    'instructions' => '',
	    'required' => 0,
	    'conditional_logic' => array (
	        'status' => 1,
	        'rules' => array (
	            array (
	               'field' => 'field_'.$block.'_format',
	                'operator' => '!=',
	               'value' => 'map',
	          ),
	        ),
	        'allorany' => 'all',
	    ),
	    'wrapper' => array (
	        'width' => '',
	        'class' => '',
	        'id' => '',
	    ),
	    'choices' => array (
	        'left' => 'Left',
	        'right' => 'Right',
	    ),
	    'other_choice' => 0,
	    'save_other_choice' => 0,
	    'default_value' => 'left',
	    'layout' => 'horizontal',
	),
	array (
	    'key' => 'field_'.$block.'_zoom_offset',
	    'label' => 'Zoom Offset',
	    'name' => 'zoom_offset',
	    'type' => 'number',
	    'instructions' => '',
	    'required' => 0,
	    'conditional_logic' => 0,
	    'wrapper' => array (
	        'width' => '',
	        'class' => '',
	        'id' => '',
	    ),
	    'default_value' => 0,
	    'placeholder' => '',
	    'prepend' => '',
	    'append' => '',
	    'min' => '',
	    'max' => '',
	    'step' => '',
	    'readonly' => 0,
	    'disabled' => 0,
	),
	//If content use wysiwyg
	array (
	    'key' => 'field_'.$block.'_markers',
	    'label' => 'Markers',
	    'name' => 'markers',
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
	    'layout' => 'table',         // table | block | row
	    'button_label' => 'Add Marker',
	    'sub_fields' => array (
			array (
			    'key' => 'field_'.$block.'_marker_name',
			    'label' => 'Name',
			    'name' => 'marker_name',
			    'type' => 'text',
			    'instructions' => '',
			    'required' => 0,
			    'conditional_logic' => 0,
			    'wrapper' => array (
			        'width' => '',
			        'class' => '',
			        'id' => '',
			    ),
			    'default_value' => '',
			    'placeholder' => '',
			    'formatting' => 'none',       // none | html
			    'prepend' => '',
			    'append' => '',
			    'maxlength' => '',
			    'readonly' => 0,
			    'disabled' => 0,
			),
			array (
				'key' => 'field_'.$block.'_info_window',
				'label' => 'Info Window Text',
				'name' => 'info_window',
			    'type' => 'text',
			    'instructions' => '',
			    'required' => 0,
			    'conditional_logic' => 0,
			    'wrapper' => array (
			        'width' => '',
			        'class' => '',
			        'id' => '',
			    ),
			    'default_value' => '',
			    'placeholder' => '',
			    'formatting' => 'none',       // none | html
			    'prepend' => '',
			    'append' => '',
			    'maxlength' => '',
			    'readonly' => 0,
			    'disabled' => 0,
			),
	        array (
	            'key' => 'field_'.$block.'_lattitude',
	            'label' => 'Lattitude',
	            'name' => 'lattitude',
	            'type' => 'text',
	            'instructions' => '',
	            'required' => 0,
	            'conditional_logic' => 0,
	            'wrapper' => array (
	                'width' => '25',
	                'class' => '',
	                'id' => '',
	            ),
	            'default_value' => '',
	            'placeholder' => '',
	            'formatting' => 'none',       // none | html
	            'prepend' => '',
	            'append' => '',
	            'maxlength' => '',
	            'readonly' => 0,
	            'disabled' => 0,
	        ),
			array (
			    'key' => 'field_'.$block.'_longitude',
			    'label' => 'Longitude',
			    'name' => 'longitude',
			    'type' => 'text',
			    'instructions' => '',
			    'required' => 0,
			    'conditional_logic' => 0,
			    'wrapper' => array (
			        'width' => '25',
			        'class' => '',
			        'id' => '',
			    ),
			    'default_value' => '',
			    'placeholder' => '',
			    'formatting' => 'none',       // none | html
			    'prepend' => '',
			    'append' => '',
			    'maxlength' => '',
			    'readonly' => 0,
			    'disabled' => 0,
			),
	    ),
	),
	array (
	    'key' => 'field_'.$block.'_content',
	    'label' => 'Content',
	    'name' => 'content',
	    'type' => 'wysiwyg',
	    'instructions' => '',
	    'required' => 0,
	    'conditional_logic' => array (
	        'status' => 1,
	        'rules' => array (
	            array (
	               'field' => 'field_'.$block.'_format',
	                'operator' => '!=',
	               'value' => 'map',
	          ),
	        ),
	        'allorany' => 'all',
	    ),
	    'wrapper' => array (
	        'width' => '',
	        'class' => '',
	        'id' => '',
	    ),
	    'default_value' => '',
	    'tabs' => 'all',         // all | visual | text
	    'toolbar' => 'full',     // full | basic
	    'media_upload' => 1,
	),
);

return array (
	'label' => 'Google Map',
	'name' => $block,
	'display' => 'block',
	'min' => '',
	'max' => 1,
	'sub_fields' => $block_fields,
	'grav_blocks_settings' => array(
		'icon' => 'gravicon-map',
		'description' => '<div class="row">
				<div class="columns medium-6">
					<img src="'.plugins_url().'/gravitate-blocks/grav-blocks/map/map.svg">
					<img src="'.plugins_url().'/gravitate-blocks/grav-blocks/map/map-alt.svg">
				</div>
				<div class="columns medium-6">
					<p>This block requires a Google Maps API Key. You can get an API Key <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">here</a></a>.</p>
					<p><strong>Available Fields:</strong></p>
					<ul>
						<li>Background</li>
						<li>Format</li>
						<li>Markers</li>
						<li>Zoom Offset</li>
					</ul>
				</div>
			</div>'
	),
);
