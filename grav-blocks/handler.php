<?php
/*
Gravitate Content Block Handler Template

Available Variables:
$block_name
$block_class_prefix
$block_background
$block_background_style

*/
?>

<section class="<?php echo $block_class_prefix;?>-container <?php echo $block_class_prefix;?>-<?php echo $block_name;?> <?php echo $block_background;?>" <?php echo $block_background_style;?>>

	<?php GRAV_BLOCKS::get_block($block_name); ?>

</section>