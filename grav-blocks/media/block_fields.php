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
		'label' => 'Full Width Image',
		'name' => 'full_width_image',
		'type' => 'image',
		'column_width' => '',
		'save_format' => 'object',
		'preview_size' => 'medium',
		'library' => 'all',
	),
	array (
		'key' => 'field_'.$block.'_2',
		'label' => 'Add Padding',
		'name' => 'padding',
		'type' => 'true_false',
		'column_width' => '',
		'message' => '',
		'default_value' => 0,
	),
	GRAV_BLOCKS::get_link_fields( 'link', '', false),
);

return array (
	'label' => 'Media',
	'name' => $block,
	'display' => 'row',
	'min' => '',
	'max' => '',
	'sub_fields' => $block_fields,
	'grav_blocks_settings' => array(
		'icon' => 'gravicon-media',
		'description' => '<div class="row">
				<div class="columns medium-6">
					<img src="'.plugins_url().'/gravitate-blocks/grav-blocks/media/media.svg">
					<img src="'.plugins_url().'/gravitate-blocks/grav-blocks/media/media-alt.svg">
				</div>
				<div class="columns medium-6">
					<p>This block that allows for a full width image, or an image that is contained within the content width. This image also has the ability to link to a page, URL, file download or even play a video in a modal.</p>
					<p><strong>Available Fields:</strong></p>
					<ul>
						<li>Background<em> ( for a two layered image effect )</em></li>
						<li>Image</li>
						<li>Add Padding <em>( constrains image to width of content instead of full screen )</em></li>
						<li>Link <em>( Page, URL, File, Video )</em></li>
					</ul>
				</div>
			</div>'
	),
);
