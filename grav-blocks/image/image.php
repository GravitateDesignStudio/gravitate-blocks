<?php 
$padding = get_sub_field('without_padding');
$image = get_sub_field('full_width_image');
?>

<?php if($image){ ?>
	<div class="block-inner">
		<div class="<?php if(!$padding){ echo "row"; } else { echo "full-width-image"; } ?>">
			<img src="<?php echo esc_attr($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" title="<?php echo esc_attr($image['title']); ?>" />
		</div>
	</div>
<?php } ?>