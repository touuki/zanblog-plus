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
		)
	);

	if ($related_posts->have_posts()) :
?>
		<aside class="related-posts hidden-xs panel panel-default">
			<div class="alert alert-danger text-center"><i class="fa fa-heart"></i> 您可能也喜欢:</div>
			<div class="row">
				<?php
				while ($related_posts->have_posts()) :
					$related_posts->the_post();
				?>
					<div class="col-md-4">
						<div class="related-post well clearfix">
							<p class="related-post-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></p>
							<div class="related-post-content">
								<?php the_excerpt(); ?>
							</div>
							<a class="btn btn-danger pull-right more-link" href="<?php the_permalink(); ?>" title="详细阅读 <?php the_title_attribute(); ?>">阅读全文</a>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		</aside>
<?php
		wp_reset_postdata();
	endif;
endif;
