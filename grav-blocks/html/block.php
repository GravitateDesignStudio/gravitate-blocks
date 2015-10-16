<?php

if(get_sub_field('html_column'))
{
	$cols = get_sub_field('html_column');
	$cols_count = count($cols);
	$cols_span = (12/$cols_count);

	?>

	<div class="block-inner">
		<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?>">
			<?php
				if(have_rows('html_column'))
				{
				    while(have_rows('html_column'))
				    {
				    	the_row();

				    	?>
						<div class="<?php echo GRAV_BLOCKS::css()->col(12, ($cols_count < 3 ? $cols_span : 12), ($cols_count >= 3 ? $cols_span : 12))->get();?>">
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