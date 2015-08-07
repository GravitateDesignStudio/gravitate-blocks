<?php if(get_sub_field('quoted_text')){ ?>
	<div class="block-inner">
		<div class="row">
			<div class="columns">
				<p<?php if(get_sub_field('center')){?> class="text-center"<?php } ?>><?php the_sub_field('quoted_text');?></p>
				<p<?php if(get_sub_field('center')){?> class="text-center"<?php } ?>>-<?php the_sub_field('attribution');?></p>
			</div>
		</div>
	</div>
<?php } ?>