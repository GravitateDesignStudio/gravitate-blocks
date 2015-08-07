<?php

if(get_sub_field('testimonials'))
{
	?>
	<div class="block-inner">
		<div class="row">
			<div class="columns">
				<div class="cycle-slideshow" data-cycle-fx="fade" data-cycle-timeout="8000" data-cycle-speed="1200" data-cycle-slides=".slide" data-cycle-log="false">

					<?php
					while(has_sub_field('testimonials'))
					{
						$image = get_sub_field('image');
						?>
						<div class="slide row">
							<div class="medium-2 columns">
								<?php if($image){?>
								<img src="<?php echo $image['sizes']['thumbnail'];?>" alt="<?php echo $image['alt'];?>">
								<?php } ?>
							</div>
							<div class="medium-10 columns">
								<p class="testimonial">“<?php the_sub_field('testimonial');?>”</p>
								<span class="attribution"><?php the_sub_field('attribution');?></span>
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