<?php

if($gallery_items = get_sub_field('gallery_items')){ ?>
	<div class="block-inner">
		<?php if($block_title = get_sub_field('gallery_title')){ ?>
			<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?>">
				<div class="<?php echo GRAV_BLOCKS::css()->col()->get();?>">
					<h2><?php echo $block_title; ?></h2>
				</div>
			</div>
		<?php } ?>
		<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?>">
			<div class="<?php echo GRAV_BLOCKS::css()->col()->get();?>">
				<ul class="<?php echo GRAV_BLOCKS::css()->grid(0, 2, 4)->get();?>">
					<?php
					if($gallery_items)
					{
						while(has_sub_field('gallery_items'))
						{
							$image = get_sub_field('item_image')
							?>
							<li>
								<?php if($title = get_sub_field('item_title')){ ?>
									<h3><?php echo $title; ?></h3>
								<?php } ?>
								<?php if($link = GRAV_BLOCKS::get_link_url('link')){ ?>
									<a class="block-link-<?php echo esc_attr(get_sub_field('link_type'));?> block-link-gallery" href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($image['alt']); ?>">
								<?php } ?>
									<?php if($image){ ?>
										<img src="<?php echo esc_attr($image['sizes']['medium']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
									<?php } ?>
								<?php if($link){ ?>
									</a>
								<?php } ?>
								<?php if($content = get_sub_field('item_content')){ ?>
									<p><?php echo $content; ?></p>
								<?php } ?>
							</li>
						<?php }
					}
					?>
				</ul>
			</div>
		</div>
	</div>
<?php
}