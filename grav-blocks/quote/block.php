<?php
if(get_sub_field('quoted_text')){ ?>
	<div class="block-inner">
		<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?>">
			<div class="<?php echo GRAV_BLOCKS::css()->col()->get();?>">
				<blockquote<?php if(get_sub_field('center')){?> style="text-align:center;"<?php } ?>>&ldquo;<?php the_sub_field('quoted_text');?>&rdquo;
					<footer>
						<cite<?php if(get_sub_field('center')){?> style="text-align:center;"<?php } ?>>-<?php the_sub_field('attribution');?></cite>
					</footer>
				</blockquote>
			</div>
		</div>
	</div>
<?php
}
