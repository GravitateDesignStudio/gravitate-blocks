<?php
/*
Gravitate Content Block Handler Template

Available Variables:
GRAV_BLOCKS::$current_block_name
$block_class_prefix
$block_background
$block_background_style
$block_section_attributes
$block_index
$unique_id = if activated

*/
$classes = array(
	$block_class_prefix.'-container',
	$block_class_prefix.'-'.GRAV_BLOCKS::$current_block_name,
	$block_background,
	'block-index-'.GRAV_BLOCKS::$block_index,
);
$block_style_attr = apply_filters( 'grav_block_background_style', $block_background_style );

?>


<section <?php echo esc_attr($unique_id); ?> <?php echo $block_section_attributes;?> class="<?php echo GRAV_BLOCKS::css()->add($classes)->get(); ?>" <?php if($block_style_attr){ echo ' style="'.$block_style_attr.'"'; }?>>

	<?php GRAV_BLOCKS::get_block(GRAV_BLOCKS::$current_block_name); ?>

</section>
