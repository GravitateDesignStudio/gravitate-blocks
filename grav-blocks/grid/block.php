<?php

if($grid_items = get_sub_field('grid_items')){ ?>
	<div class="block-inner">
		<?php if($block_title = get_sub_field('grid_title')){ ?>
			<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?>">
				<div class="<?php echo GRAV_BLOCKS::css()->col()->get();?>">
					<h2><?php echo $block_title; ?></h2>
				</div>
			</div>
		<?php } ?>
		<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?>">
			<div class="<?php echo GRAV_BLOCKS::css()->col()->get();?>">
				<ul class="<?php echo GRAV_BLOCKS::css()->grid(0, 2, 4)->get();?>">
					<?php foreach($grid_items as $grid_item){ ?>
						<li>
							<?php if($title = $grid_item['item_title']){ ?>
								<h3><?php echo $title; ?></h3>
							<?php } ?>
							<?php if($image = $grid_item['item_image']){ ?>
								<img src="<?php echo esc_attr($image['sizes']['medium']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
							<?php } ?>
							<?php if($content = $grid_item['item_content']){ echo $content; } ?>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
<?php
}