<?php
$block = 'call_to_action';
//GRAV_BLOCKS::dump(GRAV_BLOCKS::generate_link_fields('button2', array('none', 'file', 'page', 'link') ));


$buttons = get_sub_field('buttons');
$title = get_sub_field('title');
$description = get_sub_field('description');

if($title || $description || $buttons){ ?>

	<div class="block-inner">
		<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?>">
			<div class="<?php
					echo GRAV_BLOCKS::css()->col(12, 8)->col_center(false, true)->get();
				?>">
				<?php if($title){ ?>
					<h1><?php echo esc_html($title); ?></h1>
				<?php } ?>
				<?php if($description){ ?>
					<h4><?php echo esc_html($description); ?></h4>
				<?php } ?>
				<?php

					if(get_sub_field('buttons'))
					{
						while(has_sub_field('buttons'))
						{
							GRAV_BLOCKS::get_link_html('button');
						}
					}

				?>
			</div>
		</div>
	</div>

<?php
}