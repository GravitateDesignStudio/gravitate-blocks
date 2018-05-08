<?php

if ($mapBlockApiKey = GRAV_BLOCKS_PLUGIN_SETTINGS::get_setting_value('google_maps_api_key')) {
	$format = get_sub_field('format');

	$map_order = ' medium-order-1';

	$map_col = 12;

	$content_col = 12;

	if ($format != 'map') {

		$position = get_sub_field('map_position');

		$map_order = ($position == 'right') ? ' medium-order-2' : ' medium-order-1';
		$content_order = ($position == 'right') ? ' medium-order-1' : ' medium-order-2';

		$map_col = ($format == 'small-map') ? 4 : 8;
		$content_col = 4;
	}

	if($markers = get_sub_field('markers'))
	{ ?>

		<div class="block-inner">
			<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?> align-center">
				<!-- Map -->
				<div class="<?php echo GRAV_BLOCKS::css()->col(12, $map_col)->get() . $map_order;?> map">
					<?php
					 	$location_data = '';
						$infowindow_data = '';
						$markers = get_sub_field('markers');

						if( have_rows('markers') ){
						    ?>

						    <?php

							$count = 0;
						    while ( have_rows('markers') ){ the_row();
								$count++;
						   		$location_data .="[";
						        $location_data .= "'" . get_sub_field('marker_name') . "',";
						        $location_data .= get_sub_field('lattitude') . ",";
						        $location_data .= get_sub_field('longitude');
								$location_data .= ($count < count($markers)) ? "]," : "]";

								$infowindow_data .= "['";
								$infowindow_data .= "<h3>" . get_sub_field('marker_name') . "</h3>";
								if($text = get_sub_field('info_window')) {
									$infowindow_data .= "<p>" . trim($text, " \t\n\r\0\x0B") . "</p>";
								}
								$infowindow_data .= ($count < count($markers)) ? "'], " : "']";

						    }
						}
					?>
					<div
					data-zoom="<?php the_sub_field('zoom_offset'); ?>"
					id="<?php echo GRAV_BLOCKS::$block_index;?>_map" class="google-map">

					</div>

				</div>
				<!-- Content -->
				<?php if ($format != 'map'): ?>
					<div class="<?php echo GRAV_BLOCKS::css()->col(12, $content_col)->get() . $content_order; ?> content">
						<?php the_sub_field('content'); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	wp_localize_script( 'map_block_js', 'locations', $location_data );
	wp_localize_script( 'map_block_js', 'infoWindows', $infowindow_data );
	wp_localize_script( 'map_block_js', 'marker_url', plugin_dir_url(__FILE__) . '/assets/map-marker.svg' );

} else { ?>
	<div class="block-inner">
		<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?> align-center">
			<div class="<?php echo GRAV_BLOCKS::css()->col(12, 10)->get(); ?>">
				<h2>Please add a Google Map API key to Gravitate Blocks General Settings</h2>
			</div>
		</div>

	</div>
<?php }
