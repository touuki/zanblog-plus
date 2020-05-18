<?php
/**
 * The template part for displaying related posts
 *
 * @package ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 */
?>

<?php
$terms = get_the_category();
if ($terms) :
	$term_ids = array();
	foreach ($terms as $term) {
		$term_ids[] = $term->term_id;
	}

	$related_posts = new WP_Query(
		array(
			'category__in' => $term_ids,
			'post__not_in' => (array) $post->ID,
			'showposts' => 3,
			'ignore_sticky_posts' => true,
		)
	);

	if ($related_posts->have_posts()) :
?>
		<aside class="related-posts hidden-xs panel panel-default">
			<div class="alert alert-danger text-center"><i class="fas fa-heart"></i> <?php _e('Maybe you also like these','zanblog-plus'); ?></div>
			<div class="row">
				<?php
				while ($related_posts->have_posts()) :
					$related_posts->the_post();
				?>
					<div class="col-md-4">
						<div class="related-post well well-sm clearfix">
							<p class="related-post-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></p>
							<div class="related-post-content">
								<?php the_excerpt(); ?>
							</div>
							<a class="btn btn-danger pull-right more-link" href="<?php the_permalink(); ?>"><?php _e('Read more');?></a>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		</aside>
<?php
		wp_reset_postdata();
	endif;
endif;
