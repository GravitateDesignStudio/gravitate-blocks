<?php

if($column_num = get_sub_field('num_columns')){ ?>

	<div class="block-inner">
		<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?> align-center">
	<?php
		for ($i=1; $i <= $column_num; $i++) {
			$buttons = get_sub_field('buttons_' . $i);
			$title = get_sub_field('title_' . $i);
			$description = get_sub_field('description_' . $i);
			$form = get_sub_field('form_' . $i);
			$align_content = get_sub_field('alignment_' . $i);
			$background = get_sub_field('block_background_' . $i);
			$background_image = get_sub_field('block_background_image_' . $i);

			if($title || $description || $buttons || $form){ ?>


					<div class="<?php
							echo GRAV_BLOCKS::css()->add('block-calltoaction-content,' . $background)->col(12, ($column_num > 1 ? (12/$column_num) : 8))->col_center(false, true)->text_align($align_content)->get();
						?>"
						<?php if($background == 'block-bg-image') {
							echo GRAV_BLOCKS::image_background($background_image);
						} ?>>
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

			<?php }
			}
		 ?>
 		</div>
	</div>
<?php }
