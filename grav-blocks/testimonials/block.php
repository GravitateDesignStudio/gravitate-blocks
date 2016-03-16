<?php

if(get_sub_field('testimonials'))
{
	?>
	<div class="block-inner">
		<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?>">
			<div class="<?php echo GRAV_BLOCKS::css()->col()->get();?>">
				<div class="cycle-slideshow"
					data-cycle-fx="fade"
					data-cycle-timeout="8000"
					data-cycle-speed="1200"
					data-cycle-slides=".slide"
					data-cycle-auto-height="calc"
					data-cycle-log="false">

					<?php
					while(has_sub_field('testimonials'))
					{
						$image = get_sub_field('image');
						?>
						<div class="slide">
							<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?>">
								<div class="<?php echo GRAV_BLOCKS::css()->col(12, 2)->get();?>">
									<?php if($image){?>
									<img src="<?php echo esc_attr($image['sizes']['thumbnail']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
									<?php } ?>
								</div>
								<div class="<?php echo GRAV_BLOCKS::css()->col(12, 10)->get();?>">
									<blockquote class="testimonial">&ldquo;<?php the_sub_field('testimonial');?>&rdquo;
									<footer>
										<cite><?php the_sub_field('attribution');?></cite>
									<footer>
									</blockquote>
								</div>
							</div>
						</div>
						<?php
					}

					if(count(get_sub_field('testimonials')) > 1)
					{
						?>
						<div class="cycle-pager"></div>
						<?php
					}
					?>

				</div>
			 </div>
		</div>
	</div>
	<?php
}