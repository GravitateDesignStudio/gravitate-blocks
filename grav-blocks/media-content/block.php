<?php
	$foundation_version = GRAV_BLOCKS::get_foundation_version();
	$f6flex = (strpos($foundation_version, 'f6flex') === false) ? false: true;

	$placement = ($right = get_sub_field('image_placement')) ? $right : 'left';
	$col_width = get_sub_field('image_size');
	$content = get_sub_field('content');
	$col_array = GRAV_BLOCKS::column_width_options();

	$col_total = 12;
	$col_total = apply_filters('grav_block_mediacontent_columns', $col_total, $col_width, $placement);
	$col_content_width = $col_total-$col_width;
	$col_class = 'col-option-'.$placement.'-'.sanitize_title($col_array[$col_width]);

	$bottom_classes = GRAV_BLOCKS::css()->col(0, $col_content_width)->add($col_class)->get();
	$top_classes = GRAV_BLOCKS::css()->col(0, $col_width)->add($col_class.', col-image')->get();
	if($placement == 'right'){
		$top_classes = ($f6flex) ? GRAV_BLOCKS::css()->col(0, $col_width)->add('medium-order-2, '.$col_class.', col-image')->get() : GRAV_BLOCKS::css()->col(0, $col_width)->col_push(0, $col_content_width)->add($col_class.', col-image')->get();
		$bottom_classes = ($f6flex) ? GRAV_BLOCKS::css()->col(0, $col_content_width)->add('medium-order-1, '.$col_class)->get() : GRAV_BLOCKS::css()->col_pull(0, $col_width)->add($col_class)->get();
	}


	$unique_id = ($uid = get_sub_field('unique_id')) ? 'id='.sanitize_title($uid).'' : '';
?>
<div <?php echo esc_attr($unique_id); ?> class="block-inner <?php echo $placement.'-'.sanitize_title($col_array[$col_width]); ?>">
	<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?>">
		<div class="<?php echo $top_classes; ?>">
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
		<div class="<?php echo $bottom_classes; ?>">
			<?php echo $content; ?>
		</div>
	</div>
</div>
