<?php
	$acf_layout = array (
				'label' => 'Heading',
				'name' => 'heading',
				'display' => 'row',
				'min' => '',
				'max' => '',
				'sub_fields' => array (
					$acf_background,
					$acf_background_image,
					array (
						'key' => 'field_heading_1000000000001',
						'label' => 'Heading',
						'name' => 'heading',
						'type' => 'text',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
					),
					array (
						'key' => 'field_heading_1000000000002',
						'label' => 'Sub Heading',
						'name' => 'sub-heading',
						'type' => 'text',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
					),
					array (
						'key' => 'field_heading_1000000000003',
						'label' => 'Center Text',
						'name' => 'center',
						'type' => 'true_false',
						'message' => '',
						'default_value' => 0,
					),
				),
			);

?>