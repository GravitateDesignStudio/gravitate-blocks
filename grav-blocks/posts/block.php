<?php

$block_title = isset($block_title) ? $block_title : get_sub_field('title');
$block_filter = isset($block_filter) ? $block_filter : get_sub_field('filter');
$block_filter_post_type = isset($block_filter_post_type) ? $block_filter_post_type : get_sub_field('post_type');
$block_filter_taxonomy = isset($block_filter_taxonomy) ? $block_filter_taxonomy : get_sub_field('taxonomy');
$block_filter_author = isset($block_filter_author) ? $block_filter_author : get_sub_field('author');
$block_filter_custom = isset($block_filter_custom) ? $block_filter_custom : get_sub_field('custom');

$block_limit = isset($block_limit) ? $block_limit : get_sub_field('limit');
$block_view_more_link_type = isset($block_view_more_link) ? $block_view_more_link : get_sub_field('view_more_link_type');
$block_view_more_link_text = isset($block_view_more_text) ? $block_view_more_text : get_sub_field('view_more_link_text');
$block_view_more_link_url = isset($block_view_more_link_url) ? $block_view_more_link_url : get_sub_field('view_more_link_'.$block_view_more_link_type);

$unique_item_class = '';
$found_postids = array();

switch($block_filter)
{
	//////////////////////////////////////////////////////////
	default:
	case 'tags':

		$filtered_postids = array();
		$post_tags = get_the_tags();
		$post_categories = get_the_category();
		$this_post = get_the_ID();

		if($post_tags)
		{
			$ids = array();
			foreach($post_tags as $tag)
			{
				$ids[] = $tag->term_id;
			}

			foreach ($ids as $id)
			{
				$args = array (
					'tag_id' => $id,
					'numberposts' => ($block_limit ? $block_limit : -1),
					'post__not_in' => array($this_post)
				);

				foreach( get_posts( $args ) as $post )
				{
					$filtered_postids[$post->ID] = (isset($filtered_postids[$post->ID]) ? ($filtered_postids[$post->ID]+1) : 1);
				}
			}
		}

		if(count($filtered_postids) < $block_limit && !empty($post_categories))
		{
			foreach($post_categories as $category)
			{
				$ids[] = $category->term_id;
			}

			foreach ($ids as $id)
			{
				$args = array (
					'cat' => $id,
					'numberposts' => ($block_limit ? $block_limit : -1),
					'post__not_in' => array($this_post)
				);

				foreach( get_posts( $args ) as $post )
				{
					$filtered_postids[$post->ID] = (isset($filtered_postids[$post->ID]) ? ($filtered_postids[$post->ID]+1) : 1);
				}
			}
		}

		arsort($filtered_postids);

		$found_postids = array_keys(array_slice($filtered_postids, 0, $block_limit, true));


	break;
	//////////////////////////////////////////////////////////
	case 'post_type':

		$args = array (
			'post_type' => $block_filter_post_type,
			'numberposts' => ($block_limit ? $block_limit : -1),
		);

		foreach( get_posts( $args ) as $post )
		{
			$found_postids[] = $post->ID;
		}

		$unique_item_class = 'block-posts-class-'.$block_filter_post_type;

	break;
	//////////////////////////////////////////////////////////
	case 'taxonomy':

		if($block_filter_taxonomy)
		{
			$data = explode('::', $block_filter_taxonomy);
			$taxonomy = $data[0];
			$term_id = $data[1];

			$args = array (
				'post_type' => 'any',
				'numberposts' => ($block_limit ? $block_limit : -1),
				'tax_query' => array(
					array(
						'taxonomy' => $taxonomy,
						'field'    => 'id',
						'terms'    => $term_id,
					),
				)
			);

			foreach( get_posts( $args ) as $post )
			{
				$found_postids[] = $post->ID;
			}

			$unique_item_class = 'block-posts-class-'.get_term($term_id)->slug;
		}


	break;
	//////////////////////////////////////////////////////////
	case 'author':

		$args = array (
			'author'      => $block_filter_author,
			'numberposts' => ($block_limit ? $block_limit : -1),
		);

		foreach( get_posts( $args ) as $post )
		{
			$found_postids[] = $post->ID;
		}

	break;
	//////////////////////////////////////////////////////////
	case 'custom':

		$found_postids = $block_filter_custom;

		$order_by = 'post__in';

	break;
}

if($found_postids)
{
	$args = array(
		'post_type' => 'any',
		'posts_per_page' => $block_limit,
		'post__in' => $found_postids,
	);

	if(!empty($order_by))
	{
		$args['orderby'] = $order_by;
	}

	$block_posts = new WP_Query($args);
}

?>

<div class="block-inner block-posts-filter-<?php echo $block_filter;?> <?php echo $unique_item_class;?>">

	<?php if($block_title || $block_view_more_link_url){ ?>
	<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?> block-posts-title-container">
		<div class="<?php echo GRAV_BLOCKS::css()->col(12)->get();?> block-posts-title-content">
			<?php if($block_title){?>
				<h2 class="block-posts-title"><?php echo $block_title;?></h2>
			<?php } ?>

			<?php if($block_view_more_link_url){?>
				<a class="block-posts-view-more-link" href="<?php echo $block_view_more_link_url;?>"><?php echo $block_view_more_link_text;?></a>
			<?php } ?>
		</div>
	</div>
	<?php } ?>

	<div class="<?php echo GRAV_BLOCKS::css()->row()->get();?> block-posts">

		<?php

		if(!empty($block_posts) && $block_posts->have_posts())
		{
			while($block_posts->have_posts())
			{
				$block_posts->the_post();
				$type_label = get_post_type_object(get_post_type())->labels->singular_name;
				if($block_filter === 'taxonomy' && $taxonomy)
				{
					$type_label = ucwords(get_term($term_id)->name);
				}

				?>

				<div class="<?php echo GRAV_BLOCKS::css()->col(12, 6, 4)->get();?> block-post">

					<div class="block-post-entry<?php if(has_post_thumbnail()){ ?> block-post-has-image<?php } ?>">
					    <a href="<?php the_permalink(); ?>" class="block-post-entry-link">

							<?php echo GRAV_BLOCKS::image('featured', array('class' => 'block-post-image'), 'div');?>

					        <div class="block-post-content">
					            <h6 class="block-post-meta">
									<?php if(get_post_type()==='post'){?>
										<span class="block-post-meta-by">By:</span>
										<span class="block-post-author"><?php the_author(); ?></span>
									<?php }else{ ?>
										<span class="block-post-type-label"><?php echo $type_label;?></span>
									<?php } ?>
									<span class="block-post-meta-separator">|</span>
									<span class="block-post-date"><?php echo get_the_date(); ?></span>
								</h6>
					            <p class="block-post-title"><?php the_title(); ?></p>
					        </div>

					    </a>
					</div>

				</div>


				<?php
			}
		}

		wp_reset_query();

		?>

	</div>
</div>
