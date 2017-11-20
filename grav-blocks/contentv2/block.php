<?php

if($column_num = get_sub_field('num_columns')){
	$cols_span = (12/$column_num);
	$cols_span = apply_filters('grav_block_content_columns', $cols_span);
	$medium_col = $column_num < 3 ? $cols_span : 12;
	$large_col = $column_num >= 2 ? $cols_span : 12;

	$sidebar = ($column_num == 2) ? get_sub_field('format') : '';

?>
	<div class="block-inner num-col-<?php echo $column_num; ?> <?php echo $sidebar; ?>">
		<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?>">
		<?php
			for( $i = 1; $i <= $column_num; $i++ ) {
				if($sidebar != '' && $column_num == 2){
					if($i == 1){
						$medium_col = ($sidebar == 'format-sidebar-left') ? 4 : 8;
						$large_col = ($sidebar == 'format-sidebar-left') ? 4 : 8;
					} else {
						$medium_col = ($sidebar == 'format-sidebar-left') ? 8 : 4;
						$large_col = ($sidebar == 'format-sidebar-left') ? 8 : 4;
					}
				}
				?>
				<div class="<?php echo GRAV_BLOCKS::css()->col(12, $medium_col, $large_col)->add('col-content')->get(); ?>">
					<?php the_sub_field('column_'.$i); ?>
				</div>
		<?php } ?>
		</div>
	</div>
<?php
}
