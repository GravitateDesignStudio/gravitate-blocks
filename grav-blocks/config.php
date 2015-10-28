<?php

/*
* Global variables to use across multiple blocks
*/

$block_background_colors = array (
	'white' => 'White',
	'dark' => 'Blue',
	'darker' => 'Dark Blue',
	'lightest' => 'Light Gray',
	'none' => 'None',
	'image' => 'Image'
);

// Variable for Including Blocks in Flexible Content
$layouts = array();

// Loop through all enabled blocks and set them up
foreach(GRAV_BLOCKS::get_blocks() as $block => $block_path)
{
	$block_backgrounds = array (
		'key' => 'field_'.$block.'_x01',
		'label' => 'Background',
		'name' => 'block_background',
		'type' => 'select',
		'column_width' => '',
		'choices' => $block_background_colors,
		'default_value' => '',
		'allow_null' => 0,
		'multiple' => 0,
	);

	$block_background_image = array (
		'key' => 'field_'.$block.'_x02',
		'label' => 'Background Image',
		'name' => 'block_background_image',
		'type' => 'image',
		'conditional_logic' => array (
			'status' => 1,
			'rules' => array (
				array (
					'field' => 'field_'.$block.'_x01',
					'operator' => '==',
					'value' => 'image',
				),
			),
			'allorany' => 'all',
		),
		'column_width' => '',
		'save_format' => 'object',
		'preview_size' => 'medium',
		'library' => 'all',
	);

	$layouts[$block] = include($block_path.'/block_fields.php');
}

/*
*
* Block Function to build Admin for ACF
*
*/
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_grav_blocks',
		'title' => 'Grav Blocks',
		'fields' => array (
			array (
				'key' => 'field_x1',
				'label' => 'Grav Blocks',
				'name' => 'grav_blocks',
				'type' => 'flexible_content',
				'layouts' => $layouts,
				'button_label' => 'Add Content',
				'min' => '',
				'max' => '',
			),
		),
		'location' => GRAV_BLOCKS::get_locations(),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 100,
	));
}

