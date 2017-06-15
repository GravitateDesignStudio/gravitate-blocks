<?php

$buttons = isset($buttons) ? $buttons : get_sub_field('buttons');
$title = isset($title) ? $title : (get_sub_field('use_alternate_title') ? get_sub_field('title') : get_the_title());
$sub_title = isset($sub_title) ? $sub_title : get_sub_field('sub_title');
$intro = isset($intro) ? $intro : get_sub_field('intro');
$content_alignment = isset($content_alignment) ? $content_alignment : get_sub_field('content_alignment');

if($title || $intro || $buttons){ ?>

	<div class="<?php echo GRAV_BLOCKS::css()->add('block-inner')->get(); ?>">
		<div class="<?php echo GRAV_BLOCKS::css()->add('block-banner-inner-container')->row()->text_align($content_alignment)->align($content_alignment)->get();?>">
			<div class="<?php
					echo GRAV_BLOCKS::css()->add('block-banner-content')->col(12, 8)->col_center(false, true)->get();
				?>">
				<?php if($title){ ?>
					<h1 class="block-title"><?php echo GRAV_BLOCKS::allow_br(esc_html($title)); ?></h1>
				<?php } ?>
				<?php if($sub_title){ ?>
					<h6 class="block-sub-title"><?php echo GRAV_BLOCKS::allow_br(esc_html($sub_title)); ?></h6>
				<?php } ?>
				<?php if($intro){ ?>
					<p class="block-intro"><?php echo GRAV_BLOCKS::allow_br(esc_html($intro)); ?></p>
				<?php } ?>

				<?php

					if($buttons)
					{
						?>
						<div class="block-buttons">
							<?php
							foreach($buttons as $button)
							{
								if(!empty($button['button_'.$button['button_type']]))
								{
									$link = $button['button_'.$button['button_type']];

									if($button['button_type'] === 'video')
									{
										$link = GRAV_BLOCKS::get_video_url($link);
									}
								}
								else
								{
									$link = '#';
								}

								if($button['button_type'] && $button['button_type'] != 'none'){
								?>
									<a class="button block-link-<?php echo esc_attr($button['button_type']);?>" href="<?php echo esc_url($link);?>"><?php echo esc_html($button['button_text']);?></a>
								<?php
								}
							}

							?>
						</div>
						<?php
					}

				?>
			</div>
		</div>
	</div>


<?php
}
