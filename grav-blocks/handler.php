<?php
/*
Gravitate Content Block Handler Template

Available Variables:
$block_name
$block_hide
$block_index
$block_padding
$block_variables
$block_unique_id
$block_background
$block_background_image
$block_background_overlay
$block_container_attributes

*/

?>

<section <?php echo $block_container_attributes; ?>>

	<?php GRAV_BLOCKS::get_block($block_name, $block_variables); ?>

</section>
