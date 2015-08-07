<?php
	$acf_layout = array (
				'label' => 'Quote',
				'name' => 'quote',
				'display' => 'row',
				'min' => '',
				'max' => '',
				'sub_fields' => array (
					$acf_background,
					$acf_background_image,
					array (
						'key' => 'field_quote_1000000000001',
						'label' => 'Quoted Text',
						'name' => 'quoted_text',
						'type' => 'textarea',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
					),
					array (
						'key' => 'field_quote_1000000000002',
						'label' => 'Attribution',
						'name' => 'attribution',
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
						'key' => 'field_quote_1000000000003',
						'label' => 'Center Text',
						'name' => 'center',
						'type' => 'true_false',
						'message' => '',
						'default_value' => 0,
					),
				),
			);

?>