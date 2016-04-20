<?php
$padding = get_sub_field('padding');
$unique_id = ($uid = get_sub_field('unique_id')) ? 'id='.sanitize_title($uid).'' : '';
?>

<?php if($image = get_sub_field('full_width_image')){ ?>
	<div <?php echo esc_attr($unique_id); ?> class="block-inner">
		<div class="<?php if($padding){ echo GRAV_BLOCKS::css()->row()->get(); } else { echo "block-full-width-image"; } ?>">
			<?php if($padding){ ?><div class="columns"><?php } ?>
				<?php if($link = GRAV_BLOCKS::get_link_url('link')){ ?>
					<a class="block-link-<?php echo esc_attr(get_sub_field('link_type'));?>" href="<?php echo esc_url($link); ?>">
				<?php } ?>
					<img src="<?php echo esc_attr($image['sizes']['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" title="<?php echo esc_attr($image['title']); ?>" />
				<?php if($link){ ?>
					</a>
				<?php } ?>
			<?php if($padding){ ?></div><?php } ?>
		</div>
	</div>
<?php } ?>
