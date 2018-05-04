<?php

global $mapBlockApiKey;

$mapBlockApiKey = GRAV_BLOCKS_PLUGIN_SETTINGS::get_setting_value('google_maps_api_key', 0);

if ($mapBlockApiKey) {
    wp_enqueue_script( 'google_maps_api','https://maps.googleapis.com/maps/api/js?key=' . $apiKey, $deps = array('jquery'), $ver = false, $in_footer = true );
    wp_enqueue_script( 'map_block_js', plugin_dir_url(__FILE__) . 'map-block.js', $deps = array('jquery'), $ver = false, $in_footer = true );
}
