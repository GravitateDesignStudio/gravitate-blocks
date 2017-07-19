<?php
if(get_sub_field('quotes'))
{
	?>
	<div class="block-inner">
		<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?>">
			<div class="<?php echo GRAV_BLOCKS::css()->col()->add('items-container')->get();?>">
				<div class="<?php echo GRAV_BLOCKS::css()->add('items')->get();?>">

					<?php
					while(has_sub_field('quotes'))
					{
						$image = get_sub_field('image');
						?>
						<div class="<?php echo GRAV_BLOCKS::css()->add('item')->get();?>">
							<div class="<?php echo GRAV_BLOCKS::css()->add(($image ? 'has-image' : 'no-image'))->row()->get();?>">
								<?php if($image){?>
								<div class="<?php echo GRAV_BLOCKS::css()->add('item-image, flex, align-middle, align-center')->col(10, 2, 2)->col_offset(1, 1, 2, 2)->get();?>">
									<?php //echo GRAV_BLOCKS::image($image);?>
									<img src="<?php echo esc_attr($image['sizes']['medium']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
								</div>
								<?php } ?>
								<div class="<?php echo GRAV_BLOCKS::css()->add('item-content')->col(10, 8, 6, 6)->col_offset(($image ? 1 : 1), ($image ? 0 : 2), ($image ? 0 : 3), ($image ? 0 : 3))->get();?>">
									<blockquote>
										<p><?php the_sub_field('quote');?></p>
									</blockquote>
									<div class="<?php echo GRAV_BLOCKS::css()->add('item-attribution')->get();?>">
										<cite class="<?php echo GRAV_BLOCKS::css()->add('item-attribution-title')->get();?>"><?php the_sub_field('attribution');?></cite>
										<?php if($attribution_sub_title = get_sub_field('attribution_sub_title')){ ?>
											<cite class="<?php echo GRAV_BLOCKS::css()->add('item-attribution-sub-title')->get();?>"><?php echo $attribution_sub_title;?></cite>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					<?php
					}
					?>
				</div>
			 </div>
		</div>
	</div>
	<?php
}
