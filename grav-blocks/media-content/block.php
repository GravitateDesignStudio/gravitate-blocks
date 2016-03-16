<?php
	$placement = get_sub_field('image_placement');
	$col_width = get_sub_field('image_size');
	$content = get_sub_field('content');

	$col_content_width = 12-$col_width;

	$bottom_classes = '';
	$top_classes = '';
	if($placement == 'right'){
		$top_classes = GRAV_BLOCKS::css()->col_push(0, $col_content_width)->get().' medium-order-2';
		$bottom_classes = GRAV_BLOCKS::css()->col_pull(0, $col_width)->get().' medium-order-1';
	}
?>
<div class="block-inner">
	<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?>">
		<div class="col-image <?php echo GRAV_BLOCKS::css()->col(0, $col_width)->get(); ?> <?php echo $top_classes; ?>">
			<?php if($link = GRAV_BLOCKS::get_link_url('link')){ ?>
				<a class="block-link-<?php echo esc_attr(get_sub_field('link_type'));?>" href="<?php echo esc_url($link); ?>">
			<?php } ?>
			<?php if($image = get_sub_field('image')){ ?>
				<img src="<?php echo esc_attr($image['sizes']['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
			<?php } ?>
			<?php if($link){ ?>
				</a>
			<?php } ?>
		</div>
		<div class="<?php echo GRAV_BLOCKS::css()->col(0, $col_content_width)->get(); ?> <?php echo $bottom_classes; ?>">
			<?php echo $content; ?>
		</div>
	</div>
</div>
