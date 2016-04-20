<?php
if($heading = get_sub_field('title')){
$unique_id = ($uid = get_sub_field('unique_id')) ? 'id='.sanitize_title($uid).'' : '';
?>
	<div <?php echo esc_attr($unique_id); ?> class="block-inner">
		<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?>">
			<div class="<?php echo GRAV_BLOCKS::css()->col()->get();?>">
				<h2<?php if($center = get_sub_field('center')){?> style="text-align:center;"<?php } ?>>
					<?php echo $heading; ?>
				</h2>
				<?php if($sub_heading = get_sub_field('sub-title')){ ?>
					<h3<?php if($center){?> style="text-align:center;"<?php } ?>>
						<?php echo $sub_heading; ?>
					</h3>
				<?php } ?>
			</div>
		</div>
	</div>
<?php
}
