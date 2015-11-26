<?php

if(get_sub_field('button_'.get_sub_field('button_type'))){ ?>

	<div class="block-inner">
		<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?>">
			<div class="<?php
					echo GRAV_BLOCKS::css()->col(12, 8)->col_center(false, true)->get();
				?>">
				<?php if($title = get_sub_field('title')){ ?>
					<h1><?php echo esc_html($title); ?></h1>
				<?php } ?>
				<?php if($subtitle = get_sub_field('subtitle')){ ?>
					<h4><?php echo esc_html($subtitle); ?></h4>
				<?php } ?>
				<a class="button white" href="<?php echo esc_url(get_sub_field('button_'.get_sub_field('button_type'))); ?>"><?php the_sub_field('button_text'); ?></a>
			</div>
		</div>
	</div>

<?php
}