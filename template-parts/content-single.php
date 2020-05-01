<!-- 内容主体 -->
<article class="article panel panel-default">
	<header>
		<!-- 面包屑 -->
		<?php zan_breadcrumb(false); ?>
		<!-- 面包屑 -->
		<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
		<div class="entry-meta">
			<span class="label label-meta"><i class="fa fa-calendar-alt"></i> <?php the_time('Y-m-d'); ?></span>
			<span class="label label-meta"><i class="fa fa-folder"></i> <?php the_category(','); ?></span>
			<span class="label label-meta"><i class="fa fa-user"></i> <?php the_author_posts_link(); ?></span>
			<?php if (function_exists('the_views')) : ?>
				<span class="label label-meta">
					<i class="fa fa-eye"></i> <?php the_views(); ?>
				</span>
			<?php endif; ?>
			<?php edit_post_link('<span class="label label-meta"><i class="fa fa-edit"></i> 编辑', ' ', '</span>'); ?>
		</div>
	</header>

	<div class="centent-article">
		<figure class="thumbnail hidden-xs"><?php the_post_thumbnail('full'); ?></figure>
		<?php the_content(); ?>

		<!-- 分页 -->
		<div class="zan-page bs-example">
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
<div class="bs-example visible-md visible-lg panel panel-default" id="post-related">
	<div class="row">
		<div class="alert alert-danger related-title text-center"><i class="fa fa-heart"></i> 您可能也喜欢:</div>
		<?php
		global $post;
		$cats = wp_get_post_categories($post->ID);

		if ($cats) {
			$args = array(
				'category__in' => array($cats[0]),
				'post__not_in' => array($post->ID),
				'showposts' => 3,
			);
			query_posts($args);

			if (have_posts()) {
				while (have_posts()) {
					the_post();
					update_post_caches($posts); ?>
					<div class="col-md-4">
						<div class="thumbnail">
							<div class="caption clearfix">
								<p class="post-related-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></p>
								<p class="post-related-content"><?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 150, "..."); ?></p>
								<p><a class="btn btn-danger pull-right read-more" href="<?php the_permalink() ?>" title="详细阅读 <?php the_title(); ?>">阅读全文</a></p>
							</div>
						</div>
					</div>
		<?php
				}
			}
			wp_reset_query();
		} ?>
	</div>
</div>
<!-- 相关文章结束 -->