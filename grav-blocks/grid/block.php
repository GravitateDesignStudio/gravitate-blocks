<?php
$foundation_version = GRAV_BLOCKS::get_foundation_version();
$f6 = (strpos($foundation_version, 'f6') === false) ? false: true;
$alt_title_location = get_sub_field('move_title');

$block_format = isset($block_format) ? $block_format : get_sub_field('format');
$block_format = $block_format ? $block_format : 'grid'; // Set Defualt

$num_columns_small =  isset($num_columns_small)  ? $num_columns_small  : (get_sub_field('num_columns_small')  ? get_sub_field('num_columns_small')  : 1); // Set Defaults for older Plugin Versions
$num_columns_medium = isset($num_columns_medium) ? $num_columns_medium : (get_sub_field('num_columns_medium') ? get_sub_field('num_columns_medium') : 2); // Set Defaults for older Plugin Versions
$num_columns_large =  isset($num_columns_large)  ? $num_columns_large  : (get_sub_field('num_columns_large')  ? get_sub_field('num_columns_large')  : 4); // Set Defaults for older Plugin Versions
$num_columns_xlarge = isset($num_columns_xlarge) ? $num_columns_xlarge : (get_sub_field('num_columns_xlarge') ? get_sub_field('num_columns_xlarge') : 6); // Set Defaults for older Plugin Versions

$grid_class = '';
if($block_format !== 'slider')
{
	$grid_class = ' '.GRAV_BLOCKS::css()->grid($num_columns_small, $num_columns_medium, $num_columns_large, $num_columns_xlarge)->get();
}

if($gallery_items = get_sub_field('gallery_items')){ ?>
	<div class="block-inner block-media-gallery-format-<?php echo $block_format;?>">
		<?php if($block_title = get_sub_field('gallery_title')){ ?>
			<div class="<?php echo GRAV_BLOCKS::css()->row()->add('block-title-container')->get();?>">
				<div class="<?php echo GRAV_BLOCKS::css()->col()->get();?>">
					<h2 class="block-title"><?php echo $block_title; ?></h2>
				</div>
			</div>
		<?php } ?>

		<div class="<?php echo GRAV_BLOCKS::css()->add('block-media-items-container')->get();?>"
			data-columns-small="<?php echo $num_columns_small;?>"
			data-columns-medium="<?php echo $num_columns_medium;?>"
			data-columns-large="<?php echo $num_columns_large;?>"
			data-columns-xlarge="<?php echo $num_columns_xlarge;?>">

			<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?> <?php if($f6){ echo GRAV_BLOCKS::css()->add('media-items')->get().$grid_class; } ?>">
				<?php if(!$f6){ ?>
				<div class="<?php echo GRAV_BLOCKS::css()->col()->get();?>">
					<ul class="<?php echo GRAV_BLOCKS::css()->add('media-items')->get().$grid_class;?>">
					<?php } ?>
						<?php
						if($gallery_items)
						{
							while(has_sub_field('gallery_items'))
							{
								$image = get_sub_field('item_image');
								$title = get_sub_field('item_title');

								$link = GRAV_BLOCKS::get_link_url('link');

								$link_type = get_sub_field('link_type');


								if(!empty($image['url']) && $block_format === 'gallery')
								{
									$link = (!empty($image['sizes']['xlarge']) ? $image['sizes']['xlarge'] : $image['url']);
									$link_type = 'gallery';
								}

								?>
								<?php if($f6){ ?><div class="columns media-item"><?php } else { ?><li><?php } ?>
									<?php if($link){ ?>
										<a class="block-link-<?php echo esc_attr($link_type);?> item-link gallery-<?php echo GRAV_BLOCKS::$block_index;?>" href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($image['alt']); ?>">
									<?php } ?>
									<div class="media-item-container">

										<?php if($image){ ?>
											<div class="item-image-container">
												<div class="item-image">
													<?php echo GRAV_BLOCKS::image($image);?>
												</div>
											</div>
										<?php } ?>

										<?php if($title){ ?>
											<h3 class="item-title"><span><?php echo $title; ?></span></h3>
										<?php } ?>
										<?php if($content = get_sub_field('item_content')){ ?>
											<p class="item-content"><span><?php echo $content; ?></span></p>
										<?php } ?>
									</div>
									<?php if($link){ ?>
										</a>
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
	</div>

<?php
}
