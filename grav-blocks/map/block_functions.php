<?php

if ($mapBlockApiKey = GRAV_BLOCKS_PLUGIN_SETTINGS::get_setting_value('google_maps_api_key')) {
    wp_enqueue_script( 'google_maps_api','https://maps.googleapis.com/maps/api/js?key=' . $mapBlockApiKey, $deps = array('jquery'), $ver = false, $in_footer = true );
    wp_enqueue_script( 'map_block_js', plugin_dir_url(__FILE__) . 'map-block.js', $deps = array('jquery'), $ver = false, $in_footer = true );
}
