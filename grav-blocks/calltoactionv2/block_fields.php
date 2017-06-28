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

$gforms = array(0 => '- None');

foreach(GRAV_BLOCKS::get_gravity_forms() as $gform)
{
	$gforms[$gform['id']] = $gform['title'];
}

$calltoaction_column_choices = array();
$block_fields = array();
$num_columns = apply_filters('grav_blocks_calltoaction_columns_max', 3);

for( $i = 1; $i <= $num_columns; $i++ ) {
	$calltoaction_column_choices[$i] = $i;
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
    'choices' => $calltoaction_column_choices,
    'other_choice' => 0,
    'save_other_choice' => 0,
    'default_value' => 1,
    'layout' => 'horizontal',
);

for( $i = 1; $i <= $num_columns; $i++ ) {
	//Setup background fields
	$background_fields = GRAV_BLOCKS::get_background_fields($block, 'Background ' . $i, 'background_' . $i);

	//Rename background fields
	foreach ($background_fields as $key => $field) {

		$background_fields[$key]['name'] = $field['name'] . '_'. $i;
	}

	// Add conditional_logic to background color select field
	foreach ($background_fields as $key => $field) {
		if ($field['name'] == 'block_background_' . $i) {
			if ($background_fields[$key]['conditional_logic'] == 0) {
				$column_conditionals = GRAV_BLOCKS::get_radio_num_conditionals('field_'.$block.'_num_columns', $i, $num_columns);

				$background_fields[$key]['conditional_logic'] = $column_conditionals;
			}
		}
	}

	//Merge block_fields with background_fields
	$block_fields = array_merge_recursive($block_fields, $background_fields);

	$block_fields[] = array (
		'key' => 'field_'.$block.'_title_'.$i,
		'label' => 'Title (optional) '.$i,
		'name' => 'title_'.$i,
		'type' => 'text',
		'conditional_logic' => GRAV_BLOCKS::get_radio_num_conditionals('field_'.$block.'_num_columns', $i, $num_columns),
		'column_width' => '',
		'default_value' => '',
		'instructions' => 'This is the title of the section.',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'formatting' => 'none', 		// none | html
		'maxlength' => '',
	);
	$block_fields[] = array (
		'key' => 'field_'.$block.'_description_'.$i,
		'label' => 'Description (optional) '.$i,
		'name' => 'description_'.$i,
		'type' => 'textarea',
		'conditional_logic' => GRAV_BLOCKS::get_radio_num_conditionals('field_'.$block.'_num_columns', $i, $num_columns),
		'instructions' => 'This is the description of the section.',
		'default_value' => '',
		'placeholder' => '',
		'maxlength' => '',
		'rows' => '',
		'formatting' => 'html',
	);
	$block_fields[] = array (
		'key' => 'field_'.$block.'_buttons_'.$i,
		'label' => 'Buttons '.$i,
		'name' => 'buttons_'.$i,
		'type' => 'repeater',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => GRAV_BLOCKS::get_radio_num_conditionals('field_'.$block.'_num_columns', $i, $num_columns),
		'wrapper' => array (
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'collapsed' => '',
		'min' => '1',
		'max' => '',
		'layout' => 'block',
		'button_label' => 'Add Button',
		'sub_fields' => array(
			GRAV_BLOCKS::get_link_fields( 'button')
		),
	);
	$block_fields[] = array (
	    'key' => 'field_'.$block.'_form_'.$i,
	    'label' => 'Form '.$i,
	    'name' => 'form_'.$i,
	    'type' => 'select',
	    'instructions' => '',
	    'required' => 0,
	    'conditional_logic' => GRAV_BLOCKS::get_radio_num_conditionals('field_'.$block.'_num_columns', $i, $num_columns),
	    'wrapper' => array (
	        'width' => '',
	        'class' => '',
	        'id' => '',
	    ),
	    'choices' => $gforms,
	    'default_value' => array (
	    ),
	    'allow_null' => 0,
	    'multiple' => 0,         // allows for multi-select
	    'ui' => 0,               // creates a more stylized UI
	    'ajax' => 0,
	    'placeholder' => '',
	    'disabled' => 0,
	    'readonly' => 0,
	);
	$block_fields[] = array (
	    'key' => 'field_'.$acf_group.'_alignment_' . $i,
	    'label' => 'Alignment '.$i,
	    'name' => 'alignment_' . $i,
	    'type' => 'radio',
	    'instructions' => '',
	    'required' => 0,
	    'conditional_logic' => GRAV_BLOCKS::get_radio_num_conditionals('field_'.$block.'_num_columns', $i, $num_columns),
	    'wrapper' => array (
	        'width' => '',
	        'class' => '',
	        'id' => '',
	    ),
	    'choices' => array (
	        'left' => 'Left',
	        'center' => 'Center',
	        'right' => 'Right ',
	    ),
	    'other_choice' => 0,
	    'save_other_choice' => 0,
	    'default_value' => 'left',
	    'layout' => 'horizontal',
	);
}

return array (
	'label' => 'Call to Action',
	'name' => $block,
	'display' => 'row',
	'min' => '',
	'max' => '',
	'sub_fields' => $block_fields,
	'grav_blocks_settings' => array(
		'version' => '2.0',
		'icon' => 'gravicon-cta',
		'description' => '<div class="row">
				<div class="columns medium-6">
					<img src="'.plugins_url().'/gravitate-blocks/grav-blocks/calltoaction/cta.svg">
				</div>
				<div class="columns medium-6">
					<p>With this block, you can create buttons&nbsp;for any needed conversion. Whether it’s to direct the user to the contact page or download a white-paper, this block will allow multiple buttons, each with the ability to link to a current page on the site, a specified URL, a file to download, or video to play in a modal.</p>
					<p><strong>Available Fields:</strong></p>
					<ul>
						<li>Title</li>
						<li>Description</li>
						<li>Background</li>
						<li>Buttons <em>( Multiple )</em></li>
					</ul>
				</div>
			</div>'
	),
);
