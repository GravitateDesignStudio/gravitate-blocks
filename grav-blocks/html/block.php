<?php

if(get_sub_field('html_column'))
{
	$columns = get_sub_field('html_column');
	?>

	<div class="block-inner">
		<div class="row">
			<?php
				if(have_rows('html_column'))
				{
				    while(have_rows('html_column'))
				    {
				    	the_row();

				    	?>
						<div class="col-md-<?php echo 12/count($columns); ?> large-<?php echo 12/count($columns); ?> columns">
							<?php
						        the_sub_field('column');
						    ?>
						</div>
						<?php
					}
				}
			?>
		</div>
	</div>

	<?php
}