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
		'label' => 'Gallery Title',
		'name' => 'gallery_title',
		'type' => 'text',
		'column_width' => '',
		'default_value' => '',
		'instructions' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'formatting' => 'none',
		'maxlength' => '',
	),
	array (
		'key' => 'field_'.$block.'_11',
		'label' => 'Place Item Titles Below Image',
		'name' => 'move_title',
		'type' => 'true_false',
		'instructions' => 'By default, individual gallery item titles show above their respective images.',
		'message' => '',
		'default_value' => 0,
	),
	array (
		'key' => 'field_'.$block.'_2',
		'label' => 'Gallery Items',
		'name' => 'gallery_items',
		'type' => 'repeater',
		'column_width' => '',
		'instructions' => '',
		'sub_fields' => array (
			array (
				'key' => 'field_'.$block.'_8',
				'label' => 'Item Title',
				'name' => 'item_title',
				'type' => 'text',
				'column_width' => '',
				'default_value' => '',
				'instructions' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_'.$block.'_9',
				'label' => 'Image',
				'name' => 'item_image',
				'instructions' => '',
				'type' => 'image',
				'column_width' => '',
				'save_format' => 'object',
				'library' => 'all',
				'preview_size' => 'medium',
			),
			GRAV_BLOCKS::get_link_fields( 'link', '', false ),
			array (
				'key' => 'field_'.$block.'_10',
				'label' => 'Content',
				'name' => 'item_content',
				'type' => 'textarea',
				'column_width' => '',
				'default_value' => '',
			),
		),
		'min' => '1',
		'max' => '',
		'layout' => 'row',
		'button_label' => 'Add Gallery Item',
	),
);
$sub_fields = array_merge(GRAV_BLOCKS::get_additional_fields(), $block_fields);

return array (
	'name' => $block,
	'label' => 'Media Gallery (D)',
	'display' => 'block',
	'sub_fields' => $sub_fields,
	'min' => '',
	'max' => '',
	'grav_blocks_settings' => array(
		'icon' => 'gravicon-gallery',
		'deprecated' => 1,
		'description' => '<div class="row">
				<div class="columns medium-6">
					<img src="'.plugins_url().'/gravitate-blocks/grav-blocks/media-gallery/gallery.svg">
				</div>
				<div class="columns medium-6">
					<p>When you want to display more than one image, this flexible block is the way to go. It allows for multiple gallery items each with an ability for a title, image, link and description. Each image will also display in a gallery modal if no link is clicked.</p>
					<p><strong>Available Fields:</strong></p>
					<ul>
						<li>Background</li>
						<li>Gallery Title</li>
						<li>Gallery Item
							<ul>
								<li>Item Title</li>
								<li>Image</li>
								<li>Link <em>( Page, URL, File, Video )</em></li>
								<li>Description</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>'
	),
);
