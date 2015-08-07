<?php if(get_sub_field('button_'.get_sub_field('button_type'))){ ?>
	<div class="block-inner">
		<div class="row">
			<div class="columns">
				<a class="button" href="<?php the_sub_field('button_'.get_sub_field('button_type'));?>"><?php the_sub_field('button_text');?></a>
			</div>
		</div>
	</div>
<?php } ?>