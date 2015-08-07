<?php
	$acf_layout = array (
				'label' => 'HTML',
				'name' => 'html',
				'display' => 'row',
				'min' => '',
				'max' => '',
				'sub_fields' => array (
					$acf_background,
					$acf_background_image,
					array (
						'key' => 'field_html_1000000000001',
						'label' => 'HTML Column',
						'name' => 'html_column',
						'type' => 'repeater',
						'column_width' => '',
						'sub_fields' => array (
							array (
								'key' => 'field_html_1000000000002',
								'label' => 'Column',
								'name' => 'column',
								'type' => 'wysiwyg',
								'column_width' => '',
								'default_value' => '',
								'toolbar' => 'full',
								'media_upload' => 'yes',
							),
						),
						'row_min' => '',
						'row_limit' => '3',
						'layout' => 'row',
						'button_label' => 'Add Column',
					),
				),
			);
	
?>