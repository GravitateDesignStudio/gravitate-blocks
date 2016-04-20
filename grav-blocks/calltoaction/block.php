<?php

$buttons = get_sub_field('buttons');
$title = get_sub_field('title');
$description = get_sub_field('description');
$unique_id = ($uid = get_sub_field('unique_id')) ? 'id='.sanitize_title($uid).'' : '';

if($title || $description || $buttons){ ?>

	<div <?php echo esc_attr($unique_id); ?> class="block-inner">
		<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?> align-center">
			<div class="<?php
					echo GRAV_BLOCKS::css()->col(12, 8)->col_center(false, true)->get();
				?>">
				<?php if($title){ ?>
					<h2><?php echo esc_html($title); ?></h2>
				<?php } ?>
				<?php if($description){ ?>
					<h4><?php echo esc_html($description); ?></h4>
				<?php } ?>
				<?php

					if($buttons)
					{
						while(has_sub_field('buttons'))
						{
							GRAV_BLOCKS::get_link_html('button', 'button');
						}
					}

				?>
			</div>
		</div>
	</div>

<?php
}
