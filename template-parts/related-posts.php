<?php

/**
 * The template part for displaying related posts
 *
 * @package ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 */
?>

<?php

$related_posts = new WP_Query(
	array(
		'post__not_in' => (array) $post->ID,
		'showposts' => 3,
		'ignore_sticky_posts' => true,
		'orderby' => 'rand',
		'has_password' => false
	)
);

if ($related_posts->have_posts()) :
?>
	<aside class="related-posts hidden-xs panel panel-default">
		<div class="alert alert-danger text-center"><i class="fas fa-heart"></i> <?php _e('Maybe you also like these', 'zanblog-plus'); ?></div>
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
						<a class="btn btn-danger pull-right more-link" href="<?php the_permalink(); ?>"><?php _e('Read more', 'zanblog-plus'); ?></a>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
	</aside>
<?php
	wp_reset_postdata();
endif;
