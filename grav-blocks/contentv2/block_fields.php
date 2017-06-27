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

$content_column_choices = array();
$block_fields = array();
$num_columns = apply_filters('grav_blocks_content_columns_max', 4);


for( $i = 1; $i <= $num_columns; $i++ ) {
	$content_column_choices[$i] = $i;
}

$block_fields[] = array (
    'key' => 'field_'.$block.'_num_columns',
    'label' => 'Number of Columns',
    'name' => 'num_columns',
    'type' => 'radio',
    'instructions' => '',
    'required' => 0,
    'conditional_logic' => 0,
    'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
    ),
    'choices' => $content_column_choices,
    'other_choice' => 0,
    'save_other_choice' => 0,
    'default_value' => 1,
    'layout' => 'horizontal',
);
$block_fields[] = array (
    'key' => 'field_'.$block.'_format',
    'label' => 'Format',
    'name' => 'format',
    'type' => 'radio',
    'instructions' => '',
    'required' => 0,
    'conditional_logic' => array (
        array (
            array (
                'field' => 'field_'.$block.'_num_columns',
                'operator' => '==',
                'value' => 2,
            ),
        ),
    ),
    'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
    ),
    'choices' => array (
        '' => 'Default',
		'format-sidebar-left' => 'Sidebar Left',
		'format-sidebar-right' => 'Sidebar Right'
    ),
    'other_choice' => 0,
    'save_other_choice' => 0,
    'default_value' => '',
    'layout' => 'horizontal',
);
for( $i = 1; $i <= $num_columns; $i++ ) {
	$block_fields[] = array (
	    'key' => 'field_'.$block.'_'.$i,
	    'label' => 'Column '.$i,
	    'name' => 'column_'.$i,
	    'type' => 'wysiwyg',
	    'instructions' => '',
	    'required' => 0,
	    'conditional_logic' => GRAV_BLOCKS::get_radio_num_conditionals('field_'.$block.'_num_columns', $i, $num_columns),
	    'wrapper' => array (
	        'width' => '',
	        'class' => '',
	        'id' => '',
	    ),
	    'default_value' => '',
	    'tabs' => 'all',         // all | visual | text
	    'toolbar' => 'full',     // full | basic
	    'media_upload' => 1,
	);
}

return array (
	'label' => 'Content',
	'name' => $block,
	'display' => 'block',
	'min' => '',
	'max' => '',
	'sub_fields' => $block_fields,
	'grav_blocks_settings' => array(
		'version' => '2.0',
		'icon' => 'gravicon-content-2col',
		'description' => '<div class="row"><div class="columns medium-6"><img src="'.plugins_url().'/gravitate-blocks/grav-blocks/content/content_1.svg"><img src="'.plugins_url().'/gravitate-blocks/grav-blocks/content/content_2.svg"><img src="'.plugins_url().'/gravitate-blocks/grav-blocks/content/content_3.svg"></div><div class="columns medium-6"><p>Our most basic block. This block allows for the use of one, two or three columns of WordPress WYSIWYGs ( What You See Is What You Get ). The WYSIWYG allows you to add most of the basic types of content from images, to paragraph text as well as H1 – H6 headings. You can also create ordered and unordered lists as well as do type treatments like <strong>bold</strong> and <em>italic</em>.</p>
<p>While this block is very capable and can allow for a range of content types and layouts the control of the layout is not as precise. The tendency would be to try and use this block for much of your layouts, however with the research and strategy that has gone into each one of our blocks we highly suggest looking into them for their abilities to display your content in atheistically pleasing and user friendly way.</p></div></div>'
	),
);
