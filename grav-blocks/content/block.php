<?php

if($cols = get_sub_field('content_column'))
{
	$cols_count = count($cols);
	$cols_span = (12/$cols_count);
	$cols_span = apply_filters('grav_block_content_columns', $cols_span);
	?>

	<div class="block-inner num-col-<?php echo $cols_count; ?>">
		<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?>">
			<?php
				if(have_rows('content_column'))
				{
				    while(have_rows('content_column'))
				    {
				    	the_row();

				    	?>
						<div class="<?php echo GRAV_BLOCKS::css()->col(12, ($cols_count < 3 ? $cols_span : 12), ($cols_count >= 3 ? $cols_span : 12))->add('col-content')->get();?>">
							<?php the_sub_field('column'); ?>
						</div>
						<?php
					}
				}
			?>
		</div>
	</div>

	<?php
}
