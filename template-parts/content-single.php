<!-- 内容主体 -->
<article id="post-<?php the_ID(); ?>" <?php post_class('article panel panel-default clearfix'); ?>>
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
	</div>
	<!-- 分页 -->
	<nav class="zan-page">
		<ul class="pager">
			<li class="previous"><?php previous_post_link('%link', '上一篇', TRUE); ?></li>
			<li class="next"><?php next_post_link('%link', '下一篇', TRUE); ?></li>
		</ul>
	</nav>
	<!-- 分页 -->
	<footer>
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
		<?php zan_entry_tag_list(); ?>
	</footer>
</article>
<!-- 内容主体结束 -->

