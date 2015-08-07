<?php


/*
* Global variables to use across multiple blocks
*/
$acf_block_background_colors = array (
	'white' => 'White',
	'dark' => 'Blue',
	'darker' => 'Dark Blue',
	'lightest' => 'Light Gray',
	'none' => 'None',
	'image' => 'Image'
);




/*
*
* Build out blocks from sub-directories
* You will need a "block.php" file for the block layout
* and a "block_acf.php" file for the acf for the block
*
*/
$files = array();
$layouts = array();
$directory = get_stylesheet_directory().'/parts/blocks';

if (! is_dir($directory)) {
    exit('Invalid directory path');
}

$dirs = array_filter(glob($directory.'/*'), 'is_dir');
foreach($dirs as $dir){
	foreach (scandir($dir) as $file) {
	    if ('.' === $file) continue;
	    if ('..' === $file) continue;
	    if (fnmatch("*_acf.php", $file)) {
			$files[] = $file;
		}
	}
}

foreach($files as $file){
	$block = preg_replace('/_acf.php/', '', $file);
	$acf_background = array (
		'key' => 'field_'.$block.'_x000000000001',
		'label' => 'Background',
		'name' => 'block_background',
		'type' => 'select',
		'column_width' => '',
		'choices' => $acf_block_background_colors,
		'default_value' => '',
		'allow_null' => 0,
		'multiple' => 0,
	);
	$acf_background_image = array (
		'key' => 'field_'.$block.'_x000000000002',
		'label' => 'Background Image',
		'name' => 'block_background_image',
		'type' => 'image',
		'conditional_logic' => array (
			'status' => 1,
			'rules' => array (
				array (
					'field' => 'field_'.$block.'_x000000000001',
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
	include($block.'/'.$file);
	$layouts[$block] = $acf_layout;
	$acf_layout = '';
}




/*
*
* Block Function to build Admin for ACF
*
*/
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_content-blocks',
		'title' => 'Content Blocks',
		'fields' => array (
			array (
				'key' => 'field_1000000000001',
				'label' => 'Content Blocks',
				'name' => 'blocks',
				'type' => 'flexible_content',
				'layouts' => $layouts,
				'button_label' => 'Add Content',
				'min' => '',
				'max' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 2,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 100,
	));
}
