<?php
$acf_layout = array (
			'label' => 'Image',
			'name' => 'image',
			'display' => 'row',
			'min' => '',
			'max' => '',
			'sub_fields' => array (
				$acf_background,
				$acf_background_image,
				array (
					'key' => 'field_5400a5a051e00',
					'label' => 'Without Padding',
					'name' => 'without_padding',
					'type' => 'true_false',
					'column_width' => '',
					'message' => '',
					'default_value' => 0,
				),
				array (
					'key' => 'field_5400a5bc51e01',
					'label' => 'Full Width Image',
					'name' => 'full_width_image',
					'type' => 'image',
					'column_width' => '',
					'save_format' => 'object',
					'preview_size' => 'medium',
					'library' => 'all',
				),
			),
		);
?>