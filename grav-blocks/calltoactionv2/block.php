<?php

$buttons = isset($buttons) ? $buttons : get_sub_field('buttons');
$title = isset($title) ? $title : get_sub_field('title');
$description = isset($description) ? $description : get_sub_field('description');
$form = isset($form) ? $form : get_sub_field('form');
$align_content = isset($align_content) ? $align_content : (get_sub_field('center') ? 'center' : 'left');

if($title || $description || $buttons || $form){ ?>

	<div class="block-inner">
		<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?> align-center">
			<div class="<?php
					echo GRAV_BLOCKS::css()->add('block-calltoaction-content')->col(12, 8)->col_center(false, true)->text_align($align_content)->get();
				?>">
				<?php if($title){ ?>
					<h2 class="block-title"><?php echo esc_html($title); ?></h2>
				<?php } ?>
				<?php if($description){ ?>
					<h4 class="block-description"><?php echo esc_html($description); ?></h4>
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

				if($form)
				{
					?>
					<div class="block-form">
						<?php if(function_exists('gravity_form')){ gravity_form($form, false, false, false, null, true); } ?>
					</div>
					<?php
				}

				?>
			</div>
		</div>
	</div>

<?php
}
