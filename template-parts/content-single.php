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
		<?php if (get_option('copyright_post') || is_customize_preview()) : ?>
			<div class="copyright-post alert alert-success"><?php zan_copyright_post(); ?></div>
		<?php endif; ?>
		<?php zan_entry_tag_list(); ?>
	</footer>
</article>
<!-- 内容主体结束 -->