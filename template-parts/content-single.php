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
		<?php
		the_content();
		
		wp_link_pages(
			array(
				'before'      => '<div class="page-links"><span class="page-links-title screen-reader-text">' . __('Pages:', 'default') . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __('Page', 'default') . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			)
		);
		?>
	</div>
	<?php
	if (is_singular('attachment')) {
		// Parent post navigation.
		the_post_navigation(
			array(
				'prev_text' => '<span class="meta-nav">' . __('Back to Parent Post', 'default') . '</span><span class="screen-reader-text">:%title</span>',
			)
		);
	} elseif (is_singular('post')) {
		// Previous/next post navigation.
		the_post_navigation(
			array(
				'next_text' => '<span class="meta-nav" aria-hidden="true">' . __('Next', 'default') . '</span> ' .
					'<span class="screen-reader-text">' . __('Next post:', 'default') . '%title</span> ',
				'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __('Previous', 'default') . '</span> ' .
					'<span class="screen-reader-text">' . __('Previous post:', 'default') . '%title</span> ',
				'in_same_term' => true,
			)
		);
	}
	?>
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