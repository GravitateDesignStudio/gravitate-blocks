<?php
/*
Gravitate Content Block Handler Template

Available Variables:
GRAV_BLOCKS::$current_block_name
$block_class_prefix
$block_background
$block_background_style

*/
?>


<section class="<?php echo $block_class_prefix;?>-container <?php echo $block_class_prefix;?>-<?php echo GRAV_BLOCKS::$current_block_name;?> <?php echo $block_background;?>" <?php echo $block_background_style;?>>

	<?php GRAV_BLOCKS::get_block(GRAV_BLOCKS::$current_block_name); ?>

</section>