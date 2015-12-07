<?php
$padding = get_sub_field('padding');
$image = get_sub_field('full_width_image');
?>

<?php if($image){ ?>
	<div class="block-inner">
		<div class="<?php if(!$padding){ echo GRAV_BLOCKS::css()->row()->get(); } else { echo "block-full-width-image"; } ?>">
			<img src="<?php echo esc_attr($image['sizes']['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" title="<?php echo esc_attr($image['title']); ?>" />
		</div>
	</div>
<?php } ?>