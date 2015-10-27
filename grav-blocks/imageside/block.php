<?php
	$placement = get_sub_field('image_placement');
	$col_width = get_sub_field('image_size');
	$content = get_sub_field('content');
	$images = get_sub_field('images');

	$col_content_width = 12-$col_width;

	if($placement == 'right'){
		$top_classes = 'medium-push-'.$col_content_width;
		$bottom_classes = 'medium-pull-'.$col_width;
	} else {
		$bottom_classes = '';
		$top_classes = '';
	}
?>
<div class="block-inner">
	<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?>">
		<div class="medium-<?php echo $col_width; ?> columns <?php echo $top_classes; ?>">

			<div class="cycle-slideshow"
				data-cycle-fx="fade"
				data-cycle-timeout="8000"
				data-cycle-speed="1200"
				data-cycle-log="false">

				<?php foreach($images as $image){ ?>
					<img src="<?php echo esc_attr($image['image']['sizes']['large']); ?>" alt="<?php echo esc_attr($image['image']['alt']); ?>" />
				<?php } ?>

				<?php if(count($images) > 1){ ?> <div class="cycle-pager"></div> <?php } ?>

			</div>

		</div>
		<div class="medium-<?php echo $col_content_width; ?> columns <?php echo $bottom_classes; ?>">
			<?php echo $content; ?>
		</div>
	</div>
</div>

