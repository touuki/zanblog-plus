<!-- 内容主体 -->
<article id="post-<?php the_ID(); ?>" <?php post_class('panel panel-default clearfix'); ?>>
	<header class="entry-header">
		<!-- 面包屑 -->
		<?php zan_breadcrumb(false); ?>
		<!-- 面包屑 -->
		<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
		<div class="entry-meta">
			<?php zan_entry_meta(); ?>
		</div>
	</header>

	<?php zan_post_thumbnail(); ?>
	<div class="entry-content">
		<?php the_content(); ?>

		<!-- 分页 -->
		<div class="zan-page">
			<ul class="pager">
				<li class="previous"><?php previous_post_link('%link', '上一篇', TRUE); ?></li>
				<li class="next"><?php next_post_link('%link', '下一篇', TRUE); ?></li>
			</ul>
		</div>
		<!-- 分页 -->

		<!-- 文章版权信息 -->
		<div class="copyright alert alert-success">
			<p>
				版权属于:
				<?php
				if (get_post_meta($post->ID, "版权属于", true)) {
					echo get_post_meta($post->ID, "版权属于", true);
				} else {
					echo '<a href="';
					bloginfo('url');
					echo '">';
					bloginfo('name');
					echo '</a>';
				}
				?>
			</p>
			<p>
				原文地址:
				<?php
				if (get_post_meta($post->ID, "原文地址", true)) {
					echo get_post_meta($post->ID, "原文地址", true);
				} else {
					echo '<a href="';
					echo the_permalink() . '">';
					echo the_permalink() . '</a>';
				}
				?>
			</p>
			<p>转载时必须以链接形式注明原始出处及本声明。</p>
		</div>
		<!-- 文章版权信息结束 -->
	</div>
</article>
<!-- 内容主体结束 -->

<!-- 相关文章 -->
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
		<div class="visible-md visible-lg panel panel-default" id="post-related">
			<div class="row">
				<div class="alert alert-danger related-title text-center"><i class="fa fa-heart"></i> 您可能也喜欢:</div>
				<?php
				while ($related_posts->have_posts()) :
					$related_posts->the_post();
				?>
					<div class="col-md-4">
						<div class="well clearfix">
							<p class="post-related-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></p>
							<div class="post-related-content">
								<?php the_excerpt(); ?>
							</div>
							<a class="btn btn-danger pull-right more-link" href="<?php the_permalink(); ?>" title="详细阅读 <?php the_title_attribute(); ?>">阅读全文</a>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
<?php
		wp_reset_postdata();
	endif;
endif;
