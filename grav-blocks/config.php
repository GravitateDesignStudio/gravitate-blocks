<?php

/*
* Global variables to use across multiple blocks
*/

$block_background_colors = array();


$block_background_colors['block-bg-none'] = 'None';
if(!empty(GRAV_BLOCKS::$settings['background_colors']))
{
	foreach (GRAV_BLOCKS::$settings['background_colors'] as $color_key => $color_params)
	{
		$block_background_colors[(!empty($color_params['class']) ? $color_params['class'] : 'block-bg-'.sanitize_title($color_params['name']))] = $color_params['name'];
	}
}
$block_background_colors['block-bg-image'] = 'Image';

// Variable for Including Blocks in Flexible Content
$layouts = array();

// Loop through all enabled blocks and set them up
foreach(GRAV_BLOCKS::get_blocks() as $block => $block_params)
{
	if(!empty($block_params['path']))
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
						'value' => 'block-bg-image',
					),
				),
				'allorany' => 'all',
			),
			'column_width' => '',
			'save_format' => 'object',
			'preview_size' => 'medium',
			'library' => 'all',
		);

		if(file_exists($block_params['path'].'/block_fields.php'))
		{
			$layouts[$block] = include($block_params['path'].'/block_fields.php');
		}
	}
}

/*
*
* Block Function to build Admin for ACF
*
*/
if(function_exists("acf_add_local_field_group") && !empty($layouts))
{
	$layouts = apply_filters( 'grav_block_fields', $layouts );

	acf_add_local_field_group(array (
		'key' => 'group_grav_blocks',
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
		'menu_order' => 100,
		'position' => 'normal',
		'style' => 'no_box',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));
}

