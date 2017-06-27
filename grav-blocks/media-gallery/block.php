<?php
$foundation_version = GRAV_BLOCKS::get_foundation_version();
$f6 = (strpos($foundation_version, 'f6') === false) ? false: true;
$alt_title_location = get_sub_field('move_title');

if($gallery_items = get_sub_field('gallery_items')){ ?>
	<div class="block-inner">
		<?php if($block_title = get_sub_field('gallery_title')){ ?>
			<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?>">
				<div class="<?php echo GRAV_BLOCKS::css()->col()->get();?>">
					<h2><?php echo $block_title; ?></h2>
				</div>
			</div>
		<?php } ?>
		<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?> <?php if($f6){ echo GRAV_BLOCKS::css()->grid(1, 2, 4)->get(); } ?>">
			<?php if(!$f6){ ?>
			<div class="<?php echo GRAV_BLOCKS::css()->col()->get();?>">
				<ul class="<?php echo GRAV_BLOCKS::css()->grid(0, 2, 4)->get();?>">
				<?php } ?>
					<?php
					if($gallery_items)
					{
						while(has_sub_field('gallery_items'))
						{
							$image = get_sub_field('item_image');
							$title = get_sub_field('item_title')
							?>
							<?php if($f6){ ?><div class="columns"><?php } else { ?><li><?php } ?>
								<?php if($title && !$alt_title_location){ ?>
									<h3><?php echo $title; ?></h3>
								<?php } ?>
								<?php if($link = GRAV_BLOCKS::get_link_url('link')){ ?>
									<a class="block-link-<?php echo esc_attr(get_sub_field('link_type'));?> block-link-gallery" href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($image['alt']); ?>">
								<?php } ?>

									<?php echo GRAV_BLOCKS::image($image);?>

								<?php if($link){ ?>
									</a>
								<?php } ?>
								<?php if($title && $alt_title_location){ ?>
									<h3><?php echo $title; ?></h3>
								<?php } ?>
								<?php if($content = get_sub_field('item_content')){ ?>
									<p><?php echo $content; ?></p>
								<?php } ?>
							<?php if($f6){ ?></div><?php } else { ?></li><?php } ?>
						<?php }
					}
					?>
			<?php if(!$f6){ ?>
				</ul>
			</div>
			<?php } ?>
		</div>
	</div>
<?php
}
