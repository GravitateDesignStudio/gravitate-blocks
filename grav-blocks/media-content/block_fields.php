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
	    'key' => 'field_'.$block.'_media_type',
	    'label' => 'Media Type',
	    'name' => 'media_type',
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
	        '' => 'Image', // Leave this blank to allow for older versions to work.
			'video' => 'MP4 Video',
			'embed' => 'Embed'
	    ),
	    'other_choice' => 0,
	    'save_other_choice' => 0,
	    'default_value' => '',
	    'layout' => 'horizontal',
	),
	array (
		'key' => 'field_'.$block.'_video_type',
		'label' => 'MP4 Video Type',
		'name' => 'video_type',
		'type' => 'radio',
		'instructions' => 'It is best to use the URL as uploading videos can take up a lot of your hosting disk space and bandwidth.',
		'required' => 0,
		'conditional_logic' => array (
			array (
				array (
		            'field' => 'field_'.$block.'_media_type',
		            'operator' => '==',
		            'value' => 'video',
		        ),
			),
		),
		'wrapper' => array (
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'choices' => array (
			'url' => 'Url',
			'file' => 'File'
		),
		'other_choice' => 0,
		'save_other_choice' => 0,
		'default_value' => 'url',
		'layout' => 'horizontal',
	),
	array (
		'key' => 'field_'.$block.'_video_url',
		'label' => 'Video URL',
		'name' => 'video_url',
		'type' => 'text',
		'instructions' => 'Video must be a MP4 Format. <br><br>Use the Background Image below for a Placeholder',
		'conditional_logic' => array (
			array (
				array (
					'field' => 'field_'.$block.'_video_type',
					'operator' => '==',
					'value' => 'url',
				),
				array (
		            'field' => 'field_'.$block.'_media_type',
		            'operator' => '==',
		            'value' => 'video',
		        ),
			),
		),
		'column_width' => '',
		'save_format' => 'object',
		'preview_size' => 'medium',
		'library' => 'all',
	),
	array (
		'key' => 'field_'.$block.'_video_file',
		'label' => 'Video File',
		'name' => 'video_file',
		'type' => 'file',
		'instructions' => 'Uploads may not work if the file is too large.',
		'required' => 0,
		'conditional_logic' => array (
			array (
				array (
					'field' => 'field_'.$block.'_video_type',
					'operator' => '==',
					'value' => 'file',
				),
				array (
		            'field' => 'field_'.$block.'_media_type',
		            'operator' => '==',
		            'value' => 'video',
		        ),
			),
		),
		'wrapper' => array (
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'return_format' => 'url',      // array | url | id
		'library' => 'all',              // all | uploadedTo
		'min_size' => '',
		'max_size' => '',
		'mime_types' => '',
	),
	array (
	    'key' => 'field_'.$block.'_video_attributes',
	    'label' => 'Video Attributes',
	    'name' => 'video_attributes',
	    'type' => 'checkbox',
	    'instructions' => '',
	    'required' => 0,
		'conditional_logic' => array (
			array (
				array (
		            'field' => 'field_'.$block.'_media_type',
		            'operator' => '==',
		            'value' => 'video',
		        ),
			),
		),
	    'wrapper' => array (
	        'width' => '',
	        'class' => '',
	        'id' => '',
	    ),
	    'choices' => array (
	        'autoplay' => 'Autoplay',
			'loop' => 'Loop',
	        'controls' => 'Controls',
	        'muted' => 'Muted',
	    ),
	    'default_value' => array (
			'controls'
	    ),
	    'layout' => 'horizontal',
	    'toggle' => 0,
	),
	array (
	    'key' => 'field_'.$block.'_embed',
	    'label' => 'Embed',
	    'name' => 'embed',
	    'type' => 'textarea',
	    'instructions' => '',
	    'required' => 0,
		'conditional_logic' => array (
			array (
				array (
		            'field' => 'field_'.$block.'_media_type',
		            'operator' => '==',
		            'value' => 'embed',
		        ),
			),
		),
	    'wrapper' => array (
	        'width' => '',
	        'class' => '',
	        'id' => '',
	    ),
	    'default_value' => '',
	    'placeholder' => '',
	    'maxlength' => '',
	    'rows' => '',
	    'new_lines' => 'wpautop',        // wpautop | br | ''
	    'readonly' => 0,
	    'disabled' => 0,
	),
	array (
		'key' => 'field_'.$block.'_4',
		'label' => 'Image',
		'name' => 'image',
		'prefix' => '',
		'type' => 'image',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => array (
		    array (
		        array (
		            'field' => 'field_'.$block.'_media_type',
		            'operator' => '==',
		            'value' => '',
		        ),
		    ),
		),
		'column_width' => '',
		'return_format' => 'array',
		'preview_size' => 'medium',
		'library' => 'all',
	),
	array (
		'key' => 'field_'.$block.'_1',
		'label' => 'Media Placement',
		'name' => 'image_placement',
		'prefix' => '',
		'type' => 'radio',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'column_width' => '',
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
		'key' => 'field_'.$block.'_2',
		'label' => 'Media Size',
		'name' => 'image_size',
		'prefix' => '',
		'type' => 'radio',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'column_width' => '',
		'choices' => GRAV_BLOCKS::column_width_options(),
		'other_choice' => 0,
		'save_other_choice' => 0,
		'default_value' => '5',
		'layout' => 'horizontal',
		'block_options' => 1
	),
	GRAV_BLOCKS::get_link_fields( 'link', '', false ),
	array (
		'key' => 'field_'.$block.'_3',
		'label' => 'Content',
		'name' => 'content',
		'prefix' => '',
		'type' => 'wysiwyg',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'column_width' => '',
		'default_value' => '',
		'tabs' => 'all',
		'toolbar' => 'full',
		'media_upload' => 0,
	),
);

return array (
	'name' => $block,
	'label' => 'Media with Content',
	'display' => 'row',
	'sub_fields' => $block_fields,
	'min' => '',
	'max' => '',
	'grav_blocks_settings' => array(
		'icon' => 'gravicon-content-media',
		'description' => '<div class="row">
				<div class="columns medium-6">
					<img src="'.plugins_url().'/gravitate-blocks/grav-blocks/media-content/media-content.svg">
					<img src="'.plugins_url().'/gravitate-blocks/grav-blocks/media-content/media-content-alt.svg">
				</div>
				<div class="columns medium-6">
					<p>When you want to have an image and then more of a description to that image, this is the block you want. The image has the ability to link to a page, URL, file or video. While the WYSIWYG allows for heading and paragraph text.</p>
					<p><strong>Available Fields:</strong></p>
					<ul>
						<li>Background</li>
						<li>Image</li>
						<li>Image Placement <em>( left or right side )</em></li>
						<li>Image Size <em>( small, medium, half width or large )</em></li>
						<li>Link Type <em>( none, page, URL, file, video )</em></li>
					</ul>
				</div>
			</div>'
	),
);
